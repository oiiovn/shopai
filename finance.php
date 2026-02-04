<?php

/**
 * finance
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootloader
require('bootloader.php');

// Handle API requests (before user_access to allow AJAX calls)
if (isset($_GET['action']) || (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false)) {
    handleAPIRequest();
    exit;
}

// user access
user_access();

// Function to get user balance
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
        'accountName' => 'ACB Account',
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

// Function to save QR code mapping
function saveQRCodeMapping($qr_content, $user_id, $amount, $expires_minutes = 15) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $transfer_content = $qr_content . " - Nap tien Shop AI";
        
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

// Function to get Shop-AI transactions with pagination
function getShopAITransactionsPaginated($user_id, $limit = 10, $offset = 0) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
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

/**
 * Get admin info for contact
 */
function getAdminInfo() {
    global $db;
    
    try {
        // Get first admin (user_group = 1)
        $get_admin = $db->query("
            SELECT user_id, user_name, user_firstname, user_lastname, user_gender, user_picture, user_verified, user_phone
            FROM users 
            WHERE user_group = 1 
            ORDER BY user_id ASC 
            LIMIT 1
        ");
        
        if ($get_admin && $get_admin->num_rows > 0) {
            $admin = $get_admin->fetch_assoc();
            $admin['user_picture'] = get_picture($admin['user_picture'], $admin['user_gender']);
            $admin['name'] = $admin['user_firstname'] . ' ' . $admin['user_lastname'];
            if (empty(trim($admin['name']))) {
                $admin['name'] = $admin['user_name'];
            }
            // Zalo number (có thể lưu trong user_phone hoặc field riêng)
            $admin['zalo'] = $admin['user_phone'] ?? '';
            return $admin;
        }
        
        return null;
    } catch (Exception $e) {
        error_log("Error getting admin info: " . $e->getMessage());
        return null;
    }
}

try {
  // get view content
  $view = $_GET['view'] ?? '';
  
  switch ($view) {
    case '':
      // Redirect to recharge page
      header("Location: " . $system['system_url'] . "/finance/recharge");
      exit;
      break;

    case 'recharge':
      // page header - Nạp tiền
      page_header(__("Nạp tiền") . ' | ' . __($system['system_title']));
      
      // Get current balance for user
      $user_id = $user->_data['user_id'];
      $current_balance = getUserBalance($user_id);
      
      // Get admin info for contact
      $admin_info = getAdminInfo();
      
      // Assign balance to template
      $smarty->assign('current_balance', $current_balance);
      $smarty->assign('admin_info', $admin_info);
      
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
      // page header - Lịch sử giao dịch
      page_header(__("Lịch Sử Giao Dịch") . ' | ' . __($system['system_title']));
      
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
      
      // Get admin info for contact
      $admin_info = getAdminInfo();
      
      // Assign variables to template
      $smarty->assign('current_balance', $current_balance);
      $smarty->assign('shop_ai_transactions', $shop_ai_transactions);
      $smarty->assign('pagination', $pagination);
      $smarty->assign('admin_info', $admin_info);
      break;

    default:
      _error(404);
      break;
  }
  /* assign variables */
  $smarty->assign('view', $view);
} catch (Exception $e) {
  _error(__("Error"), $e->getMessage());
}

// Function to handle API requests
function handleAPIRequest() {
    global $user;
    
    header('Content-Type: application/json');
    
    // Check authentication
    if (!$user->_logged_in) {
        echo json_encode([
            'success' => false,
            'message' => 'Vui lòng đăng nhập'
        ]);
        exit;
    }
    
    // Get action from GET or POST
    $action = $_GET['action'] ?? '';
    
    // If no action in GET, try to get from JSON POST body
    if (empty($action) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $action = $data['action'] ?? '';
    }
    
    switch ($action) {
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

// Function to save QR mapping via AJAX
function handleSaveQRMapping() {
    global $user;
    
    try {
        // Get parameters
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        $qrCode = $data['qr_code'] ?? '';
        $amount = floatval($data['amount'] ?? 0);
        $userId = intval($data['user_id'] ?? 0);
        
        // Verify user_id matches logged in user
        if ($userId != $user->_data['user_id']) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid user'
            ]);
            return;
        }
        
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

// page footer
page_footer('finance');
