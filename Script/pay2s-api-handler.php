<?php
/**
 * Pay2S API Handler
 * Lấy giao dịch thật từ Pay2S API và lưu vào database
 */

// Thiết lập timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Log file
$logFile = __DIR__ . '/logs/pay2s-api.log';

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
$pay2sConfig = include __DIR__ . '/pay2s-config.php';

// Hàm tạo signature cho Pay2S API
function generateSignature($data, $secret) {
    ksort($data);
    $queryString = http_build_query($data);
    return hash_hmac('sha256', $queryString, $secret);
}

// Hàm gọi Pay2S API
function callPay2SAPI($endpoint, $params = []) {
    global $pay2sConfig;
    
    $url = $pay2sConfig['api_url'] . $endpoint;
    
    // Thêm timestamp và nonce
    $params['timestamp'] = time();
    $params['nonce'] = uniqid();
    
    // Tạo signature
    $params['signature'] = generateSignature($params, $pay2sConfig['api_secret']);
    
    // Headers
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $pay2sConfig['api_key'],
        'X-API-Version: 1.0'
    ];
    
    // CURL request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        throw new Exception("CURL Error: " . $error);
    }
    
    if ($httpCode !== 200) {
        throw new Exception("HTTP Error: " . $httpCode . " - " . $response);
    }
    
    return json_decode($response, true);
}

// Hàm lấy giao dịch từ Pay2S
function fetchTransactionsFromPay2S() {
    global $pay2sConfig;
    
    try {
        writeLog("=== Bắt đầu lấy giao dịch từ Pay2S API ===");
        
        // Lấy giao dịch trong 24h qua
        $params = [
            'account_number' => $pay2sConfig['account_number'],
            'bank_code' => $pay2sConfig['bank_code'],
            'from_date' => date('Y-m-d H:i:s', strtotime('-24 hours')),
            'to_date' => date('Y-m-d H:i:s'),
            'status' => 'completed',
            'limit' => 100
        ];
        
        $response = callPay2SAPI('/list', $params);
        
        if (!$response['success']) {
            throw new Exception("Pay2S API Error: " . $response['message']);
        }
        
        $transactions = $response['data']['transactions'] ?? [];
        writeLog("Nhận được " . count($transactions) . " giao dịch từ Pay2S");
        
        return $transactions;
        
    } catch (Exception $e) {
        writeLog("Lỗi khi lấy giao dịch từ Pay2S: " . $e->getMessage());
        return [];
    }
}

// Hàm lưu giao dịch vào database
function saveTransactionToDatabase($transaction) {
    global $pay2sConfig;
    
    try {
        // Kết nối database
        $host = '127.0.0.1';
        $port = '3306';
        $dbname = 'db_mxh';
        $username = 'root';
        $password = '';
        
        $db = new mysqli($host, $username, $password, $dbname, $port);
        
        if ($db->connect_error) {
            throw new Exception("Database connection failed: " . $db->connect_error);
        }
        
        // Kiểm tra giao dịch đã tồn tại chưa
        $stmt = $db->prepare("SELECT id FROM bank_transactions WHERE transaction_id = ?");
        $stmt->bind_param('s', $transaction['transaction_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->fetch_assoc()) {
            writeLog("Giao dịch {$transaction['transaction_id']} đã tồn tại, bỏ qua");
            return false;
        }
        
        // Lưu giao dịch mới
        $stmt = $db->prepare("INSERT INTO bank_transactions (transaction_id, amount, description, bank, account_number, type, status, transaction_date, created_at) VALUES (?, ?, ?, ?, ?, ?, 'pending', ?, NOW())");
        
        $type = $transaction['amount'] > 0 ? 'in' : 'out';
        $amount = abs($transaction['amount']);
        $description = $transaction['description'] ?? '';
        $bank = 'ACB';
        $accountNumber = $pay2sConfig['account_number'];
        $transactionDate = $transaction['transaction_date'] ?? date('Y-m-d H:i:s');
        
        $stmt->bind_param('sdsssss', 
            $transaction['transaction_id'], 
            $amount, 
            $description, 
            $bank, 
            $accountNumber, 
            $type, 
            $transactionDate
        );
        
        $stmt->execute();
        
        writeLog("✅ Đã lưu giao dịch: {$transaction['transaction_id']} - " . number_format($amount) . " VNĐ");
        
        return true;
        
    } catch (Exception $e) {
        writeLog("❌ Lỗi lưu giao dịch: " . $e->getMessage());
        return false;
    }
}

// Hàm xử lý webhook từ Pay2S
function handlePay2SWebhook() {
    try {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data) {
            throw new Exception("Invalid JSON data");
        }
        
        writeLog("Nhận webhook từ Pay2S: " . json_encode($data));
        
        // Xác thực webhook signature
        $signature = $_SERVER['HTTP_X_PAY2S_SIGNATURE'] ?? '';
        $expectedSignature = hash_hmac('sha256', $input, $pay2sConfig['api_secret']);
        
        if (!hash_equals($signature, $expectedSignature)) {
            throw new Exception("Invalid webhook signature");
        }
        
        // Xử lý giao dịch
        if ($data['event'] === 'transaction.completed') {
            $transaction = $data['data'];
            saveTransactionToDatabase($transaction);
        }
        
        http_response_code(200);
        echo json_encode(['success' => true]);
        
    } catch (Exception $e) {
        writeLog("❌ Lỗi webhook: " . $e->getMessage());
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Main execution
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['webhook'])) {
    // Xử lý webhook
    handlePay2SWebhook();
} else {
    // Lấy giao dịch từ API
    $transactions = fetchTransactionsFromPay2S();
    
    $saved = 0;
    foreach ($transactions as $transaction) {
        if (saveTransactionToDatabase($transaction)) {
            $saved++;
        }
    }
    
    writeLog("Đã lưu $saved/" . count($transactions) . " giao dịch mới");
    writeLog("=== Hoàn thành lấy giao dịch từ Pay2S ===");
    
    echo "Đã lưu $saved/" . count($transactions) . " giao dịch mới từ Pay2S API\n";
}
?>
