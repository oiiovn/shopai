<?php
/**
 * Cron Job: Pay2S Real API Only
 * Chỉ sử dụng Pay2S API thật, không có dữ liệu mô phỏng
 */

// Thiết lập timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Log file
$logFile = __DIR__ . '/logs/cron-pay2s-real-only.log';

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

// Hàm extract QR Code từ nội dung chuyển khoản
function extractQRCode($description) {
    $parts = explode(' ', trim($description));
    return $parts[0] ?? '';
}

// Hàm tìm user dựa trên QR Code
function findUserByQRCode($qrCode) {
    $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"SELECT user_id FROM qr_code_mapping WHERE qr_code = '$qrCode' AND status = 'active' AND expires_at > NOW() LIMIT 1;\"";
    $output = shell_exec($cmd);
    
    if ($output && preg_match('/\d+/', $output, $matches)) {
        return intval($matches[0]);
    }
    
    return null;
}

// Hàm đánh dấu QR Code đã sử dụng
function markQRCodeAsUsed($qrCode) {
    $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"UPDATE qr_code_mapping SET status = 'used' WHERE qr_code = '$qrCode';\"";
    shell_exec($cmd);
}

// Hàm lấy giao dịch từ Pay2S API thật
function fetchPay2SRealTransactions() {
    try {
        // Load Pay2S configuration
        $config = include __DIR__ . '/pay2s-config.php';
        
        $url = $config['api_url'] . '/transactions';
        
        // Tham số API theo tài liệu chính thức
        $params = [
            'bankAccounts' => $config['account_number'], // 46241987
            'begin' => date('d/m/Y', strtotime('-1 day')), // Hôm qua
            'end' => date('d/m/Y') // Hôm nay
        ];
        
        // Headers theo tài liệu (sử dụng Base64 của Secret Key)
        $pay2sToken = base64_encode($config['webhook_secret']); // Base64 của Secret Key
        $headers = [
            'Content-Type: application/json',
            'pay2s-token: ' . $pay2sToken,
            'Accept: application/json'
        ];
        
        writeLog("Request URL: $url");
        writeLog("Request Params: " . json_encode($params));
        
        // CURL request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Pay2S-Client/1.0');
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            writeLog("CURL Error: " . $error);
            return [];
        }
        
        writeLog("HTTP Code: $httpCode");
        writeLog("Response: " . substr($response, 0, 500) . "...");
        
        if ($httpCode !== 200) {
            writeLog("HTTP Error: " . $httpCode . " - " . $response);
            return [];
        }
        
        $data = json_decode($response, true);
        
        if (!$data || !$data['status']) {
            writeLog("Pay2S API Error: " . ($data['messages'] ?? 'Unknown error'));
            return [];
        }
        
        $transactions = $data['transactions'] ?? [];
        writeLog("Nhận được " . count($transactions) . " giao dịch từ Pay2S API thật");
        
        return $transactions;
        
    } catch (Exception $e) {
        writeLog("Lỗi khi lấy giao dịch từ Pay2S: " . $e->getMessage());
        return [];
    }
}

// Hàm lưu giao dịch vào database
function savePay2SRealTransaction($transaction) {
    try {
        // Kiểm tra giao dịch đã tồn tại chưa
        $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"SELECT id FROM bank_transactions WHERE transaction_id = '{$transaction['transaction_id']}';\"";
        $output = shell_exec($cmd);
        
        if ($output && strpos($output, 'id') !== false) {
            writeLog("Giao dịch {$transaction['transaction_id']} đã tồn tại, bỏ qua");
            return false;
        }
        
        // Lưu giao dịch mới
        $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"INSERT INTO bank_transactions (transaction_id, amount, description, bank, account_number, type, status, transaction_date, created_at) VALUES ('{$transaction['transaction_id']}', {$transaction['amount']}, '{$transaction['description']}', '{$transaction['bank']}', '{$transaction['account_number']}', '{$transaction['type']}', 'pending', '{$transaction['transaction_date']}', NOW());\"";
        shell_exec($cmd);
        
        writeLog("✅ Đã lưu giao dịch Pay2S thật: {$transaction['transaction_id']} - " . number_format($transaction['amount']) . " VNĐ");
        
        return true;
        
    } catch (Exception $e) {
        writeLog("❌ Lỗi lưu giao dịch Pay2S: " . $e->getMessage());
        return false;
    }
}

// Bắt đầu cron job
writeLog("=== Bắt đầu cron job Pay2S Real API Only ===");

