<?php

/**
 * shop-ai
 * 
 * @package Sngine
 * @author Zamblek
 */

// Error reporting disabled for production
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('log_errors', 1);
// ini_set('error_log', '/Applications/XAMPP/xamppfiles/logs/php_error.log');

// fetch bootloader
require('bootloader.php');

// Include rank system
require_once(__DIR__ . '/includes/class-rank.php');

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
    $public_views = ['pricing']; // Các view không cần đăng nhập
    
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
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("SELECT user_wallet_balance FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? floatval($result['user_wallet_balance']) : 0;
    } catch (PDOException $e) {
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
            WHERE user_id = ? AND type = 'recharge' 
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
            WHERE user_id = ? AND type = 'recharge' 
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
            WHERE user_id = ? AND type = 'recharge'
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
      
      // Get current user info
      $user_id = $user->_data['user_id'];
      $current_balance = getUserBalance($user_id);
      
      // Get phone check history (5 giao dịch gần nhất)
      $check_history = getPhoneCheckHistory($user_id, 5);
      
      // Handle check phone form submission
      $check_result = null;
      if (isset($_POST['check_phone']) && !empty($_POST['username'])) {
        $username_to_check = trim($_POST['username']);
        
        // Chỉ lưu trạng thái "pending" - admin sẽ cập nhật sau
        $pending_id = savePhoneCheckHistory(
          $user_id, 
          $username_to_check, 
          null, 
          null, 
          'pending', 
          'Đang check...'
        );
        
        if ($pending_id) {
          $check_result = [
            'success' => true,
            'message' => 'Yêu cầu check đã được lưu, admin sẽ xử lý sớm nhất có thể',
            'id' => $pending_id
          ];
        }
        
        // Refresh history after new check
        $check_history = getPhoneCheckHistory($user_id, 5);
      }
      
      // Assign variables to template
      $smarty->assign('current_balance', $current_balance);
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

    case 'pricing':
      // page header
      page_header(__("Bảng Giá Check Số Điện Thoại") . ' | ' . __($system['system_title']));
      
      // Initialize rank system
      $rankSystem = new RankSystem();
      
      // Get all ranks for pricing table
      $all_ranks = $rankSystem->getAllRanks();
      
      // Get user info if logged in
      if ($user->_logged_in) {
        $user_id = $user->_data['user_id'];
        $current_balance = getUserBalance($user_id);
        
        // Get current user rank
        $user_rank = $rankSystem->getUserRank($user_id);
        
        // Get rank progress
        $rank_progress = $rankSystem->getRankProgress($user_id);
        
        // Assign user-specific variables
        $smarty->assign('current_balance', $current_balance);
        $smarty->assign('user_rank', $user_rank);
        $smarty->assign('rank_progress', $rank_progress);
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

  // get total friend requests sent
  if ($user->_logged_in) {
    $user->_data['friend_requests_sent_total'] = $user->get_friend_requests_sent_total();
  } else {
    $user->_data['friend_requests_sent_total'] = 0;
  }

  // get ads campaigns (only if user is logged in)
  if ($user->_logged_in) {
    $smarty->assign('ads_campaigns', $user->ads_campaigns());
    $smarty->assign('ads', $user->ads('people'));
    $smarty->assign('widgets', $user->widgets('people'));
  } else {
    $smarty->assign('ads_campaigns', array());
    $smarty->assign('ads', array());
    $smarty->assign('widgets', array());
  }
} catch (Exception $e) {
  _error(__("Error"), $e->getMessage());
}

// page footer
page_footer('shop-ai');