<?php

/**
 * ajax -> admin -> page_business_types
 * 
 * @package Sngine
 * @author Custom Development
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// check admin|moderator permission
if ($user->_data['user_group'] >= 3) {
  modal("MESSAGE", __("System Message"), __("You don't have the right permission to access this"));
}

// check demo account
if ($user->_data['user_demo']) {
  modal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

try {

  switch ($_GET['do']) {
    case 'add':
      /* validate inputs */
      if (is_empty($_POST['type_name']) || is_empty($_POST['type_name_en']) || is_empty($_POST['type_slug'])) {
        throw new Exception(__("You must fill all the required fields"));
      }

      /* check if slug exists */
      $check_slug = $db->query(sprintf("SELECT business_type_id FROM page_business_types WHERE type_slug = %s", secure($_POST['type_slug'])));
      if ($check_slug->num_rows > 0) {
        throw new Exception(__("This slug already exists"));
      }

      /* prepare */
      $_POST['type_icon'] = !is_empty($_POST['type_icon']) ? $_POST['type_icon'] : 'fa-store';
      $_POST['type_color'] = !is_empty($_POST['type_color']) ? $_POST['type_color'] : '#007bff';
      $_POST['approval_required'] = (isset($_POST['approval_required'])) ? '1' : '0';

      /* insert */
      $db->query(sprintf("INSERT INTO page_business_types (type_name, type_name_en, type_slug, type_icon, type_color, type_description, approval_required) VALUES (%s, %s, %s, %s, %s, %s, %s)", secure($_POST['type_name']), secure($_POST['type_name_en']), secure($_POST['type_slug']), secure($_POST['type_icon']), secure($_POST['type_color']), secure($_POST['type_description']), secure($_POST['approval_required']))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['callback' => 'window.location.reload();']);
      break;

    case 'edit':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }

      /* validate inputs */
      if (is_empty($_POST['type_name']) || is_empty($_POST['type_name_en']) || is_empty($_POST['type_slug'])) {
        throw new Exception(__("You must fill all the required fields"));
      }

      /* check if slug exists (exclude current) */
      $check_slug = $db->query(sprintf("SELECT business_type_id FROM page_business_types WHERE type_slug = %s AND business_type_id != %s", secure($_POST['type_slug']), secure($_GET['id'], 'int')));
      if ($check_slug->num_rows > 0) {
        throw new Exception(__("This slug already exists"));
      }

      /* prepare */
      $_POST['type_icon'] = !is_empty($_POST['type_icon']) ? $_POST['type_icon'] : 'fa-store';
      $_POST['type_color'] = !is_empty($_POST['type_color']) ? $_POST['type_color'] : '#007bff';
      $_POST['approval_required'] = (isset($_POST['approval_required'])) ? '1' : '0';
      $_POST['is_active'] = (isset($_POST['is_active'])) ? '1' : '0';

      /* update */
      $db->query(sprintf("UPDATE page_business_types SET type_name = %s, type_name_en = %s, type_slug = %s, type_icon = %s, type_color = %s, type_description = %s, approval_required = %s, is_active = %s WHERE business_type_id = %s", secure($_POST['type_name']), secure($_POST['type_name_en']), secure($_POST['type_slug']), secure($_POST['type_icon']), secure($_POST['type_color']), secure($_POST['type_description']), secure($_POST['approval_required']), secure($_POST['is_active']), secure($_GET['id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['callback' => 'window.location.reload();']);
      break;

    case 'delete':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }

      /* check if business type has pages */
      $check_pages = $db->query(sprintf("SELECT COUNT(*) as count FROM pages WHERE page_business_type_id = %s", secure($_GET['id'], 'int')));
      $pages_count = $check_pages->fetch_assoc()['count'];
      
      if ($pages_count > 0) {
        throw new Exception(__("Cannot delete business type that has pages assigned to it"));
      }

      /* delete */
      $db->query(sprintf("DELETE FROM page_business_types WHERE business_type_id = %s", secure($_GET['id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['callback' => 'window.location.reload();']);
      break;

    case 'approve_request':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }

      /* get request */
      $get_request = $db->query(sprintf("SELECT * FROM page_business_type_requests WHERE request_id = %s", secure($_GET['id'], 'int')));
      if ($get_request->num_rows == 0) {
        throw new Exception(__("Request not found"));
      }
      $request = $get_request->fetch_assoc();

      /* update page business type */
      $db->query(sprintf("UPDATE pages SET page_business_type_id = %s, business_type_status = 'approved', business_type_approved_at = NOW(), business_type_approved_by = %s WHERE page_id = %s", secure($request['requested_type_id'], 'int'), secure($user->_data['user_id'], 'int'), secure($request['page_id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* update request status */
      $db->query(sprintf("UPDATE page_business_type_requests SET status = 'approved', reviewed_by = %s, reviewed_at = NOW() WHERE request_id = %s", secure($user->_data['user_id'], 'int'), secure($_GET['id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* auto-enable default features for this business type */
      $get_default_features = $db->query(sprintf("SELECT feature_id FROM page_business_type_features WHERE business_type_id = %s AND is_default = '1'", secure($request['requested_type_id'], 'int')));
      while ($feature = $get_default_features->fetch_assoc()) {
        $db->query(sprintf("INSERT IGNORE INTO page_enabled_features (page_id, feature_id, enabled_by_admin) VALUES (%s, %s, '1')", secure($request['page_id'], 'int'), secure($feature['feature_id'], 'int')));
      }

      /* return */
      return_json(['callback' => 'window.location.reload();']);
      break;

    case 'reject_request':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }

      /* get admin note if provided */
      $admin_note = $_POST['admin_note'] ?? '';

      /* update request status */
      $db->query(sprintf("UPDATE page_business_type_requests SET status = 'rejected', admin_note = %s, reviewed_by = %s, reviewed_at = NOW() WHERE request_id = %s", secure($admin_note), secure($user->_data['user_id'], 'int'), secure($_GET['id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['callback' => 'window.location.reload();']);
      break;

    case 'assign_type':
      /* valid inputs */
      if (!isset($_GET['page_id']) || !is_numeric($_GET['page_id']) || !isset($_POST['business_type_id']) || !is_numeric($_POST['business_type_id'])) {
        _error(400);
      }

      /* update page business type directly (admin override) */
      $db->query(sprintf("UPDATE pages SET page_business_type_id = %s, business_type_status = 'approved', business_type_approved_at = NOW(), business_type_approved_by = %s WHERE page_id = %s", secure($_POST['business_type_id'], 'int'), secure($user->_data['user_id'], 'int'), secure($_GET['page_id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* auto-enable default features */
      $get_default_features = $db->query(sprintf("SELECT feature_id FROM page_business_type_features WHERE business_type_id = %s AND is_default = '1'", secure($_POST['business_type_id'], 'int')));
      while ($feature = $get_default_features->fetch_assoc()) {
        $db->query(sprintf("INSERT IGNORE INTO page_enabled_features (page_id, feature_id, enabled_by_admin) VALUES (%s, %s, '1')", secure($_GET['page_id'], 'int'), secure($feature['feature_id'], 'int')));
      }

      /* return */
      return_json(['callback' => 'window.location.reload();']);
      break;

    case 'remove_type':
      /* valid inputs */
      if (!isset($_GET['page_id']) || !is_numeric($_GET['page_id'])) {
        _error(400);
      }

      /* remove business type from page */
      $db->query(sprintf("UPDATE pages SET page_business_type_id = NULL, business_type_status = 'unassigned', business_type_approved_at = NULL, business_type_approved_by = NULL WHERE page_id = %s", secure($_GET['page_id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* disable all features for this page */
      $db->query(sprintf("DELETE FROM page_enabled_features WHERE page_id = %s", secure($_GET['page_id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['callback' => 'window.location.reload();']);
      break;

    default:
      _error(400);
      break;
  }
} catch (Exception $e) {
  modal("ERROR", __("Error"), $e->getMessage());
}
?>