try {
    // Bước 1: Lấy giao dịch từ Pay2S API thật
    writeLog("1. Lấy giao dịch từ Pay2S API thật...");
    $pay2sTransactions = fetchPay2SRealTransactions();
    
    // Nếu không có giao dịch thật, kết thúc
    if (empty($pay2sTransactions)) {
        writeLog("Không có giao dịch Pay2S thật mới, kết thúc cron job");
        writeLog("=== Hoàn thành cron job Pay2S Real API Only ===");
        exit(0);
    }
    
    // Bước 2: Lưu giao dịch vào database
    $saved = 0;
    foreach ($pay2sTransactions as $transaction) {
        try {
            if (savePay2SRealTransaction($transaction)) {
                $saved++;
            }
        } catch (Exception $e) {
            writeLog("❌ Lỗi lưu giao dịch Pay2S: " . $e->getMessage());
        }
    }
    
    writeLog("Đã lưu $saved/" . count($pay2sTransactions) . " giao dịch Pay2S thật mới");
    
    // Bước 3: Xử lý giao dịch pending
    writeLog("2. Xử lý giao dịch pending...");
    
    $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"SELECT id, user_id, transaction_id, amount, description FROM bank_transactions WHERE status = 'pending' ORDER BY transaction_date ASC;\"";
    $output = shell_exec($cmd);
    
    if (empty($output) || strpos($output, 'id') === false) {
        writeLog("Không có giao dịch pending nào để xử lý");
    } else {
        // Parse output
        $lines = explode("\n", trim($output));
        $transactions = [];
        
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (empty($line)) continue;
            
            $parts = preg_split('/\s+/', $line);
            if (count($parts) >= 5) {
                $transactions[] = [
                    'id' => $parts[0],
                    'user_id' => $parts[1],
                    'transaction_id' => $parts[2],
                    'amount' => $parts[3],
                    'description' => implode(' ', array_slice($parts, 4))
                ];
            }
        }
        
        writeLog("Tìm thấy " . count($transactions) . " giao dịch pending để xử lý");
        
        $processed = 0;
        $failed = 0;
        
        foreach ($transactions as $transaction) {
            try {
                // Extract QR Code từ nội dung
                $qrCode = extractQRCode($transaction['description']);
                writeLog("QR Code extracted: $qrCode");
                
                // Tìm user dựa trên QR Code
                $userId = findUserByQRCode($qrCode);
                
                if (!$userId) {
                    writeLog("❌ Không tìm thấy user cho QR Code: $qrCode");
                    $failed++;
                    continue;
                }
                
                writeLog("✅ Tìm thấy user $userId cho QR Code: $qrCode");
                
                // Cập nhật user_id cho giao dịch
                $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"UPDATE bank_transactions SET user_id = $userId WHERE id = {$transaction['id']};\"";
                shell_exec($cmd);
                
                // Cập nhật trạng thái giao dịch
                $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"UPDATE bank_transactions SET status = 'matched' WHERE id = {$transaction['id']};\"";
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
                $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"INSERT INTO balance_transactions (user_id, reference, transaction_type, amount, balance_before, balance_after, description, status, created_at) VALUES ($userId, '{$transaction['transaction_id']}', 'deposit', {$transaction['amount']}, $currentBalance, $newBalance, '{$transaction['description']}', 'completed', NOW());\"";
                shell_exec($cmd);
                
                // Gửi thông báo cho user
                $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"INSERT INTO notifications (to_user_id, from_user_id, action, node_type, node_url, message, time, seen) VALUES ($userId, 0, 'deposit_success', 'wallet', '/shop-ai.php', 'Nạp tiền thành công: " . number_format($transaction['amount']) . " VNĐ. Số dư hiện tại: " . number_format($newBalance) . " VNĐ', NOW(), '0');\"";
                shell_exec($cmd);
                
                // Đánh dấu QR Code đã sử dụng
                markQRCodeAsUsed($qrCode);
                
                $processed++;
                writeLog("✅ Đã xử lý giao dịch: {$transaction['transaction_id']} - " . number_format($transaction['amount']) . " VNĐ - User: $userId");
                
            } catch (Exception $e) {
                writeLog("❌ Lỗi xử lý giao dịch {$transaction['transaction_id']}: " . $e->getMessage());
                $failed++;
            }
        }
        
        writeLog("Đã xử lý $processed/" . count($transactions) . " giao dịch thành công");
        writeLog("Thất bại: $failed giao dịch");
    }
    
    writeLog("=== Hoàn thành cron job Pay2S Real API Only ===");
    
} catch (Exception $e) {
    writeLog("Lỗi: " . $e->getMessage());
    writeLog("Stack trace: " . $e->getTraceAsString());
    exit(1);
}

exit(0);
?>
