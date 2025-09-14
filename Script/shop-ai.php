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

// Tạo user giả nếu chưa đăng nhập
if (!isset($user)) {
    $user = new stdClass();
    $user->_data = array();
    $user->_data['user_id'] = 1;
    $user->_data['user_name'] = 'Test User';
    $user->_data['user_email'] = 'test@example.com';
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

try {

  // get view content
  switch ($_GET['view']) {
    case '':
    case 'check':
      // page header
      page_header(__("Shop AI") . ' | ' . __($system['system_title']));
      
      // Get current balance for user
      $user_id = 1;
      $current_balance = getUserBalance($user_id);
      
      // Assign balance to template
      $smarty->assign('current_balance', $current_balance);
      break;

    case 'recharge':
      // page header
      page_header(__("Nạp tiền") . ' | ' . __($system['system_title']));
      
      // Get current balance for user
      $user_id = 1;
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
      $user_id = 1;
      $current_balance = getUserBalance($user_id);
      
      // Assign balance to template
      $smarty->assign('current_balance', $current_balance);
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