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

// user access (allow without login for shop-ai)
// user_access();

// Initialize user object for template
if (!isset($user)) {
    $user = new stdClass();
    $user->_logged_in = false;
    $user->_data = array();
}

// Function to generate VietQR using API
function generateVietQR($amount, $content) {
    // Bank information - ACB Bank
    $bank_account = 'PHATLOC46241987';
    $bank_name = 'ACB - BUI QUOC VU'; // Full bank information
    
    // Create VietQR URL
    $qr_url = "https://vietqr.net/transfer/{$bank_account}?amount={$amount}&content=" . urlencode($content);
    
    // Use VietQR image service for ACB bank
    $qr_image_url = "https://img.vietqr.io/image/acb-{$bank_account}-{$amount}-" . urlencode($content) . ".jpg";
    
    return $qr_image_url;
}

try {

  // get view content
  switch ($_GET['view']) {
    case '':
    case 'check':
      // page header
      page_header(__("Shop AI") . ' | ' . __($system['system_title']));
      break;

    case 'recharge':
      // page header
      page_header(__("Nạp tiền") . ' | ' . __($system['system_title']));
      
      // handle recharge form submission
      if (isset($_POST['submit'])) {
        $amount = $_POST['amount'];
        
        // Generate unique content for each user and time
        $user_id = isset($user->_data['user_id']) ? $user->_data['user_id'] : 1;
        $timestamp = time();
        $random_string = substr(md5(uniqid(rand(), true)), 0, 8);
        $qr_content = "RZ" . $user_id . $timestamp . $random_string;
        
        // Generate QR code using VietQR API
        $qr_data = generateVietQR($amount, $qr_content);
        
        // Assign variables to template
        $smarty->assign('qr_data', $qr_data);
        $smarty->assign('qr_content', $qr_content);
        $smarty->assign('amount', $amount);
      }
      break;

    default:
      _error(404);
      break;
  }
  /* assign variables */
  $smarty->assign('view', $_GET['view']);

  // get total friend requests sent
  $user->_data['friend_requests_sent_total'] = $user->get_friend_requests_sent_total();

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
