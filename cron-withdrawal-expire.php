#!/usr/bin/env php
<?php
/**
 * Cron Job: Expire Withdrawal Requests
 * Tự động expire và refund các yêu cầu rút tiền đã hết hạn
 * 
 * Chạy mỗi 5 phút: */5 * * * *
 */

// Thiết lập timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Load database config
require_once(__DIR__ . '/bootloader.php');

// Log file
$logFile = __DIR__ . '/logs/withdrawal-expire.log';

// Tạo thư mục logs nếu chưa có
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}

// Hàm ghi log
function writeLog($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
    echo "[$timestamp] $message\n";
}

writeLog("=== Bắt đầu kiểm tra withdrawal requests hết hạn ===");

try {
    // Connect database
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Tìm các withdrawal requests hết hạn
    $stmt = $pdo->prepare("
        SELECT qr_id, qr_code, user_id, amount, fee, created_at, expires_at
        FROM qr_code_mapping 
        WHERE transaction_type = 'withdrawal' 
        AND status = 'active' 
        AND expires_at < NOW()
        ORDER BY created_at ASC
    ");
    $stmt->execute();
    $expiredWithdrawals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($expiredWithdrawals) === 0) {
        writeLog("Không có withdrawal request nào hết hạn");
        writeLog("=== Kết thúc ===");
        exit(0);
    }
    
    writeLog("Tìm thấy " . count($expiredWithdrawals) . " withdrawal requests hết hạn");
    
    $refundedCount = 0;
    $refundedTotal = 0;
    
    foreach ($expiredWithdrawals as $withdrawal) {
        try {
            $qrCode = $withdrawal['qr_code'];
            $userId = $withdrawal['user_id'];
            $refundAmount = $withdrawal['amount'];
            
            writeLog("Processing: $qrCode - User $userId - Amount: " . number_format($refundAmount));
            
            // Refund balance
            $stmt = $pdo->prepare("UPDATE users SET user_wallet_balance = user_wallet_balance + ? WHERE user_id = ?");
            $stmt->execute([$refundAmount, $userId]);
            
            // Update status to expired
            $stmt = $pdo->prepare("UPDATE qr_code_mapping SET status = 'expired', updated_at = NOW() WHERE qr_id = ?");
            $stmt->execute([$withdrawal['qr_id']]);
            
            // Log refund transaction
            $stmt = $pdo->prepare("
                INSERT INTO users_wallets_transactions (user_id, type, amount, description, time) 
                VALUES (?, 'withdraw_expired_refund', ?, ?, NOW())
            ");
            $stmt->execute([$userId, $refundAmount, "Hoàn tiền rút hết hạn - $qrCode"]);
            
            $refundedCount++;
            $refundedTotal += $refundAmount;
            
            writeLog("✅ Refunded: $qrCode - " . number_format($refundAmount) . " VNĐ to User $userId");
            
        } catch (Exception $e) {
            writeLog("❌ Error processing $qrCode: " . $e->getMessage());
            continue;
        }
    }
    
    writeLog("=== Tổng kết ===");
    writeLog("Đã xử lý: $refundedCount withdrawal requests");
    writeLog("Tổng tiền hoàn: " . number_format($refundedTotal) . " VNĐ");
    writeLog("=== Kết thúc ===");
    
} catch (Exception $e) {
    writeLog("❌ Fatal Error: " . $e->getMessage());
    exit(1);
}

exit(0);

