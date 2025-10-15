<?php

/**
 * shop-ai
 * 
 * @package Sngine
 * @author Zamblek
 */


// fetch bootloader
require('bootloader.php');

// Note: Using database rank system only (not class-rank.php)

/**
 * Get all ranks from database
 */
function getAllRanksFromDB() {
    global $db;
    
    try {
        $get_ranks = $db->query("
            SELECT * FROM shop_ai_ranks 
            WHERE is_active = 1 
            ORDER BY rank_order ASC
        ");
        
        $ranks = [];
        if ($get_ranks->num_rows > 0) {
            while ($rank = $get_ranks->fetch_assoc()) {
                $ranks[] = $rank;
            }
        }
        
        return $ranks;
    } catch (Exception $e) {
        error_log("Error getting ranks: " . $e->getMessage());
        return [];
    }
}

// Handle API requests
if (isset($_GET['action']) || (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false)) {
    handleAPIRequest();
    exit;
}

// user access - có test mode với parameter user_id
if (isset($_GET['test_user_id']) && is_numeric($_GET['test_user_id'])) {
    // Test mode - cho phép test với user_id khác nhau
    $test_user_id = intval($_GET['test_user_id']);
    
    // Kiểm tra user có tồn tại không
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $stmt = $pdo->prepare("SELECT user_id, user_name, user_email, user_wallet_balance FROM users WHERE user_id = ?");
    $stmt->execute([$test_user_id]);
    $test_user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($test_user) {
        $user = new stdClass();
        $user->_data = $test_user;
        $user->_logged_in = true; // Test mode
        echo "<!-- TEST MODE: User ID {$test_user_id} ({$test_user['user_name']}) -->\n";
    } else {
        die("User ID {$test_user_id} không tồn tại!");
    }
} else {
    // Production mode - kiểm tra view có cần đăng nhập không
    $view = $_GET['view'] ?? '';
    $public_views = ['pricing', 'check']; // Các view không cần đăng nhập (thêm 'check')
    
    if (!in_array($view, $public_views)) {
        user_access(); // Yêu cầu đăng nhập cho các view khác
    }
}

// Function to generate VietQR using API
function generateVietQR($amount, $content) {
    // Bank information - ACB Bank
    $bank_account = '46241987';  // STK ACB thật
    $bank_code = '970416'; // ACB Bank code for VietQR
    $bank_name = 'ACB';
    
    // Method 1: Try VietQR API with proper EMV format
    $vietqr_api_url = 'https://api.vietqr.io/v2/generate';
    $vietqr_data = array(
        'accountNo' => $bank_account,
        'accountName' => 'ACB Account',  // Tên tài khoản
        'acqId' => $bank_code,
        'amount' => intval($amount),
        'addInfo' => $content,
        'format' => 'text',
        'template' => 'compact'
    );
    
    // Try VietQR API first
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $vietqr_api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vietqr_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code == 200 && $response) {
        $result = json_decode($response, true);
        if (isset($result['data']['qrDataURL'])) {
            return $result['data']['qrDataURL'];
        }
    }
    
    // Method 2: Fallback to VietQR image service
    $timestamp = time();
    $qr_image_url = "https://img.vietqr.io/image/{$bank_code}-{$bank_account}-{$amount}-" . urlencode($content) . ".jpg?t={$timestamp}";
    
    return $qr_image_url;
}

// Function to get user balance using PDO - chỉ dùng user_wallet_balance
function getUserBalance($user_id) {
    global $db;
    try {
        $get_balance = $db->query(sprintf("SELECT user_wallet_balance FROM users WHERE user_id = %s", secure($user_id, 'int')));
        if ($get_balance && $get_balance->num_rows > 0) {
            $result = $get_balance->fetch_assoc();
            return floatval($result['user_wallet_balance']);
        }
        return 0;
    } catch (Exception $e) {
        error_log("Error getting user balance: " . $e->getMessage());
        return 0;
    }
}

// Function to save QR code mapping using PDO
function saveQRCodeMapping($qr_content, $user_id, $amount, $expires_minutes = 15) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Tạo nội dung chuyển khoản đầy đủ để so sánh với Pay2S
        $transfer_content = $qr_content . " - Nap tien Shop AI";
        
        // Sử dụng MySQL để tính thời gian hết hạn (lấy giờ hiện tại + 15 phút)
        $stmt = $pdo->prepare("
            INSERT INTO qr_code_mapping 
            (qr_code, user_id, amount, status, expires_at, description, transfer_content, created_at, updated_at) 
            VALUES (?, ?, ?, 'active', DATE_ADD(NOW(), INTERVAL ? MINUTE), 'Shop-AI Recharge QR Code', ?, NOW(), NOW())
        ");
        return $stmt->execute([$qr_content, $user_id, $amount, $expires_minutes, $transfer_content]);
    } catch (PDOException $e) {
        error_log("QR Code mapping error: " . $e->getMessage());
        return false;
    }
}

// Function to check user phone by username
function checkUserPhoneByUsername($username) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Tìm user theo username
        $stmt = $pdo->prepare("SELECT user_id, user_name, user_phone FROM users WHERE user_name = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return [
                'success' => false,
                'message' => 'Không tìm thấy user với username: ' . $username,
                'phone' => null,
                'user_id' => null
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Tìm thấy user thành công',
            'phone' => $user['user_phone'],
            'user_id' => $user['user_id'],
            'username' => $user['user_name']
        ];
        
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Lỗi database: ' . $e->getMessage(),
            'phone' => null,
            'user_id' => null
        ];
    }
}

// Function to call checkso.pro API
function callChecksoAPI($username, $phone = '99') {
    $api_token = '1770dd4e380567afd3668f8a9be69c21c587e08da9c5b75b5269174291ec7076';
    
    // Try multiple endpoints (HTTP and HTTPS)
    $endpoints = [
        'http://checkso.pro/search_users_advanced',
        'https://checkso.pro/search_users_advanced'
    ];
    
    $data = [
        'api' => $api_token,
        'username' => $username,
        'phone' => $phone
    ];
    
    $last_error = '';
    
    // Try each endpoint
    foreach ($endpoints as $endpoint) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        error_log("CheckSo API attempt - Endpoint: $endpoint, HTTP: $http_code, Error: $curl_error");
        
        if ($response !== false && !empty($response)) {
            $result = json_decode($response, true);
            
            if ($result && isset($result['status'])) {
                return [
                    'success' => $result['status'] == 1,
                    'message' => $result['status'] == 1 ? 'Check thành công' : 'Không tìm thấy',
                    'data' => $result,
                    'endpoint_used' => $endpoint
                ];
            }
        }
        
        $last_error = !empty($curl_error) ? $curl_error : "HTTP $http_code - No valid response";
    }
    
    return [
        'success' => false,
        'message' => 'API checkso.pro không phản hồi. Vui lòng thử lại sau. (' . $last_error . ')',
        'data' => null
    ];
}

