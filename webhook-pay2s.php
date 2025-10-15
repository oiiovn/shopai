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
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=sho73359_shopqi", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT user_id, transaction_type FROM qr_code_mapping WHERE qr_code = ? AND status = 'active' AND expires_at > NOW() LIMIT 1");
        $stmt->execute([$qrCode]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return [
                'user_id' => intval($result['user_id']),
                'transaction_type' => $result['transaction_type']
            ];
        }
        
        return null;
    } catch (Exception $e) {
        writeLog("Error finding user by QR: " . $e->getMessage());
        return null;
    }
}

// Hàm xử lý giao dịch rút tiền (withdrawal)
function processWithdrawal($qrCode, $transaction) {
    try {
        writeLog("Withdrawal - Processing QR: $qrCode");
        
        $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=sho73359_shopqi", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Find withdrawal request
        $stmt = $pdo->prepare("
            SELECT qr_id, user_id, amount, fee, withdrawal_account_number 
            FROM qr_code_mapping 
            WHERE qr_code = ? AND transaction_type = 'withdrawal' AND status = 'active' AND expires_at > NOW()
            LIMIT 1
        ");
        $stmt->execute([$qrCode]);
        $withdrawal = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$withdrawal) {
            writeLog("Withdrawal - Not found or expired: $qrCode");
            return false;
        }
        
        $userId = $withdrawal['user_id'];
        $expectedAmount = $withdrawal['amount'] - $withdrawal['fee'];
        
        // Verify amount (Pay2S trả về số âm cho withdrawal, lấy abs)
        $transactionAmount = abs($transaction['amount']);
        
        if (abs($transactionAmount - $expectedAmount) > 1) {
            writeLog("Withdrawal - Amount mismatch: Expected $expectedAmount, Got $transactionAmount");
            
            // Refund vì sai số tiền
            $stmt = $pdo->prepare("UPDATE users SET user_wallet_balance = user_wallet_balance + ? WHERE user_id = ?");
            $stmt->execute([$withdrawal['amount'], $userId]);
            
            $stmt = $pdo->prepare("UPDATE qr_code_mapping SET status = 'failed', updated_at = NOW() WHERE qr_code = ?");
            $stmt->execute([$qrCode]);
            
            writeLog("Withdrawal - ❌ Failed and refunded: $qrCode");
            return false;
        }
        
        // Complete withdrawal
        $stmt = $pdo->prepare("UPDATE qr_code_mapping SET status = 'used', updated_at = NOW() WHERE qr_code = ?");
        $stmt->execute([$qrCode]);
        
        // Save bank transaction
        $stmt = $pdo->prepare("
            INSERT INTO bank_transactions 
            (transaction_id, amount, description, bank, account_number, type, status, transaction_date, user_id, created_at) 
            VALUES (?, ?, ?, 'ACB', '46241987', 'out', 'completed', ?, ?, NOW())
        ");
        $stmt->execute([
            $transaction['transaction_id'],
            $transactionAmount,
            $transaction['description'],
            $transaction['transaction_date'] ?? date('Y-m-d H:i:s'),
            $userId
        ]);
        
        // Log withdrawal completion
        $stmt = $pdo->prepare("
            INSERT INTO users_wallets_transactions (user_id, type, amount, description, time) 
            VALUES (?, 'withdraw_completed', ?, ?, NOW())
        ");
        $stmt->execute([$userId, $withdrawal['amount'], "Rút tiền thành công - $qrCode"]);
        
        writeLog("Withdrawal - ✅ Completed: $qrCode - User $userId - " . number_format($transactionAmount) . " VNĐ");
        
        return true;
        
    } catch (Exception $e) {
        writeLog("Withdrawal - ❌ Error: " . $e->getMessage());
        return false;
    }
}

// Hàm xử lý giao dịch webhook
function processWebhookTransaction($transaction) {
    try {
        // Extract QR Code từ nội dung
        $qrCode = extractQRCode($transaction['description']);
        writeLog("Webhook - QR Code extracted: $qrCode");
        
        // Tìm user dựa trên QR Code
        $qrData = findUserByQRCode($qrCode);
        
        if (!$qrData) {
            writeLog("Webhook - Không tìm thấy QR Code: $qrCode");
            return false;
        }
        
        $userId = $qrData['user_id'];
        $transactionType = $qrData['transaction_type'];
        
        writeLog("Webhook - Found User $userId - Type: $transactionType - QR: $qrCode");
        
        // Xử lý theo loại giao dịch
        if ($transactionType === 'withdrawal') {
            // Xử lý rút tiền
            return processWithdrawal($qrCode, $transaction);
        } else {
            // Xử lý nạp tiền (deposit) - Logic cũ
            return processDeposit($userId, $qrCode, $transaction);
        }
        
    } catch (Exception $e) {
        writeLog("Webhook - ❌ Lỗi xử lý: " . $e->getMessage());
        return false;
    }
}

// Hàm xử lý nạp tiền (deposit) - Tách ra từ logic cũ
function processDeposit($userId, $qrCode, $transaction) {
    try {
        writeLog("Deposit - Processing for User $userId");
        
        $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=sho73359_shopqi", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Save bank transaction
        $stmt = $pdo->prepare("
            INSERT INTO bank_transactions 
            (transaction_id, amount, description, bank, account_number, type, status, transaction_date, user_id, created_at) 
            VALUES (?, ?, ?, 'ACB', '46241987', 'in', 'completed', ?, ?, NOW())
        ");
        $stmt->execute([
            $transaction['transaction_id'],
            $transaction['amount'],
            $transaction['description'],
            $transaction['transaction_date'] ?? date('Y-m-d H:i:s'),
            $userId
        ]);
        
        // Cập nhật số dư user
        $stmt = $pdo->prepare("UPDATE users SET user_wallet_balance = user_wallet_balance + ? WHERE user_id = ?");
        $stmt->execute([$transaction['amount'], $userId]);
        
        // Log transaction
        $stmt = $pdo->prepare("
            INSERT INTO users_wallets_transactions (user_id, type, amount, description, time) 
            VALUES (?, 'recharge', ?, ?, NOW())
        ");
        $stmt->execute([$userId, $transaction['amount'], "Nạp tiền - $qrCode"]);
        
        // Đánh dấu QR Code đã sử dụng
        $stmt = $pdo->prepare("UPDATE qr_code_mapping SET status = 'used', updated_at = NOW() WHERE qr_code = ?");
        $stmt->execute([$qrCode]);
        
        writeLog("Deposit - ✅ Completed: {$transaction['transaction_id']} - " . number_format($transaction['amount']) . " VNĐ - User: $userId");
        
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

