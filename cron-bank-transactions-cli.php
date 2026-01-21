<?php
/**
 * Cron Job: Tự động kiểm tra giao dịch ngân hàng (CLI Version)
 * Chạy mỗi 1 phút để kiểm tra giao dịch mới từ Pay2S
 * Sử dụng MySQL command line để xử lý giao dịch
 */

// Thiết lập timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Log file
$logFile = __DIR__ . '/logs/cron-bank-transactions.log';

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

// Bắt đầu cron job
writeLog("=== Bắt đầu cron job kiểm tra giao dịch ngân hàng (CLI) ===");

try {
    // Lấy tất cả giao dịch chưa xử lý
    $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"SELECT id, user_id, transaction_id, amount, description FROM bank_transactions WHERE status = 'pending' ORDER BY transaction_date ASC;\"";
    $output = shell_exec($cmd);
    
    if (empty($output) || strpos($output, 'id') === false) {
        writeLog("Không có giao dịch pending nào để xử lý");
        writeLog("=== Hoàn thành cron job ===");
        exit(0);
    }
    
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
    foreach ($transactions as $transaction) {
        try {
            // Cập nhật trạng thái giao dịch
            $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"UPDATE bank_transactions SET status = 'matched' WHERE id = {$transaction['id']};\"";
            shell_exec($cmd);
            
            // Lấy số dư hiện tại
            $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"SELECT balance FROM users WHERE user_id = {$transaction['user_id']};\"";
            $output = shell_exec($cmd);
            $currentBalance = 0;
            if (preg_match('/\d+\.?\d*/', $output, $matches)) {
                $currentBalance = floatval($matches[0]);
            }
            
            // Cập nhật số dư mới
            $newBalance = $currentBalance + $transaction['amount'];
            $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"UPDATE users SET balance = $newBalance WHERE user_id = {$transaction['user_id']};\"";
            shell_exec($cmd);
            
            // Ghi log biến động số dư
            $cmd = "/opt/homebrew/bin/mysql -u root -P 3306 db_mxh -e \"INSERT INTO balance_transactions (user_id, reference, transaction_type, amount, balance_before, balance_after, description, status, created_at) VALUES ({$transaction['user_id']}, '{$transaction['transaction_id']}', 'deposit', {$transaction['amount']}, $currentBalance, $newBalance, 'Nạp tiền từ ngân hàng - {$transaction['description']}', 'completed', NOW());\"";
            shell_exec($cmd);
            
            $processed++;
            writeLog("✅ Đã xử lý giao dịch: {$transaction['transaction_id']} - " . number_format($transaction['amount']) . " VNĐ - User: {$transaction['user_id']}");
            
        } catch (Exception $e) {
            writeLog("❌ Lỗi xử lý giao dịch {$transaction['transaction_id']}: " . $e->getMessage());
        }
    }
    
    writeLog("Đã xử lý $processed/" . count($transactions) . " giao dịch");
    writeLog("=== Hoàn thành cron job ===");
    
} catch (Exception $e) {
    writeLog("Lỗi: " . $e->getMessage());
    writeLog("Stack trace: " . $e->getTraceAsString());
    exit(1);
}

exit(0);
?>