// Function to save phone check history
function savePhoneCheckHistory($checker_user_id, $checked_username, $checked_user_id, $phone, $status, $result_message) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("INSERT INTO phone_check_history (checker_user_id, checked_username, checked_user_id, phone, status, result_message, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$checker_user_id, $checked_username, $checked_user_id, $phone, $status, $result_message]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}


// Function to get phone check history with pagination
function getPhoneCheckHistory($checker_user_id, $limit = 50, $offset = 0, $status_filter = '', $search = '') {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $where_conditions = ["checker_user_id = ?"];
        $params = [$checker_user_id];
        
        if (!empty($status_filter)) {
            $where_conditions[] = "status = ?";
            $params[] = $status_filter;
        }
        
        if (!empty($search)) {
            $where_conditions[] = "checked_username LIKE ?";
            $params[] = "%$search%";
        }
        
        $where_clause = implode(" AND ", $where_conditions);
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $pdo->prepare("SELECT * FROM phone_check_history WHERE $where_clause ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Function to get total count for pagination
function getPhoneCheckHistoryCount($checker_user_id, $status_filter = '', $search = '') {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $where_conditions = ["checker_user_id = ?"];
        $params = [$checker_user_id];
        
        if (!empty($status_filter)) {
            $where_conditions[] = "status = ?";
            $params[] = $status_filter;
        }
        
        if (!empty($search)) {
            $where_conditions[] = "checked_username LIKE ?";
            $params[] = "%$search%";
        }
        
        $where_clause = implode(" AND ", $where_conditions);
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM phone_check_history WHERE $where_clause");
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    } catch (PDOException $e) {
        return 0;
    }
}

// Function to get phone check history with advanced filters
function getPhoneCheckHistoryAdvanced($checker_user_id, $limit = 20, $offset = 0, $status_filter = '', $search = '', $date_from = '', $date_to = '') {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $where_conditions = ["checker_user_id = ?"];
        $params = [$checker_user_id];
        
        if (!empty($status_filter)) {
            $where_conditions[] = "status = ?";
            $params[] = $status_filter;
        }
        
        if (!empty($search)) {
            $where_conditions[] = "checked_username LIKE ?";
            $params[] = "%$search%";
        }
        
        if (!empty($date_from)) {
            $where_conditions[] = "DATE(created_at) >= ?";
            $params[] = $date_from;
        }
        
        if (!empty($date_to)) {
            $where_conditions[] = "DATE(created_at) <= ?";
            $params[] = $date_to;
        }
        
        $where_clause = implode(" AND ", $where_conditions);
        
        $sql = "SELECT * FROM phone_check_history WHERE $where_clause ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Function to get total count with advanced filters
function getPhoneCheckHistoryCountAdvanced($checker_user_id, $status_filter = '', $search = '', $date_from = '', $date_to = '') {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $where_conditions = ["checker_user_id = ?"];
        $params = [$checker_user_id];
        
        if (!empty($status_filter)) {
            $where_conditions[] = "status = ?";
            $params[] = $status_filter;
        }
        
        if (!empty($search)) {
            $where_conditions[] = "checked_username LIKE ?";
            $params[] = "%$search%";
        }
        
        if (!empty($date_from)) {
            $where_conditions[] = "DATE(created_at) >= ?";
            $params[] = $date_from;
        }
        
        if (!empty($date_to)) {
            $where_conditions[] = "DATE(created_at) <= ?";
            $params[] = $date_to;
        }
        
        $where_clause = implode(" AND ", $where_conditions);
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM phone_check_history WHERE $where_clause");
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    } catch (PDOException $e) {
        return 0;
    }
}

// Function to get phone check statistics
function getPhoneCheckStats($checker_user_id) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) as success,
                SUM(CASE WHEN status = 'not_found' THEN 1 ELSE 0 END) as not_found,
                SUM(CASE WHEN status = 'error' THEN 1 ELSE 0 END) as error,
                MIN(created_at) as first_check,
                MAX(created_at) as last_check
            FROM phone_check_history 
            WHERE checker_user_id = ?
        ");
        $stmt->execute([$checker_user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [
            'total' => 0,
            'pending' => 0,
            'success' => 0,
            'not_found' => 0,
            'error' => 0,
            'first_check' => null,
            'last_check' => null
        ];
    }
}

// Function to handle API requests
function handleAPIRequest() {
    header('Content-Type: application/json');
    
    // Get action from GET or POST
    $action = $_GET['action'] ?? '';
    
    // If no action in GET, try to get from JSON POST body
    if (empty($action) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $action = $data['action'] ?? '';
    }
    
    switch ($action) {
        case 'check_payment_status':
            handleCheckPaymentStatus();
            break;
            
        case 'save_qr_mapping':
            handleSaveQRMapping();
            break;
            
        // === WITHDRAWAL SYSTEM APIs ===
        case 'add_bank_account':
            handleAddBankAccount();
            break;
            
        case 'list_bank_accounts':
            handleListBankAccounts();
            break;
            
        case 'delete_bank_account':
            handleDeleteBankAccount();
            break;
            
        case 'set_default_bank':
            handleSetDefaultBank();
            break;
            
        case 'create_withdrawal':
            handleCreateWithdrawal();
            break;
            
        case 'check_withdrawal_status':
            handleCheckWithdrawalStatus();
            break;
            
        case 'cancel_withdrawal':
            handleCancelWithdrawal();
            break;
            
        case 'get_withdrawal_history':
            handleGetWithdrawalHistory();
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
            break;
    }
}

// Function to check payment status
function handleCheckPaymentStatus() {
    try {
        // Get parameters
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        $qrCode = $data['qr_code'] ?? '';
        $amount = floatval($data['amount'] ?? 0);
        $userId = intval($data['user_id'] ?? 0);
        
        if (empty($qrCode) || $amount <= 0 || $userId <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid parameters'
            ]);
            return;
        }
        
        // Connect to database
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check QR code mapping status
        $stmt = $pdo->prepare("
            SELECT qr_id, status, expires_at, used_at 
            FROM qr_code_mapping 
            WHERE qr_code = ? AND user_id = ? AND amount = ?
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $stmt->execute([$qrCode, $userId, $amount]);
        $qrMapping = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$qrMapping) {
            echo json_encode([
                'success' => false,
                'message' => 'QR code not found'
            ]);
            return;
        }
        
        // Check if expired
        if (strtotime($qrMapping['expires_at']) < time()) {
            echo json_encode([
                'success' => true,
                'status' => 'expired',
                'message' => 'QR code expired'
            ]);
            return;
        }
        
        // Check if used (completed)
        if ($qrMapping['status'] === 'used') {
            // Get transaction details
            $stmt = $pdo->prepare("
                SELECT bt.transaction_id, bt.amount, u.user_wallet_balance 
                FROM bank_transactions bt 
                JOIN users u ON u.user_id = bt.user_id 
                WHERE bt.user_id = ? AND bt.amount = ? AND bt.status = 'completed'
                ORDER BY bt.created_at DESC 
                LIMIT 1
            ");
            $stmt->execute([$userId, $amount]);
            $transaction = $stmt->fetch(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'status' => 'completed',
                'message' => 'Payment completed',
                'amount' => $amount,
                'new_balance' => $transaction['user_wallet_balance'] ?? 0,
                'transaction_id' => $transaction['transaction_id'] ?? ''
            ]);
            return;
        }
        
        // Still pending
        echo json_encode([
            'success' => true,
            'status' => 'pending',
            'message' => 'Payment pending'
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ]);
    }
}

