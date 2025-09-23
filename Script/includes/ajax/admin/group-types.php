<?php

/**
 * ajax -> admin -> group-types
 * 
 * @package Sngine
 * @author Shop-AI Team
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// check admin|moderator permission
if (!$user->_is_admin && !$user->_is_moderator) {
  modal("MESSAGE", __("System Message"), __("You don't have the right permission to access this"));
}

// check demo account
if ($user->_data['user_demo']) {
  modal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

// include group types class
require_once('../../../includes/class-group-types.php');
$group_types = new GroupTypes($db, $user, $system);

// handle group types management
try {

  switch ($_GET['do']) {
    
    case 'get_types':
      $status = secure($_GET['status']) ?: 'active';
      $types = $group_types->get_group_types($status);
      
      /* return */
      return_json(array('success' => true, 'types' => $types));
      break;

    case 'get_type':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['id'], 'int');
      $type = $group_types->get_group_type($type_id);
      
      if (!$type) {
        throw new Exception(__("Group type not found"));
      }
      
      /* return */
      return_json(array('success' => true, 'type' => $type));
      break;

    case 'create_type':
      /* valid inputs */
      if (is_empty($_POST['type_name'])) {
        throw new Exception(__("Please enter group type name"));
      }
      if (is_empty($_POST['type_key'])) {
        throw new Exception(__("Please enter group type key"));
      }
      if (!preg_match('/^[a-z0-9_]+$/', $_POST['type_key'])) {
        throw new Exception(__("Group type key can only contain lowercase letters, numbers, and underscores"));
      }
      
      // Check if type key already exists
      $existing_type = $group_types->get_group_type_by_key($_POST['type_key']);
      if ($existing_type) {
        throw new Exception(__("Group type key already exists"));
      }
      
      $type_data = [
        'name' => $_POST['type_name'],
        'key' => $_POST['type_key'],
        'description' => $_POST['type_description'],
        'icon' => $_POST['type_icon'] ?: 'fas fa-users',
        'color' => $_POST['type_color'] ?: '#007bff',
        'features' => json_decode($_POST['type_features'], true) ?: [],
        'settings' => json_decode($_POST['type_settings'], true) ?: [],
        'permissions' => json_decode($_POST['type_permissions'], true) ?: [],
        'custom_fields' => json_decode($_POST['type_custom_fields'], true) ?: [],
        'status' => $_POST['type_status'] ?: 'active',
        'order' => $_POST['type_order'] ?: 0
      ];
      
      $type_id = $group_types->create_group_type($type_data);
      
      if ($type_id) {
        /* return */
        return_json(array('success' => true, 'message' => __("Group type created successfully"), 'type_id' => $type_id));
      } else {
        throw new Exception(__("Failed to create group type"));
      }
      break;

    case 'update_type':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['id'], 'int');
      
      // Check if type exists
      $existing_type = $group_types->get_group_type($type_id);
      if (!$existing_type) {
        throw new Exception(__("Group type not found"));
      }
      
      $type_data = [];
      
      if (isset($_POST['type_name'])) {
        $type_data['name'] = $_POST['type_name'];
      }
      if (isset($_POST['type_description'])) {
        $type_data['description'] = $_POST['type_description'];
      }
      if (isset($_POST['type_icon'])) {
        $type_data['icon'] = $_POST['type_icon'];
      }
      if (isset($_POST['type_color'])) {
        $type_data['color'] = $_POST['type_color'];
      }
      if (isset($_POST['type_features'])) {
        $type_data['features'] = json_decode($_POST['type_features'], true) ?: [];
      }
      if (isset($_POST['type_settings'])) {
        $type_data['settings'] = json_decode($_POST['type_settings'], true) ?: [];
      }
      if (isset($_POST['type_permissions'])) {
        $type_data['permissions'] = json_decode($_POST['type_permissions'], true) ?: [];
      }
      if (isset($_POST['type_custom_fields'])) {
        $type_data['custom_fields'] = json_decode($_POST['type_custom_fields'], true) ?: [];
      }
      if (isset($_POST['type_status'])) {
        $type_data['status'] = $_POST['type_status'];
      }
      if (isset($_POST['type_order'])) {
        $type_data['order'] = $_POST['type_order'];
      }
      
      $success = $group_types->update_group_type($type_id, $type_data);
      
      if ($success) {
        /* return */
        return_json(array('success' => true, 'message' => __("Group type updated successfully")));
      } else {
        throw new Exception(__("Failed to update group type"));
      }
      break;

    case 'delete_type':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['id'], 'int');
      
      $success = $group_types->delete_group_type($type_id);
      
      if ($success) {
        /* return */
        return_json(array('success' => true, 'message' => __("Group type deleted successfully")));
      } else {
        throw new Exception(__("Failed to delete group type"));
      }
      break;

    case 'apply_to_group':
      /* valid inputs */
      if (!isset($_GET['group_id']) || !is_numeric($_GET['group_id'])) {
        _error(400);
      }
      if (!isset($_GET['type_id']) || !is_numeric($_GET['type_id'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['group_id'], 'int');
      $type_id = secure($_GET['type_id'], 'int');
      
      // Check if user has permission to modify group
      if (!$user->_is_admin && !$user->_is_moderator) {
        // Check if user is group admin
        $group_query = "SELECT group_admin FROM groups WHERE group_id = " . secure($group_id, 'int');
        $group_result = $db->query($group_query);
        $group_row = $group_result->fetch_assoc();
        
        if (!$group_row || $group_row['group_admin'] != $user->_data['user_id']) {
          _error(403);
        }
      }
      
      $success = $group_types->apply_group_type($group_id, $type_id);
      
      if ($success) {
        /* return */
        return_json(array('success' => true, 'message' => __("Group type applied successfully")));
      } else {
        throw new Exception(__("Failed to apply group type"));
      }
      break;

    case 'get_type_statistics':
      $statistics = $group_types->get_type_statistics();
      
      /* return */
      return_json(array('success' => true, 'statistics' => $statistics));
      break;

    case 'get_groups_by_type':
      /* valid inputs */
      if (!isset($_GET['type_id']) || !is_numeric($_GET['type_id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['type_id'], 'int');
      $limit = secure($_GET['limit'], 'int') ?: 20;
      
      $groups = $group_types->get_groups_by_type($type_id, $limit);
      
      /* return */
      return_json(array('success' => true, 'groups' => $groups));
      break;

    case 'update_type_features':
      /* valid inputs */
      if (!isset($_GET['type_id']) || !is_numeric($_GET['type_id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['type_id'], 'int');
      
      if (is_empty($_POST['features']) || !is_array($_POST['features'])) {
        throw new Exception(__("Please provide valid features data"));
      }
      
      // Delete existing features
      $db->query("DELETE FROM groups_type_features WHERE type_id = " . secure($type_id, 'int'));
      
      // Insert new features
      foreach ($_POST['features'] as $index => $feature) {
        if (!is_empty($feature['feature_key']) && !is_empty($feature['feature_name'])) {
          $query = "INSERT INTO groups_type_features (
                      type_id, feature_key, feature_name, feature_description,
                      feature_icon, feature_enabled, feature_required,
                      feature_settings, feature_order
                    ) VALUES (
                      " . secure($type_id, 'int') . ",
                      " . secure($feature['feature_key']) . ",
                      " . secure($feature['feature_name']) . ",
                      " . secure($feature['feature_description']) . ",
                      " . secure($feature['feature_icon']) . ",
                      " . secure($feature['feature_enabled']) . ",
                      " . secure($feature['feature_required']) . ",
                      " . secure(json_encode($feature['feature_settings'])) . ",
                      " . secure($index, 'int') . "
                    )";
          $db->query($query);
        }
      }
      
      /* return */
      return_json(array('success' => true, 'message' => __("Type features updated successfully")));
      break;

    case 'update_type_settings':
      /* valid inputs */
      if (!isset($_GET['type_id']) || !is_numeric($_GET['type_id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['type_id'], 'int');
      
      if (is_empty($_POST['settings']) || !is_array($_POST['settings'])) {
        throw new Exception(__("Please provide valid settings data"));
      }
      
      // Delete existing settings
      $db->query("DELETE FROM groups_type_settings WHERE type_id = " . secure($type_id, 'int'));
      
      // Insert new settings
      foreach ($_POST['settings'] as $setting) {
        if (!is_empty($setting['setting_key'])) {
          $query = "INSERT INTO groups_type_settings (
                      type_id, setting_key, setting_value, setting_type, setting_description
                    ) VALUES (
                      " . secure($type_id, 'int') . ",
                      " . secure($setting['setting_key']) . ",
                      " . secure($setting['setting_value']) . ",
                      " . secure($setting['setting_type']) . ",
                      " . secure($setting['setting_description']) . "
                    )";
          $db->query($query);
        }
      }
      
      /* return */
      return_json(array('success' => true, 'message' => __("Type settings updated successfully")));
      break;

    case 'update_type_permissions':
      /* valid inputs */
      if (!isset($_GET['type_id']) || !is_numeric($_GET['type_id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['type_id'], 'int');
      
      if (is_empty($_POST['permissions']) || !is_array($_POST['permissions'])) {
        throw new Exception(__("Please provide valid permissions data"));
      }
      
      // Delete existing permissions
      $db->query("DELETE FROM groups_type_permissions WHERE type_id = " . secure($type_id, 'int'));
      
      // Insert new permissions
      foreach ($_POST['permissions'] as $role => $permissions) {
        if (in_array($role, ['admin', 'moderator', 'editor', 'member'])) {
          $query = "INSERT INTO groups_type_permissions (
                      type_id, role, permissions
                    ) VALUES (
                      " . secure($type_id, 'int') . ",
                      " . secure($role) . ",
                      " . secure(json_encode($permissions)) . "
                    )";
          $db->query($query);
        }
      }
      
      /* return */
      return_json(array('success' => true, 'message' => __("Type permissions updated successfully")));
      break;

    default:
      _error(400);
      break;
  }

} catch (Exception $e) {
  return_json(array('error' => true, 'message' => $e->getMessage()));
}
