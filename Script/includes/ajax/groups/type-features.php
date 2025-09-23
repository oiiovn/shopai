<?php

/**
 * ajax -> groups -> type-features
 * 
 * @package Sngine
 * @author Shop-AI Team
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// user access
user_access();

// include group types class
require_once('../../../includes/class-group-types.php');
$group_types = new GroupTypes($db, $user, $system);

// handle type-specific features
try {

  switch ($_GET['do']) {
    
    case 'get_group_features':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['id'], 'int');
      
      // Check if user has permission to view group
      if (!$user->check_group_membership($user->_data['user_id'], $group_id)) {
        _error(403);
      }
      
      $features = $group_types->get_group_features($group_id);
      
      /* return */
      return_json(array('success' => true, 'features' => $features));
      break;

    case 'check_feature_access':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      if (is_empty($_GET['feature'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['id'], 'int');
      $feature = secure($_GET['feature']);
      
      // Check if group has this feature
      $has_feature = $group_types->group_has_feature($group_id, $feature);
      
      if (!$has_feature) {
        return_json(array('success' => false, 'message' => __("This feature is not available for this group type")));
      }
      
      // Check if user has permission to use this feature
      $has_permission = $group_types->user_has_permission($group_id, $user->_data['user_id'], $feature);
      
      /* return */
      return_json(array('success' => true, 'has_permission' => $has_permission, 'has_feature' => $has_feature));
      break;

    case 'get_group_type_info':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['id'], 'int');
      
      // Check if user has permission to view group
      if (!$user->check_group_membership($user->_data['user_id'], $group_id)) {
        _error(403);
      }
      
      // Get group type info
      $query = "SELECT g.group_type_id, gt.type_name, gt.type_key, gt.type_description, 
                       gt.type_icon, gt.type_color, g.group_type_settings
                FROM groups g
                LEFT JOIN groups_types gt ON g.group_type_id = gt.type_id
                WHERE g.group_id = " . secure($group_id, 'int');
      
      $result = $db->query($query);
      
      if ($result->num_rows > 0) {
        $group_type = $result->fetch_assoc();
        $group_type['group_type_settings'] = json_decode($group_type['group_type_settings'], true);
        
        // Get user role
        $user_role = $group_types->get_user_role($group_id, $user->_data['user_id']);
        $group_type['user_role'] = $user_role;
        
        /* return */
        return_json(array('success' => true, 'group_type' => $group_type));
      } else {
        throw new Exception(__("Group not found"));
      }
      break;

    case 'get_available_types':
      $types = $group_types->get_group_types('active');
      
      /* return */
      return_json(array('success' => true, 'types' => $types));
      break;

    case 'apply_type_to_group':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      if (!isset($_GET['type_id']) || !is_numeric($_GET['type_id'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['id'], 'int');
      $type_id = secure($_GET['type_id'], 'int');
      
      // Check if user is group admin
      if (!$user->check_group_adminship($user->_data['user_id'], $group_id)) {
        _error(403);
      }
      
      $success = $group_types->apply_group_type($group_id, $type_id);
      
      if ($success) {
        /* return */
        return_json(array('success' => true, 'message' => __("Group type applied successfully")));
      } else {
        throw new Exception(__("Failed to apply group type"));
      }
      break;

    case 'get_type_features_detail':
      /* valid inputs */
      if (!isset($_GET['type_id']) || !is_numeric($_GET['type_id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['type_id'], 'int');
      
      $features = $group_types->get_type_features($type_id);
      
      /* return */
      return_json(array('success' => true, 'features' => $features));
      break;

    case 'get_type_settings_detail':
      /* valid inputs */
      if (!isset($_GET['type_id']) || !is_numeric($_GET['type_id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['type_id'], 'int');
      
      $settings = $group_types->get_type_settings($type_id);
      
      /* return */
      return_json(array('success' => true, 'settings' => $settings));
      break;

    case 'get_type_permissions_detail':
      /* valid inputs */
      if (!isset($_GET['type_id']) || !is_numeric($_GET['type_id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['type_id'], 'int');
      
      $permissions = $group_types->get_type_permissions($type_id);
      
      /* return */
      return_json(array('success' => true, 'permissions' => $permissions));
      break;

    case 'get_user_permissions':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['id'], 'int');
      
      // Check if user has permission to view group
      if (!$user->check_group_membership($user->_data['user_id'], $group_id)) {
        _error(403);
      }
      
      // Get user role
      $user_role = $group_types->get_user_role($group_id, $user->_data['user_id']);
      
      // Get group type
      $query = "SELECT group_type_id FROM groups WHERE group_id = " . secure($group_id, 'int');
      $result = $db->query($query);
      $group_row = $result->fetch_assoc();
      
      $permissions = [];
      if ($group_row['group_type_id']) {
        $type_permissions = $group_types->get_type_permissions($group_row['group_type_id']);
        $permissions = $type_permissions[$user_role]['permissions'] ?? [];
      }
      
      /* return */
      return_json(array('success' => true, 'user_role' => $user_role, 'permissions' => $permissions));
      break;

    case 'set_user_permissions':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      if (!isset($_GET['user_id']) || !is_numeric($_GET['user_id'])) {
        _error(400);
      }
      if (is_empty($_GET['role'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['id'], 'int');
      $target_user_id = secure($_GET['user_id'], 'int');
      $role = secure($_GET['role']);
      
      // Check if current user is group admin
      if (!$user->check_group_adminship($user->_data['user_id'], $group_id)) {
        _error(403);
      }
      
      // Get type permissions for the role
      $query = "SELECT group_type_id FROM groups WHERE group_id = " . secure($group_id, 'int');
      $result = $db->query($query);
      $group_row = $result->fetch_assoc();
      
      $permissions = [];
      if ($group_row['group_type_id']) {
        $type_permissions = $group_types->get_type_permissions($group_row['group_type_id']);
        $permissions = $type_permissions[$role]['permissions'] ?? [];
      }
      
      $success = $group_types->set_user_permissions($group_id, $target_user_id, $role, $permissions);
      
      if ($success) {
        /* return */
        return_json(array('success' => true, 'message' => __("User permissions updated successfully")));
      } else {
        throw new Exception(__("Failed to update user permissions"));
      }
      break;

    default:
      _error(400);
      break;
  }

} catch (Exception $e) {
  return_json(array('error' => true, 'message' => $e->getMessage()));
}