// Function to save QR mapping via AJAX
function handleSaveQRMapping() {
    try {
        // Get parameters
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        $qrCode = $data['qr_code'] ?? '';
        $amount = floatval($data['amount'] ?? 0);
        $userId = intval($data['user_id'] ?? 0);
        
        if (empty($qrCode) || $amount <= 0 || $userId <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid parameters'
            ]);
            return;
        }
        
        // Validate amount range
        if ($amount < 10000 || $amount > 50000000) {
            echo json_encode([
                'success' => false,
                'message' => 'Amount must be between 10,000 and 50,000,000 VND'
            ]);
            return;
        }
        
        // Save QR mapping
        $result = saveQRCodeMapping($qrCode, $userId, $amount, 15);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'QR mapping saved successfully',
                'qr_code' => $qrCode,
                'amount' => $amount,
                'user_id' => $userId,
                'expires_in_minutes' => 15
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save QR mapping'
            ]);
        }
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ]);
    }
}

// Function to get Shop-AI transactions from users_wallets_transactions
function getShopAITransactions($user_id, $limit = 50) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Fix MariaDB LIMIT issue by using direct string concatenation
        $limit = intval($limit); // Sanitize
        $stmt = $pdo->prepare("
            SELECT * FROM users_wallets_transactions 
            WHERE user_id = ? 
            ORDER BY time DESC 
            LIMIT $limit
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error getting Shop-AI transactions: " . $e->getMessage());
        return [];
    }
}

// Function to get Shop-AI transactions with pagination
function getShopAITransactionsPaginated($user_id, $limit = 10, $offset = 0) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Fix MariaDB LIMIT OFFSET issue
        $limit = intval($limit);
        $offset = intval($offset);
        $stmt = $pdo->prepare("
            SELECT * FROM users_wallets_transactions 
            WHERE user_id = ? 
            ORDER BY time DESC 
            LIMIT $limit OFFSET $offset
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error getting paginated Shop-AI transactions: " . $e->getMessage());
        return [];
    }
}

// Function to get total count of Shop-AI transactions
function getTotalShopAITransactions($user_id) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as total FROM users_wallets_transactions 
            WHERE user_id = ?
        ");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($result['total']);
    } catch (PDOException $e) {
        error_log("Error getting total Shop-AI transactions: " . $e->getMessage());
        return 0;
    }
}

// Function to get QR code mappings
function getQRCodeMappings($user_id, $limit = 50) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Fix MariaDB LIMIT issue
        $limit = intval($limit);
        $stmt = $pdo->prepare("
            SELECT * FROM qr_code_mapping 
            WHERE user_id = ? 
            ORDER BY created_at DESC 
            LIMIT $limit
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error getting QR mappings: " . $e->getMessage());
        return [];
    }
}

// Function to get bank transactions
function getBankTransactions($user_id, $limit = 50) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Fix MariaDB LIMIT issue
        $limit = intval($limit);
        $stmt = $pdo->prepare("
            SELECT * FROM bank_transactions 
            WHERE user_id = ? AND business_type = 'shop_ai_recharge'
            ORDER BY transaction_date DESC 
            LIMIT $limit
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error getting bank transactions: " . $e->getMessage());
        return [];
    }
}

