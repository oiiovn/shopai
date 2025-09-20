<?php

/**
 * ajax -> admin -> pages
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

// check demo account
if ($user->_data['user_demo']) {
  modal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

// handle pages
try {

  switch ($_GET['do']) {
    case 'edit_page':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      if (!in_array($_GET['edit'], ['settings', 'info', 'action', 'social', 'monetization'])) {
        _error(400);
      }
      /* prepare */
      if ($_GET['edit'] == "settings") {
        // Handle new verification level dropdown
        if (isset($_POST['page_verification_level'])) {
          $_POST['page_verified'] = $_POST['page_verification_level'];
          
          // Set verification metadata
          if ($_POST['page_verification_level'] == '1') {
            $_POST['page_verification_type'] = 'manual_blue';
          } elseif ($_POST['page_verification_level'] == '2') {
            $_POST['page_verification_type'] = 'manual_gray';
          } else {
            $_POST['page_verification_type'] = null;
          }
          $_POST['page_verification_date'] = ($_POST['page_verification_level'] != '0') ? date('Y-m-d H:i:s') : null;
        } else {
          // Fallback for old checkbox (backward compatibility)
          $_POST['page_verified'] = (isset($_POST['page_verified'])) ? '1' : '0';
        }

        // Handle business type assignment by admin
        if (isset($_POST['page_business_type_id'])) {
          $old_business_type = null;
          $new_business_type = !empty($_POST['page_business_type_id']) ? intval($_POST['page_business_type_id']) : null;
          
          // Get current business type
          $get_current = $db->query(sprintf("SELECT page_business_type_id FROM pages WHERE page_id = %s", secure($_GET['id'], 'int')));
          if ($get_current->num_rows > 0) {
            $current = $get_current->fetch_assoc();
            $old_business_type = $current['page_business_type_id'];
          }
          
          // Only process if business type changed
          if ($old_business_type != $new_business_type) {
            // Update page business type
            $business_type_sql = ($new_business_type === null) ? 'NULL' : secure($new_business_type, 'int');
            $status_sql = ($new_business_type === null) ? "'unassigned'" : "'approved'";
            $approved_at_sql = ($new_business_type === null) ? 'NULL' : 'NOW()';
            $approved_by_sql = ($new_business_type === null) ? 'NULL' : secure($user->_data['user_id'], 'int');
            
            $db->query(sprintf("
              UPDATE pages SET 
                page_business_type_id = %s,
                business_type_status = %s,
                business_type_approved_at = %s,
                business_type_approved_by = %s
              WHERE page_id = %s
            ", $business_type_sql, $status_sql, $approved_at_sql, $approved_by_sql, secure($_GET['id'], 'int'))) or _error('SQL_ERROR_THROWEN');
            
            // Log the change in history
            if ($old_business_type !== null || $new_business_type !== null) {
              $old_type_sql = ($old_business_type === null) ? 'NULL' : secure($old_business_type, 'int');
              $new_type_sql = ($new_business_type === null) ? 'NULL' : secure($new_business_type, 'int');
              
              $db->query(sprintf("
                INSERT INTO page_business_type_history (page_id, old_type_id, new_type_id, admin_note, changed_by)
                VALUES (%s, %s, %s, %s, %s)
              ", secure($_GET['id'], 'int'), $old_type_sql, $new_type_sql, secure('Admin assigned business type'), secure($user->_data['user_id'], 'int'))) or _error('SQL_ERROR_THROWEN');
            }
            
            // Auto-enable default features for new business type
            if ($new_business_type !== null) {
              // Remove old features first
              $db->query(sprintf("DELETE FROM page_enabled_features WHERE page_id = %s", secure($_GET['id'], 'int')));
              
              // Add default features for new business type
              $get_default_features = $db->query(sprintf("
                SELECT feature_id FROM page_business_type_features 
                WHERE business_type_id = %s AND is_default = '1'
              ", secure($new_business_type, 'int')));
              
              while ($feature = $get_default_features->fetch_assoc()) {
                $db->query(sprintf("
                  INSERT INTO page_enabled_features (page_id, feature_id, enabled_by_admin) 
                  VALUES (%s, %s, '1')
                ", secure($_GET['id'], 'int'), secure($feature['feature_id'], 'int')));
              }
            } else {
              // Remove all features if business type removed
              $db->query(sprintf("DELETE FROM page_enabled_features WHERE page_id = %s", secure($_GET['id'], 'int')));
            }
          }
        }
      }
      /* update */
      $user->edit_page($_GET['id'], $_GET['edit'], $_POST);
      return_json(array('success' => true, 'message' => __("Page info have been updated")));
      break;

    case 'add_business_type':
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
      $_POST['display_order'] = !is_empty($_POST['display_order']) ? intval($_POST['display_order']) : 1;

      /* insert */
      $db->query(sprintf("
        INSERT INTO page_business_types (type_name, type_name_en, type_slug, type_icon, type_color, type_description, display_order) 
        VALUES (%s, %s, %s, %s, %s, %s, %s)
      ", secure($_POST['type_name']), secure($_POST['type_name_en']), secure($_POST['type_slug']), secure($_POST['type_icon']), secure($_POST['type_color']), secure($_POST['type_description']), secure($_POST['display_order'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['callback' => 'window.location.href="' . $system['system_url'] . '/' . $control_panel['url'] . '/pages/business_types";']);
      break;

    case 'edit_business_type':
      /* validate inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
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
      $_POST['display_order'] = !is_empty($_POST['display_order']) ? intval($_POST['display_order']) : 1;
      $_POST['is_active'] = (isset($_POST['is_active'])) ? $_POST['is_active'] : '1';

      /* update */
      $db->query(sprintf("
        UPDATE page_business_types SET 
          type_name = %s, 
          type_name_en = %s, 
          type_slug = %s, 
          type_icon = %s, 
          type_color = %s, 
          type_description = %s, 
          display_order = %s, 
          is_active = %s 
        WHERE business_type_id = %s
      ", secure($_POST['type_name']), secure($_POST['type_name_en']), secure($_POST['type_slug']), secure($_POST['type_icon']), secure($_POST['type_color']), secure($_POST['type_description']), secure($_POST['display_order'], 'int'), secure($_POST['is_active']), secure($_GET['id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['callback' => 'window.location.href="' . $system['system_url'] . '/' . $control_panel['url'] . '/pages/business_types";']);
      break;

    case 'add_category':
      /* valid inputs */
      if (is_empty($_POST['category_name'])) {
        throw new Exception(__("Please enter a valid category name"));
      }
      if (!is_empty($_POST['category_order']) && !is_numeric($_POST['category_order'])) {
        throw new Exception(__("Please enter a valid category order"));
      }
      /* insert */
      $db->query(sprintf("INSERT INTO pages_categories (category_name, category_description, category_parent_id, category_order) VALUES (%s, %s, %s, %s)", secure($_POST['category_name']),  secure($_POST['category_description']), secure($_POST['category_parent_id'], 'int'), secure($_POST['category_order'], 'int'))) or _error('SQL_ERROR_THROWEN');
      /* return */
      return_json(array('callback' => 'window.location = "' . $system['system_url'] . '/' . $control_panel['url'] . '/pages/categories";'));
      break;

    case 'edit_category':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      if (is_empty($_POST['category_name'])) {
        throw new Exception(__("Please enter a valid category name"));
      }
      if (!is_empty($_POST['category_order']) && !is_numeric($_POST['category_order'])) {
        throw new Exception(__("Please enter a valid category order"));
      }
      /* update */
      $db->query(sprintf("UPDATE pages_categories SET category_name = %s, category_description = %s, category_parent_id = %s, category_order = %s WHERE category_id = %s", secure($_POST['category_name']), secure($_POST['category_description']), secure($_POST['category_parent_id'], 'int'), secure($_POST['category_order'], 'int'), secure($_GET['id'], 'int'))) or _error('SQL_ERROR_THROWEN');
      /* return */
      return_json(array('success' => true, 'message' => __("Category info have been updated")));
      break;

    default:
      _error(400);
      break;
  }
} catch (Exception $e) {
  return_json(array('error' => true, 'message' => $e->getMessage()));
}
