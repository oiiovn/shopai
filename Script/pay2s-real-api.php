<?php
/**
 * Pay2S Real API Handler
 * Lấy giao dịch thật từ Pay2S API theo tài liệu chính thức
 */

// Thiết lập timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Log file
$logFile = __DIR__ . '/logs/pay2s-real-api.log';

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

// Hàm lấy giao dịch từ Pay2S API thật
function fetchPay2SRealTransactions() {
    global $config;
    
    try {
        $url = $config['api_url'] . '/transactions';
        
        // Tham số API theo tài liệu
        $params = [
            'bankAccounts' => $config['account_number'], // 46241987
            'begin' => date('d/m/Y', strtotime('-1 day')), // Hôm qua
            'end' => date('d/m/Y') // Hôm nay
        ];
        
        // Headers theo tài liệu
        $headers = [
            'Content-Type: application/json',
            'pay2s-token: ' . $config['pay2s_token']
        ];
        
        writeLog("Request URL: $url");
        writeLog("Request Params: " . json_encode($params));
        writeLog("Request Headers: " . json_encode($headers));
        
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
        
        if (strpos($output, 'id') !== false) {
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

// Main execution
writeLog("=== Bắt đầu lấy giao dịch từ Pay2S API thật ===");

try {
    // Lấy giao dịch từ Pay2S API
    $transactions = fetchPay2SRealTransactions();
    
    $saved = 0;
    foreach ($transactions as $transaction) {
        if (savePay2SRealTransaction($transaction)) {
            $saved++;
        }
    }
    
    writeLog("Đã lưu $saved/" . count($transactions) . " giao dịch Pay2S thật mới");
    writeLog("=== Hoàn thành lấy giao dịch từ Pay2S API thật ===");
    
    echo "Đã lưu $saved/" . count($transactions) . " giao dịch Pay2S thật mới\n";
    
} catch (Exception $e) {
    writeLog("Lỗi: " . $e->getMessage());
    echo "Lỗi: " . $e->getMessage() . "\n";
}
?>