try {
  
  // get view content
  switch ($_GET['view']) {
    case '':
    case 'check':
      // page header
      page_header(__("Check Số Điện Thoại Shopee") . ' | ' . __($system['system_title']));
      
      // Check if user is logged in
      $is_logged_in = $user->_logged_in;
      $user_id = $is_logged_in ? $user->_data['user_id'] : null;
      $current_balance = $is_logged_in ? getUserBalance($user_id) : 0;
      
      /* get Shop-AI rank info - SAME AS ADMIN PANEL */
      $user_rank = null;
      $check_history = [];
      
      if ($is_logged_in) {
        // Get current rank for this specific user
        $current_user_id = secure($user_id, 'int');
        $get_shop_ai_rank = $db->query(sprintf("
          SELECT sur.*, sr.rank_name, sr.rank_emoji, sr.check_price, sr.min_spending
          FROM shop_ai_user_ranks sur 
          LEFT JOIN shop_ai_ranks sr ON sur.current_rank_id = sr.rank_id 
          WHERE sur.user_id = %s
        ", $current_user_id));
        
        if ($get_shop_ai_rank->num_rows > 0) {
          $shop_ai_rank_data = $get_shop_ai_rank->fetch_assoc();
          $user_rank = [
            'rank_id' => $shop_ai_rank_data['current_rank_id'],
            'rank_name' => $shop_ai_rank_data['rank_name'],
            'rank_emoji' => $shop_ai_rank_data['rank_emoji'],
            'check_price' => $shop_ai_rank_data['check_price'],
            'min_spending' => $shop_ai_rank_data['min_spending'],
            'user_total_spent' => $shop_ai_rank_data['total_spending']
          ];
        }
        
        // Get phone check history (5 giao dịch gần nhất)
        $check_history = getPhoneCheckHistory($user_id, 5);
      }
      
      // Handle check phone form submission
      $check_result = null;
      if (isset($_POST['check_phone']) && !empty($_POST['username'])) {
        $username_to_check = trim($_POST['username']);
        
        // Check if user is logged in first
        if (!$is_logged_in) {
          $check_result = [
            'success' => false,
            'message' => 'Vui lòng đăng nhập để sử dụng tính năng check số',
            'username' => $username_to_check,
            'require_login' => true
          ];
        } else {
          // Check if user has enough balance
          $check_price = $user_rank['check_price'] ?? 30000; // Default price if no rank
          
          if ($current_balance < $check_price) {
            // Not enough balance
            $check_result = [
              'success' => false,
              'message' => 'Không đủ số dư để thực hiện check. Số dư hiện tại: ' . number_format($current_balance, 0, ',', '.') . ' VNĐ. Cần: ' . number_format($check_price, 0, ',', '.') . ' VNĐ.',
              'username' => $username_to_check,
              'insufficient_balance' => true,
              'current_balance' => $current_balance,
              'required_amount' => $check_price
            ];
          } else {
            // Sufficient balance - DEDUCT MONEY FIRST, then call API
            $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            try {
              $pdo->beginTransaction();
              
              // 1. Deduct money from user wallet FIRST
              $stmt = $pdo->prepare("UPDATE users SET user_wallet_balance = user_wallet_balance - ? WHERE user_id = ?");
              $stmt->execute([$check_price, $user_id]);
              
              // 2. Create pending transaction in users_wallets_transactions
              $description = "Check số Shopee: {$username_to_check} - Đang xử lý...";
              $stmt = $pdo->prepare("
                INSERT INTO users_wallets_transactions (user_id, amount, type, time, description) 
                VALUES (?, ?, 'withdraw', NOW(), ?)
              ");
              $stmt->execute([$user_id, $check_price, $description]);
              
              // 3. Create pending transaction in wallet_transactions
              $stmt = $pdo->prepare("
                INSERT INTO wallet_transactions (user_id, node_type, node_id, amount, type, date) 
                VALUES (?, 'shop_ai_check', ?, ?, 'out', NOW())
              ");
              $stmt->execute([$user_id, 0, $check_price]);
              
              $pdo->commit();
              
              // Now call API
              $api_result = callChecksoAPI($username_to_check, '99');
              
              if ($api_result['success'] && isset($api_result['data']['records']) && count($api_result['data']['records']) > 0) {
                // Success - found phone number
                $phone_data = $api_result['data']['records'][0];
                $phone_number = $phone_data['result'];
                
                // Update transactions with success info
                $pdo->beginTransaction();
                
                // Update users_wallets_transactions with success
                $description = "Check số Shopee: {$username_to_check} - Thành công: {$phone_number}";
                $stmt = $pdo->prepare("
                  UPDATE users_wallets_transactions 
                  SET description = ? 
                  WHERE user_id = ? AND description LIKE 'Check số Shopee: {$username_to_check} - Đang xử lý...'
                  ORDER BY time DESC LIMIT 1
                ");
                $stmt->execute([$description, $user_id]);
                
                // CHỈ CỘNG VÀO TOTAL_SPENDING KHI CHECK THÀNH CÔNG
                $stmt = $pdo->prepare("
                  INSERT INTO shop_ai_user_ranks (user_id, current_rank_id, total_spending, created_at, last_updated) 
                  VALUES (?, 1, ?, NOW(), NOW())
                  ON DUPLICATE KEY UPDATE 
                  total_spending = total_spending + ?, 
                  last_updated = NOW()
                ");
                $stmt->execute([$user_id, $check_price, $check_price]);
                
                // Update rank if needed
                $stmt = $pdo->prepare("
                  SELECT sr.rank_id, sr.rank_name, sr.check_price, sr.min_spending
                  FROM shop_ai_ranks sr 
                  WHERE sr.min_spending <= (
                    SELECT total_spending FROM shop_ai_user_ranks WHERE user_id = ?
                  )
                  ORDER BY sr.rank_order DESC 
                  LIMIT 1
                ");
                $stmt->execute([$user_id]);
                $new_rank = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($new_rank) {
                  $stmt = $pdo->prepare("
                    UPDATE shop_ai_user_ranks 
                    SET current_rank_id = ? 
                    WHERE user_id = ? AND current_rank_id < ?
                  ");
                  $stmt->execute([$new_rank['rank_id'], $user_id, $new_rank['rank_id']]);
                }
                
                $pdo->commit();
                
                // Save phone check history
                $history_id = savePhoneCheckHistory(
                  $user_id,
                  $username_to_check,
                  null,
                  $phone_number,
                  'success',
                  'Check thành công: ' . $phone_number
                );
                
                $check_result = [
                  'success' => true,
                  'message' => 'Check thành công!',
                  'phone' => $phone_number,
                  'username' => $username_to_check,
                  'history_id' => $history_id,
                  'api_balance' => $api_result['data']['new_balance'] ?? 'N/A',
                  'amount_deducted' => $check_price,
                  'new_balance' => getUserBalance($user_id)
                ];
                
              } else {
                // Not found or API error - REFUND MONEY
                $error_message = $api_result['message'] ?? 'Không tìm thấy số điện thoại';
                
                $pdo->beginTransaction();
                
                // 1. Add money back to user wallet
                $stmt = $pdo->prepare("UPDATE users SET user_wallet_balance = user_wallet_balance + ? WHERE user_id = ?");
                $stmt->execute([$check_price, $user_id]);
                
                // 2. Update users_wallets_transactions with refund
                $description = "Hoàn tiền check số thất bại: {$username_to_check} - {$error_message}";
                $stmt = $pdo->prepare("
                  UPDATE users_wallets_transactions 
                  SET type = 'recharge', description = ? 
                  WHERE user_id = ? AND description LIKE 'Check số Shopee: {$username_to_check} - Đang xử lý...'
                  ORDER BY time DESC LIMIT 1
                ");
                $stmt->execute([$description, $user_id]);
                
                // 3. Create refund transaction in wallet_transactions
                $stmt = $pdo->prepare("
                  INSERT INTO wallet_transactions (user_id, node_type, node_id, amount, type, date) 
                  VALUES (?, 'shop_ai_refund', ?, ?, 'in', NOW())
                ");
                $stmt->execute([$user_id, 0, $check_price]);
                
                // KHÔNG CỘNG VÀO TOTAL_SPENDING KHI CHECK THẤT BẠI
                // Vì đã hoàn tiền nên không tính vào chi tiêu
                
                $pdo->commit();
                
                // Save phone check history
                $history_id = savePhoneCheckHistory(
                  $user_id,
                  $username_to_check,
                  null,
                  null,
                  'not_found',
                  $error_message
                );
                
                $check_result = [
                  'success' => false,
                  'message' => $error_message,
                  'username' => $username_to_check,
                  'history_id' => $history_id,
                  'api_balance' => $api_result['data']['new_balance'] ?? 'N/A',
                  'amount_refunded' => $check_price,
                  'new_balance' => getUserBalance($user_id)
                ];
              }
              
            } catch (Exception $e) {
              $pdo->rollBack();
              throw new Exception("Lỗi xử lý thanh toán: " . $e->getMessage());
            }
          } // End of balance check else
          
          // Refresh history after new check
          $check_history = getPhoneCheckHistory($user_id, 5);
        } // End of login check else
      }
      
      // Assign variables to template
      $smarty->assign('is_logged_in', $is_logged_in);
      $smarty->assign('current_balance', $current_balance);
      $smarty->assign('user_rank', $user_rank);
      $smarty->assign('check_history', $check_history);
      $smarty->assign('check_result', $check_result);
      break;

    case 'recharge':
      // page header
      page_header(__("Nạp tiền") . ' | ' . __($system['system_title']));
      
      // Get current balance for user
      $user_id = $user->_data['user_id'];
      $current_balance = getUserBalance($user_id);
      
      // Assign balance to template
      $smarty->assign('current_balance', $current_balance);
      
      // handle recharge form submission
      if (isset($_POST['submit'])) {
        $amount = $_POST['amount'];
        
        // Generate unique content for each user and time
        $timestamp = time();
        $random_string = substr(md5(uniqid(rand(), true)), 0, 8);
        $qr_content = "RZ" . $user_id . $timestamp . $random_string;
        
        // Generate QR code using VietQR API
        $qr_data = generateVietQR($amount, $qr_content);
        
        // Lưu QR code mapping vào database
        saveQRCodeMapping($qr_content, $user_id, $amount);
        
        // Assign variables to template
        $smarty->assign('qr_data', $qr_data);
        $smarty->assign('qr_content', $qr_content);
        $smarty->assign('amount', $amount);
      }
      break;

    case 'transactions':
      // page header
      page_header(__("Lịch Sử Giao Dịch Shop-AI") . ' | ' . __($system['system_title']));
      
      // Get current user info
      $user_id = $user->_data['user_id'];
      $current_balance = getUserBalance($user_id);
      
      // Pagination parameters
      $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
      $per_page = 10; // 10 giao dịch mỗi trang
      $offset = ($page - 1) * $per_page;
      
      // Get transactions with pagination
      $shop_ai_transactions = getShopAITransactionsPaginated($user_id, $per_page, $offset);
      
      // Get total count for pagination
      $total_transactions = getTotalShopAITransactions($user_id);
      $total_pages = ceil($total_transactions / $per_page);
      
      // Pagination info
      $pagination = [
        'current_page' => $page,
        'per_page' => $per_page,
        'total_items' => $total_transactions,
        'total_pages' => $total_pages,
        'has_prev' => $page > 1,
        'has_next' => $page < $total_pages,
        'prev_page' => $page - 1,
        'next_page' => $page + 1
      ];
      
      // Assign variables to template
      $smarty->assign('current_balance', $current_balance);
      $smarty->assign('shop_ai_transactions', $shop_ai_transactions);
      $smarty->assign('pagination', $pagination);
      break;

    case 'history':
      // page header
      page_header(__("Lịch sử Check Số Điện Thoại") . ' | ' . __($system['system_title']));
      
      // Get current user info
      $user_id = $user->_data['user_id'];
      $current_balance = getUserBalance($user_id);
      
      // Get filter parameters
      $page = intval($_GET['page'] ?? 1);
      $limit = intval($_GET['limit'] ?? 20);
      $search = $_GET['search'] ?? '';
      $status_filter = $_GET['status_filter'] ?? '';
      $date_from = $_GET['date_from'] ?? '';
      $date_to = $_GET['date_to'] ?? '';
      
      $offset = ($page - 1) * $limit;
      
      // Get history with filters
      $history = getPhoneCheckHistoryAdvanced($user_id, $limit, $offset, $status_filter, $search, $date_from, $date_to);
      $total_count = getPhoneCheckHistoryCountAdvanced($user_id, $status_filter, $search, $date_from, $date_to);
      $total_pages = ceil($total_count / $limit);
      
      // Get statistics
      $stats = getPhoneCheckStats($user_id);
      
      // Assign variables to template
      $smarty->assign('current_balance', $current_balance);
      $smarty->assign('history', $history);
      $smarty->assign('pagination', [
        'current_page' => $page,
        'total_pages' => $total_pages,
        'total_items' => $total_count,
        'items_per_page' => $limit
      ]);
      $smarty->assign('stats', $stats);
      $smarty->assign('filters', [
        'search' => $search,
        'status_filter' => $status_filter,
        'date_from' => $date_from,
        'date_to' => $date_to,
        'limit' => $limit
      ]);
      break;

    case 'bank-accounts':
      // LOG: Check if this case is reached
      error_log("=== BANK-ACCOUNTS VIEW ===");
      error_log("User logged in: " . ($user->_logged_in ? 'YES' : 'NO'));
      if ($user->_logged_in) {
        error_log("User ID: " . $user->_data['user_id']);
      }
      
      // page header
      page_header(__("Quản Lý Ngân Hàng") . ' | ' . __($system['system_title']));
      
      $user_banks = [];
      $vietnam_banks = [];
      
      // Only proceed if user is logged in
      if ($user->_logged_in) {
        $user_id = $user->_data['user_id'];
        error_log("Fetching banks for user: " . $user_id);
        
        // Get user's bank accounts using global $db
        $get_banks = $db->query(sprintf("SELECT * FROM user_bank_accounts WHERE user_id = %s AND status = 'active' ORDER BY is_default DESC, created_at DESC", secure($user_id, 'int')));
        if ($get_banks && $get_banks->num_rows > 0) {
          while ($bank = $get_banks->fetch_assoc()) {
            $user_banks[] = $bank;
          }
          error_log("Found " . count($user_banks) . " user banks");
        } else {
          error_log("No user banks found");
        }
      } else {
        error_log("User not logged in - skipping user banks query");
      }
      
      // Get list of Vietnam banks (available for all users)
      $get_vn_banks = $db->query("SELECT * FROM vietnam_banks WHERE is_active = 1 ORDER BY display_order ASC");
      if ($get_vn_banks && $get_vn_banks->num_rows > 0) {
        while ($bank = $get_vn_banks->fetch_assoc()) {
          $vietnam_banks[] = $bank;
        }
        error_log("Found " . count($vietnam_banks) . " Vietnam banks");
      } else {
        error_log("No Vietnam banks found");
      }
      
      $smarty->assign('user_banks', $user_banks);
      $smarty->assign('vietnam_banks', $vietnam_banks);
      error_log("=== END BANK-ACCOUNTS VIEW ===");
      break;

    case 'withdrawal':
      // LOG: Check if this case is reached
      error_log("=== WITHDRAWAL VIEW ===");
      error_log("User logged in: " . ($user->_logged_in ? 'YES' : 'NO'));
      if ($user->_logged_in) {
        error_log("User ID: " . $user->_data['user_id']);
      }
      
      // page header
      page_header(__("Rút Tiền") . ' | ' . __($system['system_title']));
      
      $current_balance = 0;
      $user_banks = [];
      $pending_withdrawal = false;
      
      // Only proceed if user is logged in
      if ($user->_logged_in) {
        $user_id = $user->_data['user_id'];
        error_log("Fetching balance for user: " . $user_id);
        
        // Get user balance using global $db
        $get_balance = $db->query(sprintf("SELECT user_wallet_balance FROM users WHERE user_id = %s", secure($user_id, 'int')));
        if ($get_balance && $get_balance->num_rows > 0) {
          $result = $get_balance->fetch_assoc();
          $current_balance = floatval($result['user_wallet_balance']);
          error_log("User balance: " . $current_balance);
        } else {
          error_log("No balance found for user");
        }
        
        // Get user's bank accounts using global $db
        $get_banks = $db->query(sprintf("SELECT * FROM user_bank_accounts WHERE user_id = %s AND status = 'active' ORDER BY is_default DESC, created_at DESC", secure($user_id, 'int')));
        if ($get_banks && $get_banks->num_rows > 0) {
          while ($bank = $get_banks->fetch_assoc()) {
            $user_banks[] = $bank;
          }
          error_log("Found " . count($user_banks) . " user banks");
        } else {
          error_log("No user banks found");
        }
        
        // Check if has pending withdrawal
        $get_pending = $db->query(sprintf("
            SELECT * FROM qr_code_mapping 
            WHERE user_id = %s AND transaction_type = 'withdrawal' AND status = 'active' AND expires_at > NOW()
            ORDER BY created_at DESC LIMIT 1
        ", secure($user_id, 'int')));
        
        if ($get_pending && $get_pending->num_rows > 0) {
          $pending_withdrawal = $get_pending->fetch_assoc();
          error_log("Found pending withdrawal: " . $pending_withdrawal['qr_code']);
        } else {
          error_log("No pending withdrawal");
        }
      } else {
        error_log("User not logged in - skipping data fetch");
      }
      
      $smarty->assign('current_balance', $current_balance);
      $smarty->assign('user_banks', $user_banks);
      $smarty->assign('pending_withdrawal', $pending_withdrawal);
      error_log("=== END WITHDRAWAL VIEW ===");
      break;

    case 'pricing':
      // page header
      page_header(__("Bảng Giá Check Số Điện Thoại") . ' | ' . __($system['system_title']));
      
      // Initialize rank system
      // Using database rank system only
      
      // Get all ranks for pricing table
      $all_ranks = getAllRanksFromDB();
      
      // Get user info if logged in
      if ($user->_logged_in) {
        $user_id = $user->_data['user_id'];
        $current_balance = getUserBalance($user_id);
        
        /* get Shop-AI rank info - SAME AS ADMIN PANEL */
        // Get current rank for this specific user
        $current_user_id = secure($user_id, 'int');
        $get_shop_ai_rank = $db->query(sprintf("
          SELECT sur.*, sr.rank_name, sr.rank_emoji, sr.check_price, sr.min_spending
          FROM shop_ai_user_ranks sur 
          LEFT JOIN shop_ai_ranks sr ON sur.current_rank_id = sr.rank_id 
          WHERE sur.user_id = %s
        ", $current_user_id));
        
        $user_rank = null;
        if ($get_shop_ai_rank->num_rows > 0) {
          $shop_ai_rank_data = $get_shop_ai_rank->fetch_assoc();
          $user_rank = [
            'rank_id' => $shop_ai_rank_data['current_rank_id'],
            'rank_name' => $shop_ai_rank_data['rank_name'],
            'rank_emoji' => $shop_ai_rank_data['rank_emoji'],
            'check_price' => $shop_ai_rank_data['check_price'],
            'min_spending' => $shop_ai_rank_data['min_spending'],
            'user_total_spent' => $shop_ai_rank_data['total_spending']
          ];
        }
        
        // Get actual spending from transactions for this specific user
        $get_actual_spending = $db->query(sprintf("
          SELECT COALESCE(SUM(amount), 0) as actual_spending 
          FROM users_wallets_transactions 
          WHERE user_id = %s AND type = 'withdraw'
        ", $current_user_id));
        
        $actual_spending = 0;
        if ($get_actual_spending->num_rows > 0) {
          $actual_spending = $get_actual_spending->fetch_assoc()['actual_spending'];
        }
        
        // Debug info
        $smarty->assign('debug_logged_in', 'YES');
        $smarty->assign('debug_user_id', $user_id);
        $smarty->assign('debug_query_result', $get_shop_ai_rank->num_rows);
        
        // Assign user-specific variables
        $smarty->assign('current_balance', $current_balance);
        $smarty->assign('user_rank', $user_rank);
        $smarty->assign('actual_spending', $actual_spending);
      }
      
      
      // Assign common variables
      $smarty->assign('all_ranks', $all_ranks);
      break;

    default:
      _error(404);
      break;
  }
  /* assign variables */
  $smarty->assign('view', $_GET['view']);

  // get total friend requests sent (simplified for test mode)
  $user->_data['friend_requests_sent_total'] = 0;

  // get ads campaigns (simplified for test mode)
  $smarty->assign('ads_campaigns', array());
  $smarty->assign('ads', array());
  $smarty->assign('widgets', array());
} catch (Exception $e) {
  _error(__("Error"), $e->getMessage());
}

// =============================================================================
// WITHDRAWAL SYSTEM - API FUNCTIONS
// =============================================================================

/**
 * Thêm tài khoản ngân hàng của user
 */
function handleAddBankAccount() {
    global $user;
    
    try {
        if (!$user->_logged_in) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data) {
            $data = $_POST;
        }
        
        $userId = $user->_data['user_id'];
        $bankCode = trim($data['bank_code'] ?? '');
        $bankName = trim($data['bank_name'] ?? '');
        $accountNumber = trim($data['account_number'] ?? '');
        $accountHolder = strtoupper(trim($data['account_holder'] ?? ''));
        $accountNickname = trim($data['account_nickname'] ?? '');
        
        // Validation
        if (empty($bankCode) || empty($accountNumber) || empty($accountHolder)) {
            echo json_encode(['success' => false, 'error' => 'Missing required fields']);
            return;
        }
        
        // Validate account number
        if (!preg_match('/^[0-9]{6,20}$/', $accountNumber)) {
            echo json_encode(['success' => false, 'error' => 'Số tài khoản không hợp lệ (6-20 chữ số)']);
            return;
        }
        
        // Connect database
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check if bank already exists
        $stmt = $pdo->prepare("SELECT account_id FROM user_bank_accounts WHERE user_id = ? AND bank_code = ? AND account_number = ?");
        $stmt->execute([$userId, $bankCode, $accountNumber]);
        
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'error' => 'Tài khoản ngân hàng này đã tồn tại']);
            return;
        }
        
        // If this is first bank, make it default
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM user_bank_accounts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        $isDefault = ($count == 0) ? 1 : 0;
        
        // Insert bank account
        $stmt = $pdo->prepare("
            INSERT INTO user_bank_accounts 
            (user_id, bank_code, bank_name, account_number, account_holder, account_nickname, is_default, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'active')
        ");
        
        $stmt->execute([$userId, $bankCode, $bankName, $accountNumber, $accountHolder, $accountNickname, $isDefault]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Thêm tài khoản ngân hàng thành công',
            'account_id' => $pdo->lastInsertId()
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

/**
 * Lấy danh sách tài khoản ngân hàng của user
 */
function handleListBankAccounts() {
    global $user;
    
    try {
        if (!$user->_logged_in) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }
        
        $userId = $user->_data['user_id'];
        
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("
            SELECT * FROM user_bank_accounts 
            WHERE user_id = ? AND status = 'active' 
            ORDER BY is_default DESC, created_at DESC
        ");
        $stmt->execute([$userId]);
        $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'accounts' => $accounts
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

/**
 * Xóa tài khoản ngân hàng
 */
function handleDeleteBankAccount() {
    global $user;
    
    try {
        if (!$user->_logged_in) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data) {
            $data = $_POST;
        }
        
        $userId = $user->_data['user_id'];
        $accountId = intval($data['account_id'] ?? 0);
        
        if ($accountId <= 0) {
            echo json_encode(['success' => false, 'error' => 'Invalid account ID']);
            return;
        }
        
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Verify ownership
        $stmt = $pdo->prepare("SELECT account_id FROM user_bank_accounts WHERE account_id = ? AND user_id = ?");
        $stmt->execute([$accountId, $userId]);
        
        if (!$stmt->fetch()) {
            echo json_encode(['success' => false, 'error' => 'Account not found or unauthorized']);
            return;
        }
        
        // Soft delete
        $stmt = $pdo->prepare("UPDATE user_bank_accounts SET status = 'inactive', updated_at = NOW() WHERE account_id = ?");
        $stmt->execute([$accountId]);
        
        echo json_encode(['success' => true, 'message' => 'Xóa tài khoản ngân hàng thành công']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

/**
 * Set tài khoản ngân hàng mặc định
 */
function handleSetDefaultBank() {
    global $user;
    
    try {
        if (!$user->_logged_in) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data) {
            $data = $_POST;
        }
        
        $userId = $user->_data['user_id'];
        $accountId = intval($data['account_id'] ?? 0);
        
        if ($accountId <= 0) {
            echo json_encode(['success' => false, 'error' => 'Invalid account ID']);
            return;
        }
        
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Verify ownership
        $stmt = $pdo->prepare("SELECT account_id FROM user_bank_accounts WHERE account_id = ? AND user_id = ?");
        $stmt->execute([$accountId, $userId]);
        
        if (!$stmt->fetch()) {
            echo json_encode(['success' => false, 'error' => 'Account not found']);
            return;
        }
        
        // Unset all defaults
        $stmt = $pdo->prepare("UPDATE user_bank_accounts SET is_default = 0 WHERE user_id = ?");
        $stmt->execute([$userId]);
        
        // Set new default
        $stmt = $pdo->prepare("UPDATE user_bank_accounts SET is_default = 1, updated_at = NOW() WHERE account_id = ?");
        $stmt->execute([$accountId]);
        
        echo json_encode(['success' => true, 'message' => 'Đã cập nhật tài khoản mặc định']);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

/**
 * Tạo yêu cầu rút tiền
 */
function handleCreateWithdrawal() {
    global $user, $db;
    
    try {
        if (!$user->_logged_in) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data) {
            $data = $_POST;
        }
        
        $userId = $user->_data['user_id'];
        $accountId = intval($data['account_id'] ?? 0);
        $amount = floatval($data['amount'] ?? 0);
        
        // Validation
        if ($amount < 50000) {
            echo json_encode(['success' => false, 'error' => 'Số tiền tối thiểu 50,000 VNĐ']);
            return;
        }
        
        if ($amount > 50000000) {
            echo json_encode(['success' => false, 'error' => 'Số tiền tối đa 50,000,000 VNĐ/lần']);
            return;
        }
        
        // Get user balance
        $get_balance = $db->query(sprintf("SELECT user_wallet_balance FROM users WHERE user_id = %s", secure($userId, 'int')));
        $balance_data = $get_balance->fetch_assoc();
        $currentBalance = floatval($balance_data['user_wallet_balance']);
        
        if ($amount > $currentBalance) {
            echo json_encode(['success' => false, 'error' => 'Số dư không đủ']);
            return;
        }
        
        // Get bank account info
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT * FROM user_bank_accounts WHERE account_id = ? AND user_id = ? AND status = 'active'");
        $stmt->execute([$accountId, $userId]);
        $bankAccount = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$bankAccount) {
            echo json_encode(['success' => false, 'error' => 'Tài khoản ngân hàng không tồn tại']);
            return;
        }
        
        // Calculate fee (1%)
        $fee = $amount * 0.01;
        $actualAmount = $amount - $fee;
        
        // Generate QR code with WD prefix
        $qrCode = 'WD' . strtoupper(substr(md5(uniqid() . $userId . time()), 0, 6));
        $transferContent = $qrCode . " - Rut tien Shop AI";
        
        // Hold balance immediately
        $db->query(sprintf("UPDATE users SET user_wallet_balance = user_wallet_balance - %s WHERE user_id = %s", 
            secure($amount, 'float'), 
            secure($userId, 'int')
        )) or _error('SQL_ERROR');
        
        // Generate VietQR for admin to scan
        $qrImageUrl = generateWithdrawalQR($actualAmount, $qrCode, $bankAccount['account_number'], $bankAccount['bank_code'], $bankAccount['account_holder']);
        
        // Save to qr_code_mapping
        $stmt = $pdo->prepare("
            INSERT INTO qr_code_mapping 
            (qr_code, user_id, amount, fee, status, transaction_type, 
             withdrawal_bank_code, withdrawal_bank_name, withdrawal_account_number, withdrawal_account_holder,
             expires_at, description, transfer_content, qr_image_url, created_at, updated_at) 
            VALUES (?, ?, ?, ?, 'active', 'withdrawal', ?, ?, ?, ?, DATE_ADD(NOW(), INTERVAL 15 MINUTE), ?, ?, ?, NOW(), NOW())
        ");
        
        $stmt->execute([
            $qrCode, $userId, $amount, $fee,
            $bankAccount['bank_code'], $bankAccount['bank_name'], 
            $bankAccount['account_number'], $bankAccount['account_holder'],
            'Shop-AI Withdrawal Request', $transferContent, $qrImageUrl
        ]);
        
        // Update last_used_at
        $stmt = $pdo->prepare("UPDATE user_bank_accounts SET last_used_at = NOW() WHERE account_id = ?");
        $stmt->execute([$accountId]);
        
        // Log transaction
        $db->query(sprintf("
            INSERT INTO users_wallets_transactions (user_id, type, amount, description, time) 
            VALUES (%s, 'withdraw_request', %s, 'Yêu cầu rút tiền - %s', NOW())
        ", secure($userId, 'int'), secure($amount, 'float'), secure($qrCode)));
        
        echo json_encode([
            'success' => true,
            'message' => 'Tạo yêu cầu rút tiền thành công',
            'data' => [
                'qr_code' => $qrCode,
                'qr_image_url' => $qrImageUrl,
                'amount' => $amount,
                'fee' => $fee,
                'actual_amount' => $actualAmount,
                'bank_name' => $bankAccount['bank_name'],
                'account_number' => $bankAccount['account_number'],
                'account_holder' => $bankAccount['account_holder'],
                'expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes'))
            ]
        ]);
        
    } catch (Exception $e) {
        // Rollback balance nếu có lỗi
        if (isset($userId) && isset($amount)) {
            global $db;
            $db->query(sprintf("UPDATE users SET user_wallet_balance = user_wallet_balance + %s WHERE user_id = %s", 
                secure($amount, 'float'), 
                secure($userId, 'int')
            ));
        }
        
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

/**
 * Generate VietQR for withdrawal (admin scan to transfer to user)
 */
function generateWithdrawalQR($amount, $qr_code, $recipient_account, $recipient_bank_code, $recipient_name = '') {
    // VietQR API - Tạo QR để admin scan, tự động điền thông tin chuyển khoản cho user
    $vietqr_api_url = 'https://api.vietqr.io/v2/generate';
    $vietqr_data = array(
        'accountNo' => $recipient_account,
        'accountName' => !empty($recipient_name) ? $recipient_name : 'Recipient',
        'acqId' => $recipient_bank_code,
        'amount' => intval($amount),
        'addInfo' => $qr_code,
        'format' => 'text',
        'template' => 'compact'
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $vietqr_api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vietqr_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code == 200 && $response) {
        $result = json_decode($response, true);
        if (isset($result['data']['qrDataURL'])) {
            return $result['data']['qrDataURL'];
        }
    }
    
    // Fallback to image URL
    $timestamp = time();
    return "https://img.vietqr.io/image/{$recipient_bank_code}-{$recipient_account}-{$amount}-" . urlencode($qr_code) . ".jpg?t={$timestamp}";
}

/**
 * Kiểm tra trạng thái rút tiền
 */
function handleCheckWithdrawalStatus() {
    global $user;
    
    try {
        if (!$user->_logged_in) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data) {
            $data = $_POST;
        }
        
        $userId = $user->_data['user_id'];
        $qrCode = trim($data['qr_code'] ?? '');
        
        if (empty($qrCode)) {
            echo json_encode(['success' => false, 'error' => 'Missing QR code']);
            return;
        }
        
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("
            SELECT *, TIMESTAMPDIFF(SECOND, NOW(), expires_at) as time_left 
            FROM qr_code_mapping 
            WHERE qr_code = ? AND user_id = ? AND transaction_type = 'withdrawal'
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $stmt->execute([$qrCode, $userId]);
        $withdrawal = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$withdrawal) {
            echo json_encode(['success' => false, 'error' => 'Withdrawal not found']);
            return;
        }
        
        // Check status
        $status = $withdrawal['status'];
        $timeLeft = intval($withdrawal['time_left']);
        
        if ($timeLeft <= 0 && $status === 'active') {
            $status = 'expired';
        }
        
        echo json_encode([
            'success' => true,
            'status' => $status,
            'time_left' => max(0, $timeLeft),
            'amount' => $withdrawal['amount'],
            'fee' => $withdrawal['fee'],
            'actual_amount' => $withdrawal['amount'] - $withdrawal['fee'],
            'created_at' => $withdrawal['created_at'],
            'expires_at' => $withdrawal['expires_at']
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

/**
 * Hủy yêu cầu rút tiền
 */
function handleCancelWithdrawal() {
    global $user, $db;
    
    try {
        if (!$user->_logged_in) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data) {
            $data = $_POST;
        }
        
        $userId = $user->_data['user_id'];
        $qrCode = trim($data['qr_code'] ?? '');
        
        if (empty($qrCode)) {
            echo json_encode(['success' => false, 'error' => 'Missing QR code']);
            return;
        }
        
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Get withdrawal info
        $stmt = $pdo->prepare("
            SELECT * FROM qr_code_mapping 
            WHERE qr_code = ? AND user_id = ? AND transaction_type = 'withdrawal' AND status = 'active'
            LIMIT 1
        ");
        $stmt->execute([$qrCode, $userId]);
        $withdrawal = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$withdrawal) {
            echo json_encode(['success' => false, 'error' => 'Withdrawal not found or already processed']);
            return;
        }
        
        // Refund balance
        $db->query(sprintf("UPDATE users SET user_wallet_balance = user_wallet_balance + %s WHERE user_id = %s", 
            secure($withdrawal['amount'], 'float'), 
            secure($userId, 'int')
        )) or _error('SQL_ERROR');
        
        // Update status to cancelled
        $stmt = $pdo->prepare("UPDATE qr_code_mapping SET status = 'cancelled', updated_at = NOW() WHERE qr_code = ?");
        $stmt->execute([$qrCode]);
        
        // Log transaction
        $db->query(sprintf("
            INSERT INTO users_wallets_transactions (user_id, type, amount, description, time) 
            VALUES (%s, 'withdraw_cancelled', %s, 'Hủy rút tiền - %s', NOW())
        ", secure($userId, 'int'), secure($withdrawal['amount'], 'float'), secure($qrCode)));
        
        echo json_encode([
            'success' => true,
            'message' => 'Đã hủy yêu cầu rút tiền và hoàn lại số dư',
            'refunded_amount' => $withdrawal['amount']
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

/**
 * Lấy lịch sử rút tiền
 */
function handleGetWithdrawalHistory() {
    global $user;
    
    try {
        if (!$user->_logged_in) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }
        
        $userId = $user->_data['user_id'];
        $limit = intval($_GET['limit'] ?? 50);
        $offset = intval($_GET['offset'] ?? 0);
        
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("
            SELECT 
                qr_code,
                amount,
                fee,
                (amount - fee) as actual_amount,
                withdrawal_bank_name,
                withdrawal_account_number,
                status,
                created_at,
                updated_at,
                expires_at
            FROM qr_code_mapping 
            WHERE user_id = ? AND transaction_type = 'withdrawal'
            ORDER BY created_at DESC 
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$userId, $limit, $offset]);
        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'history' => $history,
            'total' => count($history)
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

// page footer
page_footer('shop-ai');