<?php
/**
 * Cron Job: Tự động kiểm tra giao dịch ngân hàng
 * Chạy mỗi 5 phút để kiểm tra giao dịch mới từ Pay2S
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
writeLog("=== Bắt đầu cron job kiểm tra giao dịch ngân hàng ===");

try {
    // Include required files
    require_once(__DIR__ . '/bootloader.php');
    require_once(__DIR__ . '/bank-transaction.php');
    
    writeLog("Đã load các file cần thiết");
    
    // Khởi tạo handler
    $handler = new BankTransactionHandler();
    writeLog("Đã khởi tạo BankTransactionHandler");
    
    // Lấy giao dịch từ Pay2S (7 ngày gần nhất)
    $fromDate = date('Y-m-d', strtotime('-7 days'));
    $toDate = date('Y-m-d');
    
    writeLog("Đang lấy giao dịch từ Pay2S từ $fromDate đến $toDate");
    
    $bankTransactions = $handler->fetchBankTransactions('970416', $fromDate, $toDate);
    
    if ($bankTransactions === false) {
        writeLog("Lỗi: Không thể lấy giao dịch từ Pay2S");
        exit(1);
    }
    
    writeLog("Đã lấy được " . count($bankTransactions) . " giao dịch từ Pay2S");
    
    // Lưu các giao dịch mới vào database
    $newTransactions = 0;
    foreach ($bankTransactions as $transaction) {
        $saved = $handler->saveBankTransaction($transaction);
        if ($saved) {
            $newTransactions++;
            writeLog("Đã lưu giao dịch mới: " . $transaction['transaction_id'] . " - " . number_format($transaction['amount']) . " VNĐ");
        }
    }
    
    writeLog("Đã lưu $newTransactions giao dịch mới");
    
    // Xử lý các giao dịch chưa xử lý
    writeLog("Đang xử lý các giao dịch chưa xử lý...");
    $processed = $handler->processNewTransactions();
    
    if ($processed !== false) {
        writeLog("Đã xử lý $processed giao dịch");
    } else {
        writeLog("Lỗi: Không thể xử lý giao dịch");
        // Thêm debug info
        $error = error_get_last();
        if ($error) {
            writeLog("PHP Error: " . $error['message']);
        }
    }
    
    writeLog("=== Hoàn thành cron job ===");
    
} catch (Exception $e) {
    writeLog("Lỗi: " . $e->getMessage());
    writeLog("Stack trace: " . $e->getTraceAsString());
    exit(1);
}

// Thống kê cuối
$logContent = file_get_contents($logFile);
$totalRuns = substr_count($logContent, '=== Bắt đầu cron job kiểm tra giao dịch ngân hàng ===');
$successRuns = substr_count($logContent, '=== Hoàn thành cron job ===');

writeLog("Thống kê: Đã chạy $totalRuns lần, thành công $successRuns lần");

exit(0);
?>
