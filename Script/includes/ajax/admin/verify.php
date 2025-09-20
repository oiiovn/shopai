<?php

/**
 * ajax -> admin -> verify
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// check admin|moderator permission
if (!$user->_is_admin && !$user->_is_moderator) {
  modal("MESSAGE", __("System Message"), __("You don't have the right permission to access this"));
}

// valid inputs
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
  _error(400);
}

// check demo account
if ($user->_data['user_demo']) {
  modal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

// handle verify
try {

  switch ($_POST['handle']) {

    case 'user':
      /* approve request */
      $db->query(sprintf("UPDATE verification_requests SET status = '1' WHERE node_type = 'user' AND node_id = %s", secure($_POST['id'], 'int'))) or _error('SQL_ERROR_THROWEN');
      /* update user */
      $db->query(sprintf("UPDATE users SET user_verified = '1' WHERE user_id = %s", secure($_POST['id'], 'int'))) or _error('SQL_ERROR_THROWEN');
      break;

    case 'page':
      /* get verification level and request info */
      $verification_level = $_POST['level'] ?? 'blue'; // Default blue for backward compatibility
      $request_id = $_POST['request_id'] ?? null;
      
      if ($verification_level == 'gray') {
        /* approve gray verification */
        $db->query(sprintf("UPDATE pages SET page_verified = '2', page_verification_type = 'manual_gray', page_verification_date = NOW() WHERE page_id = %s", secure($_POST['id'], 'int'))) or _error('SQL_ERROR_THROWEN');
      } else {
        /* approve blue verification (existing logic) */
        $db->query(sprintf("UPDATE pages SET page_verified = '1', page_verification_type = 'manual_blue', page_verification_date = NOW() WHERE page_id = %s", secure($_POST['id'], 'int'))) or _error('SQL_ERROR_THROWEN');
      }
      
      /* approve request */
      if ($request_id) {
        $db->query(sprintf("UPDATE verification_requests SET status = '1' WHERE request_id = %s", secure($request_id, 'int'))) or _error('SQL_ERROR_THROWEN');
      } else {
        // Fallback for old requests
        $db->query(sprintf("UPDATE verification_requests SET status = '1' WHERE node_type = 'page' AND node_id = %s", secure($_POST['id'], 'int'))) or _error('SQL_ERROR_THROWEN');
      }
      break;

    case 'decline':
      /* decline request */
      $db->query(sprintf("UPDATE verification_requests SET status = '-1' WHERE request_id = %s", secure($_POST['id'], 'int'))) or _error('SQL_ERROR_THROWEN');
      break;

    default:
      _error(400);
      break;
  }

  // return & exist
  return_json();
} catch (Exception $e) {
  modal("ERROR", __("Error"), $e->getMessage());
}
