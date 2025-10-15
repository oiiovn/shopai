<?php

/**
 * ajax -> pages -> menu
 * Xử lý AJAX cho quản lý thực đơn pages
 * 
 * @package Sngine
 * @author Custom Development
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// user access
user_access(true);

// valid inputs
if (!isset($_GET['do'])) {
  _error(400);
}

// check demo account
if ($user->_data['user_demo']) {
  modal("ERROR", __("Demo Restriction"), __("You can't do this with demo account"));
}

/**
 * Handle menu image upload
 */
function handle_menu_image_upload($file) {
  global $system;
  
  // Validate file
  if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
    return ['success' => false, 'message' => 'No file uploaded'];
  }
  
  // Validate file type
  $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
  if (!in_array($file['type'], $allowed_types)) {
    return ['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF, WebP allowed'];
  }
  
  // Validate file size (5MB)
  if ($file['size'] > 5 * 1024 * 1024) {
    return ['success' => false, 'message' => 'File too large. Maximum size is 5MB'];
  }
  
  // Create directory
  $upload_dir = 'content/uploads/photos/' . date('Y') . '/' . date('m') . '/';
  if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
  }
  
  // Generate unique filename
  $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
  $filename = 'menu_' . uniqid() . '_' . time() . '.' . $extension;
  $file_path = $upload_dir . $filename;
  
  // Move uploaded file
  if (move_uploaded_file($file['tmp_name'], $file_path)) {
    $file_url = $system['system_url'] . '/' . $file_path;
    return ['success' => true, 'file_url' => $file_url];
  } else {
    return ['success' => false, 'message' => 'Failed to upload file'];
  }
}

