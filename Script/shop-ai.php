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

// user access - bắt buộc đăng nhập
// user_access();

// Lấy user_id thật từ session hoặc mặc định = 1
if (!isset($user) || !isset($user->_data['user_id'])) {
    $user = new stdClass();
    $user->_data = array();
    $user->_data['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
    $user->_data['user_name'] = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Test User';
    $user->_data['user_email'] = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'test@example.com';
}

// Function to generate VietQR using API
function generateVietQR($amount, $content) {
    // Bank information - ACB Bank
    $bank_account = 'PHATLOC46241987';
    $bank_code = '970416'; // ACB Bank code for VietQR
    $bank_name = 'ACB - BUI QUOC VU';
    
    // Method 1: Try VietQR API with proper EMV format
    $vietqr_api_url = 'https://api.vietqr.io/v2/generate';
    $vietqr_data = array(
        'accountNo' => $bank_account,
        'accountName' => 'BUI QUOC VU',
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

// Function to get user balance using PDO
function getUserBalance($user_id) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("SELECT balance FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? floatval($result['balance']) : 0;
    } catch (PDOException $e) {
        return 0;
    }
}

// Function to save QR code mapping using PDO
function saveQRCodeMapping($qr_content, $user_id, $amount) {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("INSERT INTO qr_code_mapping (qr_code, user_id, amount, status, created_at) VALUES (?, ?, ?, 'active', NOW())");
        return $stmt->execute([$qr_content, $user_id, $amount]);
    } catch (PDOException $e) {
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
      page_header(__("Lịch sử giao dịch") . ' | ' . __($system['system_title']));
      
      // Get current balance for user
      $user_id = $user->_data['user_id'];
      $current_balance = getUserBalance($user_id);
      
      // Assign balance to template
      $smarty->assign('current_balance', $current_balance);
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