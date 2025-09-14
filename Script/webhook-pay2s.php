<?php
/**
 * Pay2S Webhook Handler
 * Nhận giao dịch thật từ Pay2S qua webhook
 */

// Thiết lập timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Log file
$logFile = __DIR__ . '/logs/pay2s-webhook.log';

// Tạo thư mục logs nếu chưa có
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}

// Hàm ghi log
function writeLog($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
}

// Load Pay2S configuration
$config = include __DIR__ . '/pay2s-config.php';

// Hàm extract QR Code từ nội dung chuyển khoản
function extractQRCode($description) {
    $parts = explode(' ', trim($description));
    return $parts[0] ?? '';
}

// Hàm tìm user dựa trên QR Code
function findUserByQRCode($qrCode) {
    $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"SELECT user_id FROM qr_code_mapping WHERE qr_code = '$qrCode' AND status = 'active' AND expires_at > NOW() LIMIT 1;\"";
    $output = shell_exec($cmd);
    
    if (preg_match('/\d+/', $output, $matches)) {
        return intval($matches[0]);
    }
    
    return null;
}

// Hàm lưu giao dịch vào database
function saveWebhookTransaction($transaction) {
    $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"INSERT INTO bank_transactions (transaction_id, amount, description, bank, account_number, type, status, transaction_date, created_at) VALUES ('{$transaction['transaction_id']}', {$transaction['amount']}, '{$transaction['description']}', 'ACB', '46241987', 'in', 'pending', '{$transaction['transaction_date']}', NOW());\"";
    shell_exec($cmd);
}

// Hàm xử lý giao dịch webhook
function processWebhookTransaction($transaction) {
    try {
        // Extract QR Code từ nội dung
        $qrCode = extractQRCode($transaction['description']);
        writeLog("Webhook - QR Code extracted: $qrCode");
        
        // Tìm user dựa trên QR Code
        $userId = findUserByQRCode($qrCode);
        
        if (!$userId) {
            writeLog("Webhook - Không tìm thấy user cho QR Code: $qrCode");
            return false;
        }
        
        writeLog("Webhook - Tìm thấy user $userId cho QR Code: $qrCode");
        
        // Lưu giao dịch
        saveWebhookTransaction($transaction);
        
        // Cập nhật user_id cho giao dịch
        $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"UPDATE bank_transactions SET user_id = $userId WHERE transaction_id = '{$transaction['transaction_id']}';\"";
        shell_exec($cmd);
        
        // Cập nhật trạng thái giao dịch
        $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"UPDATE bank_transactions SET status = 'matched' WHERE transaction_id = '{$transaction['transaction_id']}';\"";
        shell_exec($cmd);
        
        // Lấy số dư hiện tại
        $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"SELECT balance FROM users WHERE user_id = $userId;\"";
        $output = shell_exec($cmd);
        $currentBalance = 0;
        if (preg_match('/\d+\.?\d*/', $output, $matches)) {
            $currentBalance = floatval($matches[0]);
        }
        
        // Cập nhật số dư mới
        $newBalance = $currentBalance + $transaction['amount'];
        $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"UPDATE users SET balance = $newBalance WHERE user_id = $userId;\"";
        shell_exec($cmd);
        
        // Ghi log biến động số dư
        $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"INSERT INTO balance_transactions (user_id, reference, transaction_type, amount, balance_before, balance_after, description, status, created_at) VALUES ($userId, '{$transaction['transaction_id']}', 'deposit', {$transaction['amount']}, $currentBalance, $newBalance, 'Nạp tiền từ Pay2S Webhook - {$transaction['description']}', 'completed', NOW());\"";
        shell_exec($cmd);
        
        // Đánh dấu QR Code đã sử dụng
        $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"UPDATE qr_code_mapping SET status = 'used' WHERE qr_code = '$qrCode';\"";
        shell_exec($cmd);
        
        writeLog("Webhook - ✅ Đã xử lý giao dịch: {$transaction['transaction_id']} - " . number_format($transaction['amount']) . " VNĐ - User: $userId");
        
        return true;
        
    } catch (Exception $e) {
        writeLog("Webhook - ❌ Lỗi xử lý giao dịch: " . $e->getMessage());
        return false;
    }
}

// Main webhook handler
writeLog("=== Pay2S Webhook Received ===");

try {
    // Lấy dữ liệu webhook
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data) {
        $data = $_POST;
    }
    
    writeLog("Webhook data: " . json_encode($data));
    
    // Xác thực webhook signature (nếu có)
    $signature = $_SERVER['HTTP_X_PAY2S_SIGNATURE'] ?? '';
    if ($signature) {
        $expectedSignature = hash_hmac('sha256', $input, $config['webhook_secret']);
        if (!hash_equals($signature, $expectedSignature)) {
            writeLog("Webhook - Invalid signature");
            http_response_code(400);
            echo json_encode(['error' => 'Invalid signature']);
            exit;
        }
    }
    
    // Xử lý giao dịch
    if (isset($data['event']) && $data['event'] === 'transaction.completed') {
        $transaction = $data['data'];
        processWebhookTransaction($transaction);
    } elseif (isset($data['transaction_id'])) {
        // Giao dịch trực tiếp
        processWebhookTransaction($data);
    } else {
        writeLog("Webhook - Unknown data format");
    }
    
    http_response_code(200);
    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    writeLog("Webhook - Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>