try {

  switch ($_GET['do']) {
    case 'add_category':
      /* validate inputs */
      if (!isset($_GET['page_id']) || !is_numeric($_GET['page_id'])) {
        _error(400);
      }
      if (is_empty($_POST['category_name'])) {
        throw new Exception(__("Category name is required"));
      }

      /* check page permission */
      if (!$user->check_page_adminship($user->_data['user_id'], $_GET['page_id'])) {
        throw new Exception(__("You don't have permission to manage this page"));
      }

      /* check if page has menu feature */
      $check_feature = $db->query(sprintf("
        SELECT 1 FROM page_enabled_features pef 
        INNER JOIN page_features pf ON pef.feature_id = pf.feature_id 
        WHERE pef.page_id = %s AND pf.feature_slug = 'menu-truc-tuyen' AND pef.is_active = '1'
      ", secure($_GET['page_id'], 'int')));
      
      if (!$check_feature || $check_feature->num_rows == 0) {
        throw new Exception(__("This page doesn't have menu feature enabled"));
      }

      /* prepare */
      $_POST['category_icon'] = !is_empty($_POST['category_icon']) ? $_POST['category_icon'] : 'fa-utensils';
      $_POST['display_order'] = !is_empty($_POST['display_order']) ? intval($_POST['display_order']) : 1;

      /* insert */
      $db->query(sprintf("
        INSERT INTO page_menu_categories (page_id, category_name, category_icon, display_order) 
        VALUES (%s, %s, %s, %s)
      ", secure($_GET['page_id'], 'int'), secure($_POST['category_name']), secure($_POST['category_icon']), secure($_POST['display_order'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['success' => true, 'message' => 'Đã thêm danh mục "' . $_POST['category_name'] . '" thành công!', 'callback' => 'window.location.reload();']);
      break;

    case 'add_item':
      /* validate inputs */
      if (!isset($_GET['page_id']) || !is_numeric($_GET['page_id'])) {
        _error(400);
      }
      if (is_empty($_POST['item_name']) || is_empty($_POST['item_price']) || is_empty($_POST['category_id'])) {
        throw new Exception(__("Please fill all required fields"));
      }

      /* check page permission */
      if (!$user->check_page_adminship($user->_data['user_id'], $_GET['page_id'])) {
        throw new Exception(__("You don't have permission to manage this page"));
      }

      /* check if category belongs to this page */
      $check_category = $db->query(sprintf("
        SELECT category_id FROM page_menu_categories 
        WHERE category_id = %s AND page_id = %s
      ", secure($_POST['category_id'], 'int'), secure($_GET['page_id'], 'int')));
      
      if (!$check_category || $check_category->num_rows == 0) {
        throw new Exception(__("Invalid category"));
      }

      /* validate price */
      if (!is_numeric($_POST['item_price']) || floatval($_POST['item_price']) < 0) {
        throw new Exception(__("Please enter a valid price"));
      }

      /* prepare */
      $_POST['is_popular'] = (isset($_POST['is_popular'])) ? '1' : '0';
      $_POST['is_available'] = (isset($_POST['is_available'])) ? '1' : '0';
      $_POST['display_order'] = !is_empty($_POST['display_order']) ? intval($_POST['display_order']) : 1;
      
      /* handle image - prioritize uploaded file over URL */
      $item_image = '';
      if (!empty($_FILES['item_image_file']['name'])) {
        // Handle file upload
        $upload = handle_menu_image_upload($_FILES['item_image_file']);
        if ($upload['success']) {
          $item_image = $upload['file_url'];
        } else {
          throw new Exception($upload['message']);
        }
      } elseif (!is_empty($_POST['item_image_url'])) {
        // URL image
        $item_image = $_POST['item_image_url'];
      }

      /* insert */
      $db->query(sprintf("
        INSERT INTO page_menu_items (page_id, category_id, item_name, item_description, item_price, item_image, is_popular, is_available, display_order) 
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
      ", secure($_GET['page_id'], 'int'), secure($_POST['category_id'], 'int'), secure($_POST['item_name']), secure($_POST['item_description']), secure($_POST['item_price']), secure($item_image), secure($_POST['is_popular']), secure($_POST['is_available']), secure($_POST['display_order'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['success' => true, 'message' => 'Đã thêm món "' . $_POST['item_name'] . '" thành công!', 'callback' => 'window.location.reload();']);
      break;

    case 'edit_item':
      // Debug log removed for performance
      /* validate inputs */
      if (!isset($_GET['item_id']) || !is_numeric($_GET['item_id'])) {
        _error(400);
      }
      if (is_empty($_POST['item_name']) || is_empty($_POST['item_price'])) {
        throw new Exception(__("Please fill all required fields"));
      }

      /* get item info to check page ownership */
      $get_item = $db->query(sprintf("SELECT page_id, item_image FROM page_menu_items WHERE item_id = %s", secure($_GET['item_id'], 'int')));
      if (!$get_item || $get_item->num_rows == 0) {
        throw new Exception(__("Item not found"));
      }
      $item_data = $get_item->fetch_assoc();

      /* check page permission */
      if (!$user->check_page_adminship($user->_data['user_id'], $item_data['page_id'])) {
        throw new Exception(__("You don't have permission to manage this page"));
      }

      /* validate price */
      if (!is_numeric($_POST['item_price']) || floatval($_POST['item_price']) < 0) {
        throw new Exception(__("Please enter a valid price"));
      }

      /* prepare */
      $_POST['is_popular'] = (isset($_POST['is_popular'])) ? '1' : '0';
      $_POST['is_available'] = (isset($_POST['is_available'])) ? '1' : '0';
      
      /* handle image - prioritize uploaded file over URL */
      $item_image = '';
      if (!empty($_FILES['item_image_file']['name'])) {
        // Handle file upload
        $upload = handle_menu_image_upload($_FILES['item_image_file']);
        if ($upload['success']) {
          $item_image = $upload['file_url'];
        } else {
          throw new Exception($upload['message']);
        }
      } elseif (!is_empty($_POST['item_image_url'])) {
        // URL image
        $item_image = $_POST['item_image_url'];
      } else {
        // Keep existing image if no new image provided
        $item_image = $item_data['item_image'];
      }

      /* update */
      $db->query(sprintf("
        UPDATE page_menu_items SET 
          item_name = %s, 
          item_description = %s, 
          item_price = %s, 
          item_image = %s, 
          is_popular = %s, 
          is_available = %s
        WHERE item_id = %s
      ", secure($_POST['item_name']), secure($_POST['item_description']), secure($_POST['item_price']), secure($item_image), secure($_POST['is_popular']), secure($_POST['is_available']), secure($_GET['item_id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['success' => true, 'message' => 'Đã cập nhật món "' . $_POST['item_name'] . '" thành công!', 'callback' => 'window.location.reload();']);
      break;

    case 'delete_item':
      /* validate inputs */
      if (!isset($_GET['item_id']) || !is_numeric($_GET['item_id'])) {
        _error(400);
      }

      /* get item info to check page ownership */
      $get_item = $db->query(sprintf("SELECT page_id, item_image FROM page_menu_items WHERE item_id = %s", secure($_GET['item_id'], 'int')));
      if (!$get_item || $get_item->num_rows == 0) {
        throw new Exception(__("Item not found"));
      }
      $item_data = $get_item->fetch_assoc();

      /* check page permission */
      if (!$user->check_page_adminship($user->_data['user_id'], $item_data['page_id'])) {
        throw new Exception(__("You don't have permission to manage this page"));
      }

      /* get item name for message */
      $item_name = $item_data['item_name'];

      /* delete */
      $db->query(sprintf("DELETE FROM page_menu_items WHERE item_id = %s", secure($_GET['item_id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['success' => true, 'message' => 'Đã xóa món "' . $item_name . '" thành công!', 'callback' => 'window.location.reload();']);
      break;

    case 'toggle_availability':
      /* validate inputs */
      if (!isset($_GET['item_id']) || !is_numeric($_GET['item_id'])) {
        _error(400);
      }

      /* get item info */
      $get_item = $db->query(sprintf("SELECT page_id, is_available FROM page_menu_items WHERE item_id = %s", secure($_GET['item_id'], 'int')));
      if (!$get_item || $get_item->num_rows == 0) {
        throw new Exception(__("Item not found"));
      }
      $item_data = $get_item->fetch_assoc();

      /* check page permission */
      if (!$user->check_page_adminship($user->_data['user_id'], $item_data['page_id'])) {
        throw new Exception(__("You don't have permission to manage this page"));
      }

      /* toggle availability */
      $new_status = ($item_data['is_available'] == '1') ? '0' : '1';
      $db->query(sprintf("UPDATE page_menu_items SET is_available = %s WHERE item_id = %s", secure($new_status), secure($_GET['item_id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['success' => true, 'new_status' => $new_status]);
      break;

    case 'edit_category':
      /* validate inputs */
      if (!isset($_GET['category_id']) || !is_numeric($_GET['category_id'])) {
        _error(400);
      }
      if (is_empty($_POST['category_name'])) {
        throw new Exception(__("Category name is required"));
      }

      /* get category info */
      $get_category = $db->query(sprintf("SELECT page_id FROM page_menu_categories WHERE category_id = %s", secure($_GET['category_id'], 'int')));
      if (!$get_category || $get_category->num_rows == 0) {
        throw new Exception(__("Category not found"));
      }
      $category_data = $get_category->fetch_assoc();

      /* check page permission */
      if (!$user->check_page_adminship($user->_data['user_id'], $category_data['page_id'])) {
        throw new Exception(__("You don't have permission to manage this page"));
      }

      /* prepare */
      $_POST['category_icon'] = !is_empty($_POST['category_icon']) ? $_POST['category_icon'] : 'fa-utensils';
      $_POST['display_order'] = !is_empty($_POST['display_order']) ? intval($_POST['display_order']) : 1;

      /* update */
      $db->query(sprintf("
        UPDATE page_menu_categories SET 
          category_name = %s, 
          category_icon = %s, 
          display_order = %s 
        WHERE category_id = %s
      ", secure($_POST['category_name']), secure($_POST['category_icon']), secure($_POST['display_order'], 'int'), secure($_GET['category_id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['callback' => 'window.location.reload();']);
      break;

    case 'delete_category':
      /* validate inputs */
      if (!isset($_GET['category_id']) || !is_numeric($_GET['category_id'])) {
        _error(400);
      }

      /* get category info */
      $get_category = $db->query(sprintf("SELECT page_id FROM page_menu_categories WHERE category_id = %s", secure($_GET['category_id'], 'int')));
      if (!$get_category || $get_category->num_rows == 0) {
        throw new Exception(__("Category not found"));
      }
      $category_data = $get_category->fetch_assoc();

      /* check page permission */
      if (!$user->check_page_adminship($user->_data['user_id'], $category_data['page_id'])) {
        throw new Exception(__("You don't have permission to manage this page"));
      }

      /* check if category has items */
      $check_items = $db->query(sprintf("SELECT COUNT(*) as count FROM page_menu_items WHERE category_id = %s", secure($_GET['category_id'], 'int')));
      $items_count = $check_items->fetch_assoc()['count'];
      
      if ($items_count > 0) {
        throw new Exception(__("Cannot delete category that has menu items"));
      }

      /* delete */
      $db->query(sprintf("DELETE FROM page_menu_categories WHERE category_id = %s", secure($_GET['category_id'], 'int'))) or _error('SQL_ERROR_THROWEN');

      /* return */
      return_json(['callback' => 'window.location.reload();']);
      break;

    case 'duplicate_item':
      /* validate inputs */
      if (!isset($_GET['item_id']) || !is_numeric($_GET['item_id'])) {
        _error(400);
      }

      /* get original item */
      $get_item = $db->query(sprintf("SELECT * FROM page_menu_items WHERE item_id = %s", secure($_GET['item_id'], 'int')));
      if (!$get_item || $get_item->num_rows == 0) {
        throw new Exception(__("Item not found"));
      }
      $original_item = $get_item->fetch_assoc();

      /* check page permission */
      if (!$user->check_page_adminship($user->_data['user_id'], $original_item['page_id'])) {
        throw new Exception(__("You don't have permission to manage this page"));
      }

      /* duplicate item with new name */
      $new_name = $original_item['item_name'] . ' (Copy)';
      
      $db->query(sprintf("
        INSERT INTO page_menu_items (page_id, category_id, item_name, item_description, item_price, item_image, is_popular, is_available, display_order) 
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
      ", secure($original_item['page_id'], 'int'), secure($original_item['category_id'], 'int'), secure($new_name), secure($original_item['item_description']), secure($original_item['item_price']), secure($original_item['item_image']), secure($original_item['is_popular']), secure($original_item['is_available']), secure($original_item['display_order'] + 1, 'int'))) or _error('SQL_ERROR_THROWEN');

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
