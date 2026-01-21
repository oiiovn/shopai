<?php
/**
 * Bank Transaction Handler
 * Xử lý giao dịch ngân hàng và cập nhật số dư
 */

// Include required files
require_once('bootloader.php');

class BankTransactionHandler {
    private $db;
    private $user;
    
    public function __construct() {
        global $db, $user;
        $this->db = $db;
        $this->user = $user;
    }
    
    /**
     * Lấy lịch sử giao dịch từ Pay2S cho tài khoản ACB 46241987
     */
    public function fetchBankTransactions($bankCode = '970416', $fromDate = null, $toDate = null) {
        try {
            // Lấy cấu hình Pay2S
            $pay2sConfig = $this->getPay2SConfig();
            if (!$pay2sConfig) {
                throw new Exception("Pay2S config not found");
            }
            
            // Gọi Pay2S API cho tài khoản ACB 46241987
            return $this->callPay2SAPI($pay2sConfig, $bankCode, $fromDate, $toDate);
            
        } catch (Exception $e) {
            error_log("Pay2S Transaction Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy cấu hình Pay2S
     */
    private function getPay2SConfig() {
        try {
            // Lấy từ database
            $stmt = $this->db->prepare("
                SELECT api_url, api_key, api_secret, webhook_url 
                FROM bank_configs 
                WHERE bank_code = 'PAY2S' AND is_active = 1
            ");
            $stmt->execute();
            $config = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($config) {
                return $config;
            }
            
            // Fallback config nếu chưa có trong database
            return [
                'api_url' => 'https://api.pay2s.com/v1',
                'api_key' => 'PAY2S23DW78K2CVCZFW9',
                'api_secret' => '88d3b56b2702dbf15a6648cc2eda93001f5c80ab9cdcc232393b4f368e9ec9c6',
                'webhook_secret' => '1ece1f568539eeb7b971578c32a317369defbf0e64b8336124bdc47399a3419e',
            ];
            
        } catch (Exception $e) {
            error_log("Get Pay2S Config Error: " . $e->getMessage());
            return [
                'api_url' => 'https://api.pay2s.com/v1',
                'api_key' => 'PAY2S23DW78K2CVCZFW9',
                'api_secret' => '88d3b56b2702dbf15a6648cc2eda93001f5c80ab9cdcc232393b4f368e9ec9c6',
                'webhook_secret' => '1ece1f568539eeb7b971578c32a317369defbf0e64b8336124bdc47399a3419e',
            ];
        }
    }
    
    /**
     * Lấy cấu hình ngân hàng
     */
    private function getBankConfig($bankCode) {
        $stmt = $this->db->prepare("SELECT * FROM bank_configs WHERE bank_code = ? AND is_active = 1");
        $stmt->execute([$bankCode]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Dữ liệu mẫu cho testing
     */
    private function getMockTransactions($bankCode, $fromDate, $toDate) {
        $mockTransactions = [
            [
                'transaction_id' => 'TXN' . time() . rand(1000, 9999),
                'bank_code' => $bankCode,
                'account_number' => 'PHATLOC46241987',
                'amount' => 100000,
                'content' => 'RZ5BH134411',
                'description' => 'Nạp tiền vào tài khoản',
                'transaction_type' => 'deposit',
                'transaction_date' => date('Y-m-d H:i:s'),
                'bank_reference' => 'REF' . rand(100000, 999999)
            ],
            [
                'transaction_id' => 'TXN' . (time() - 3600) . rand(1000, 9999),
                'bank_code' => $bankCode,
                'account_number' => 'PHATLOC46241987',
                'amount' => 500000,
                'content' => 'RZ5BH134412',
                'description' => 'Nạp tiền vào tài khoản',
                'transaction_type' => 'deposit',
                'transaction_date' => date('Y-m-d H:i:s', time() - 3600),
                'bank_reference' => 'REF' . rand(100000, 999999)
            ]
        ];
        
        return $mockTransactions;
    }
    
    /**
     * Gọi Pay2S API để lấy lịch sử giao dịch cho tài khoản ACB 46241987
     */
    private function callPay2SAPI($config, $bankCode, $fromDate, $toDate) {
        try {
            // Chuẩn bị dữ liệu request cho tài khoản ACB 46241987
            $requestData = [
                'bank_code' => $bankCode, // 970416 = ACB
                'account_number' => '46241987', // Tài khoản ACB
                'from_date' => $fromDate ?: date('Y-m-d', strtotime('-7 days')),
                'to_date' => $toDate ?: date('Y-m-d'),
                'limit' => 100,
                'offset' => 0
            ];
            
            // Tạo signature cho request
            $signature = $this->createPay2SSignature($requestData, $config['api_secret']);
            
            // Headers cho request
            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $config['api_key'],
                'X-Signature: ' . $signature,
                'X-Timestamp: ' . time()
            ];
            
            // Gọi API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $config['api_url'] . '/transactions');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            if ($error) {
                throw new Exception("CURL Error: " . $error);
            }
            
            if ($httpCode !== 200) {
                throw new Exception("API Error: HTTP $httpCode - $response");
            }
            
            $data = json_decode($response, true);
            
            if (!$data || $data['status'] !== 'success') {
                throw new Exception("API Response Error: " . ($data['message'] ?? 'Unknown error'));
            }
            
            // Chuyển đổi dữ liệu từ Pay2S format sang format chuẩn
            return $this->convertPay2SData($data['data'], $bankCode);
            
        } catch (Exception $e) {
            error_log("Pay2S API Error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Tạo signature cho Pay2S request
     */
    private function createPay2SSignature($data, $secret) {
        $string = json_encode($data) . $secret . time();
        return hash('sha256', $string);
    }
    
    /**
     * Chuyển đổi dữ liệu từ Pay2S sang format chuẩn cho tài khoản ACB 46241987
     */
    private function convertPay2SData($pay2sData, $bankCode) {
        $transactions = [];
        
        foreach ($pay2sData as $item) {
            $transactions[] = [
                'transaction_id' => $item['transaction_id'] ?? $item['id'],
                'bank_code' => $bankCode, // 970416 = ACB
                'account_number' => '46241987', // Tài khoản ACB cố định
                'amount' => floatval($item['amount']),
                'content' => $item['content'] ?? $item['description'],
                'description' => $item['description'] ?? 'Giao dịch từ Pay2S - ACB 46241987',
                'transaction_type' => 'deposit',
                'transaction_date' => $item['created_at'] ?? date('Y-m-d H:i:s'),
                'bank_reference' => $item['reference'] ?? $item['transaction_id']
            ];
        }
        
        return $transactions;
    }
    
    /**
     * Xử lý giao dịch mới
     */
    public function processNewTransactions() {
        try {
            // Lấy tất cả giao dịch chưa xử lý
            $stmt = $this->db->prepare("
                SELECT bt.*, u.user_id, u.user_name, u.user_email 
                FROM bank_transactions bt
                LEFT JOIN users u ON bt.user_id = u.user_id
                WHERE bt.status = 'pending'
                ORDER BY bt.transaction_date ASC
            ");
            $stmt->execute();
            $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($transactions)) {
                error_log("Không có giao dịch pending nào để xử lý");
                return 0;
            }
            
            error_log("Tìm thấy " . count($transactions) . " giao dịch pending để xử lý");
            
            $processed = 0;
            foreach ($transactions as $transaction) {
                if ($this->processTransaction($transaction)) {
                    $processed++;
                }
            }
            
            return $processed;
            
        } catch (Exception $e) {
            error_log("Process Transactions Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Xử lý một giao dịch cụ thể
     */
    private function processTransaction($transaction) {
        try {
            $this->db->beginTransaction();
            
            // Cập nhật trạng thái giao dịch
            $stmt = $this->db->prepare("
                UPDATE bank_transactions 
                SET status = 'matched'
                WHERE id = ?
            ");
            $stmt->execute([$transaction['id']]);
            
            // Cập nhật số dư user
            $newBalance = $this->updateUserBalance(
                $transaction['user_id'], 
                $transaction['amount'], 
                $transaction['id']
            );
            
            // Ghi log biến động số dư
            $this->logBalanceTransaction(
                $transaction['user_id'],
                $transaction['id'],
                $transaction['amount'],
                $newBalance - $transaction['amount'],
                $newBalance,
                'deposit',
                'Nạp tiền từ ngân hàng - ' . $transaction['description']
            );
            
            // Gửi thông báo
            $this->sendNotification(
                $transaction['user_id'],
                'Nạp tiền thành công',
                'Bạn đã nạp thành công ' . number_format($transaction['amount']) . ' VNĐ vào tài khoản.',
                'success'
            );
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Process Transaction Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Cập nhật số dư user
     */
    private function updateUserBalance($userId, $amount, $transactionId) {
        // Lấy số dư hiện tại
        $stmt = $this->db->prepare("SELECT balance FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $currentBalance = $stmt->fetchColumn();
        
        // Cập nhật số dư mới
        $newBalance = $currentBalance + $amount;
        $stmt = $this->db->prepare("UPDATE users SET balance = ? WHERE user_id = ?");
        $stmt->execute([$newBalance, $userId]);
        
        return $newBalance;
    }
    
    /**
     * Ghi log biến động số dư
     */
    private function logBalanceTransaction($userId, $bankTransactionId, $amount, $balanceBefore, $balanceAfter, $type, $description) {
        $stmt = $this->db->prepare("
            INSERT INTO balance_transactions 
            (user_id, bank_transaction_id, amount, balance_before, balance_after, transaction_type, description, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'completed')
        ");
        $stmt->execute([$userId, $bankTransactionId, $amount, $balanceBefore, $balanceAfter, $type, $description]);
    }
    
    /**
     * Gửi thông báo
     */
    private function sendNotification($userId, $title, $message, $type = 'info') {
        // TODO: Implement notification system
        // Có thể sử dụng email, push notification, in-app notification
        error_log("Notification to user $userId: $title - $message");
    }
    
    /**
     * Lưu giao dịch từ ngân hàng
     */
    public function saveBankTransaction($transactionData) {
        try {
            // Kiểm tra giao dịch đã tồn tại chưa
            $stmt = $this->db->prepare("
                SELECT id FROM bank_transactions 
                WHERE transaction_id = ? AND bank = ?
            ");
            $stmt->execute([$transactionData['transaction_id'], $transactionData['bank_code']]);
            
            if ($stmt->fetch()) {
                return false; // Giao dịch đã tồn tại
            }
            
            // Tìm user dựa trên nội dung giao dịch
            $userId = $this->findUserByContent($transactionData['content']);
            
            // Lưu giao dịch
            $stmt = $this->db->prepare("
                INSERT INTO bank_transactions 
                (user_id, transaction_id, bank, account_number, amount, type, description, transaction_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $userId,
                $transactionData['transaction_id'],
                $transactionData['bank_code'],
                $transactionData['account_number'],
                $transactionData['amount'],
                $transactionData['transaction_type'] === 'deposit' ? 'in' : 'out',
                $transactionData['description'],
                $transactionData['transaction_date']
            ]);
            
            return $this->db->lastInsertId();
            
        } catch (Exception $e) {
            error_log("Save Bank Transaction Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Tìm user dựa trên nội dung giao dịch
     */
    private function findUserByContent($content) {
        // Logic tìm user dựa trên nội dung
        // Có thể sử dụng pattern matching hoặc mapping
        $stmt = $this->db->prepare("
            SELECT user_id FROM users 
            WHERE user_name LIKE ? OR user_email LIKE ?
            LIMIT 1
        ");
        $stmt->execute(["%$content%", "%$content%"]);
        $result = $stmt->fetch();
        
        return $result ? $result['user_id'] : 1; // Default user ID
    }
    
    /**
     * Lấy lịch sử giao dịch của user
     */
    public function getUserTransactions($userId, $limit = 50, $offset = 0) {
        $stmt = $this->db->prepare("
            SELECT bt.*, bct.balance_before, bct.balance_after, bct.transaction_type as balance_type
            FROM bank_transactions bt
            LEFT JOIN balance_transactions bct ON bt.id = bct.bank_transaction_id
            WHERE bt.user_id = ?
            ORDER BY bt.transaction_date DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$userId, $limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// API endpoint để xử lý webhook từ ngân hàng
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['webhook'])) {
    header('Content-Type: application/json');
    
    try {
        $handler = new BankTransactionHandler();
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Lưu giao dịch mới
        $transactionId = $handler->saveBankTransaction($input);
        
        if ($transactionId) {
            // Xử lý giao dịch ngay lập tức
            $handler->processNewTransactions();
            
            echo json_encode(['status' => 'success', 'transaction_id' => $transactionId]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Transaction already exists']);
        }
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    
    exit;
}

// API endpoint để lấy lịch sử giao dịch
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_transactions'])) {
    header('Content-Type: application/json');
    
    try {
        $handler = new BankTransactionHandler();
        $userId = $_GET['user_id'] ?? 1;
        $limit = $_GET['limit'] ?? 50;
        $offset = $_GET['offset'] ?? 0;
        
        $transactions = $handler->getUserTransactions($userId, $limit, $offset);
        
        echo json_encode(['status' => 'success', 'data' => $transactions]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    
    exit;
}
?>
