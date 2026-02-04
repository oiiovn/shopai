<?php

/**
 * ajax -> users -> update phone
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// user access
user_access(true);

// check demo account
if ($user->_data['user_demo']) {
  modal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

// declare global variables
global $db, $user;

try {

  // validate phone
  if (!isset($_POST['phone']) || empty($_POST['phone'])) {
    throw new Exception(__("Please enter your phone number"));
  }

  // validate phone format (10-11 digits)
  $phone = trim($_POST['phone']);
  if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
    throw new Exception(__("Please enter a valid phone number (10-11 digits)"));
  }

  // check if phone already exists (except current user)
  $check = $db->query(sprintf("SELECT user_id FROM users WHERE user_phone = %s AND user_id != %s", secure($phone), secure($user->_data['user_id'], 'int')));
  if ($check->num_rows > 0) {
    throw new Exception(__("This phone number is already in use by another account"));
  }

  // update phone number
  $db->query(sprintf(
    "UPDATE users SET user_phone = %s, user_phone_verified = '0' WHERE user_id = %s",
    secure($phone),
    secure($user->_data['user_id'], 'int')
  )) or _error('SQL_ERROR_THROWEN');

  // return success
  return_json(array('success' => true, 'message' => __("Phone number updated successfully!")));

} catch (Exception $e) {
  return_json(array('error' => true, 'message' => $e->getMessage()));
}

