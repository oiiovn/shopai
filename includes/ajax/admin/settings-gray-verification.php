<?php

/**
 * ajax -> admin -> settings -> gray verification
 * 
 * @package Sngine
 * @author TCSN Team
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// check admin permission
if (!$user->_is_admin) {
  modal("MESSAGE", __("System Message"), __("You don't have the right permission to access this"));
}

// check demo account
if ($user->_data['user_demo']) {
  modal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

try {

  switch ($_GET['do']) {
    case 'edit':
      // Gray Verification Settings
      $edit['gray_verification_enabled'] = (isset($_POST['gray_verification_enabled'])) ? '1' : '0';
      $edit['gray_verification_min_likes'] = (!is_empty($_POST['gray_verification_min_likes']) && is_numeric($_POST['gray_verification_min_likes']) && $_POST['gray_verification_min_likes'] >= 0) ? $_POST['gray_verification_min_likes'] : 50;
      $edit['gray_verification_min_posts'] = (!is_empty($_POST['gray_verification_min_posts']) && is_numeric($_POST['gray_verification_min_posts']) && $_POST['gray_verification_min_posts'] >= 0) ? $_POST['gray_verification_min_posts'] : 5;
      $edit['gray_verification_min_active_days'] = (!is_empty($_POST['gray_verification_min_active_days']) && is_numeric($_POST['gray_verification_min_active_days']) && $_POST['gray_verification_min_active_days'] >= 1) ? $_POST['gray_verification_min_active_days'] : 14;
      
      $edit['gray_verification_require_business_info'] = (isset($_POST['gray_verification_require_business_info'])) ? '1' : '0';
      $edit['gray_verification_require_cover_photo'] = (isset($_POST['gray_verification_require_cover_photo'])) ? '1' : '0';
      $edit['gray_verification_require_description'] = (isset($_POST['gray_verification_require_description'])) ? '1' : '0';
      $edit['gray_verification_require_website'] = (isset($_POST['gray_verification_require_website'])) ? '1' : '0';
      $edit['gray_verification_require_location'] = (isset($_POST['gray_verification_require_location'])) ? '1' : '0';
      
      $edit['gray_verification_auto_approve'] = (isset($_POST['gray_verification_auto_approve'])) ? '1' : '0';
      $edit['gray_verification_manual_review'] = (isset($_POST['gray_verification_manual_review'])) ? '1' : '0';
      
      $edit['gray_verification_notify_admins'] = (isset($_POST['gray_verification_notify_admins'])) ? '1' : '0';
      $edit['gray_verification_notify_users'] = (isset($_POST['gray_verification_notify_users'])) ? '1' : '0';

      // update system settings
      foreach ($edit as $key => $value) {
        $db->query(sprintf("UPDATE system_options SET option_value = %s WHERE option_name = %s", secure($value), secure($key))) or _error('SQL_ERROR_THROWEN');
      }

      // return & exit
      return_json(array('success' => true, 'message' => __("System settings have been updated")));
      break;

    case 'get_stats':
      // Include Gray Verification class
      require_once(ABSPATH . 'includes/class-gray-verification.php');
      $gray_verification = new GrayVerification($db, $system);
      
      $stats = $gray_verification->getStatistics();
      
      return_json(array('success' => true, 'stats' => $stats));
      break;

    case 'test_criteria':
      // Include Gray Verification class
      require_once(ABSPATH . 'includes/class-gray-verification.php');
      $gray_verification = new GrayVerification($db, $system);
      
      // Get sample of unverified pages
      $get_pages = $db->query("SELECT page_id FROM pages WHERE page_verified = '0' ORDER BY page_date DESC LIMIT 10");
      
      $eligible_count = 0;
      $total_tested = 0;
      
      while ($page = $get_pages->fetch_assoc()) {
        $total_tested++;
        $eligibility = $gray_verification->checkEligibility($page['page_id']);
        if ($eligibility['eligible']) {
          $eligible_count++;
        }
      }
      
      $message = sprintf("Tested %d pages. %d pages are eligible for gray verification with current criteria.", $total_tested, $eligible_count);
      
      return_json(array('success' => true, 'message' => $message));
      break;

    case 'process_auto_approvals':
      // Include Gray Verification class
      require_once(ABSPATH . 'includes/class-gray-verification.php');
      $gray_verification = new GrayVerification($db, $system);
      
      $result = $gray_verification->processAutoApprovals();
      
      return_json(array('success' => true, 'message' => $result['message']));
      break;

    default:
      _error(400);
      break;
  }

} catch (Exception $e) {
  return_json(array('error' => true, 'message' => $e->getMessage()));
}
