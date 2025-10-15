<?php

/**
 * schools
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootloader
require('bootloader.php');

// schools enabled
if (!$system['schools_enabled']) {
  _error(404);
}

try {

  // get view content
  switch ($_GET['view']) {
    case '':
      // user access
      if ($user->_logged_in || !$system['system_public']) {
        user_access();
      }

      // page header
      page_header(__("Schools") . ' | ' . __($system['system_title']), __($system['system_description_schools']));

      // get schools categories
      $smarty->assign('categories', $user->get_categories("schools_categories"));

      // get new schools
      $schools = $user->get_schools(['suggested' => true]);
      /* assign variables */
      $smarty->assign('schools', $schools);
      $smarty->assign('get', "suggested_schools");
      break;

    case 'category':
      // user access
      if ($user->_logged_in || !$system['system_public']) {
        user_access();
      }

      // get category
      $current_category = $user->get_category("schools_categories", $_GET['category_id'], true);
      if (!$current_category) {
        _error(404);
      }
      /* assign variables */
      $smarty->assign('current_category', $current_category);

      // page header
      page_header(__("Schools") . ' &rsaquo; ' . __($current_category['category_name']) . ' | ' . __($system['system_title']), __($current_category['category_description']));

      // get schools categories (only sub-categories)
      if (!$current_category['sub_categories'] && !$current_category['parent']) {
        $categories = $user->get_categories("schools_categories");
      } else {
        $categories = $user->get_categories("schools_categories", $current_category['category_id']);
      }
      /* assign variables */
      $smarty->assign('categories', $categories);

      // get category schools
      $schools = $user->get_schools(['suggested' => true, 'category_id' => $_GET['category_id']]);
      /* assign variables */
      $smarty->assign('schools', $schools);
      $smarty->assign('get', "category_schools");

      break;

    case 'joined':
      // user access
      user_access();

      // page header
      page_header(__("Joined Schools") . ' | ' . __($system['system_title']));

      // get joined schools
      $schools = $user->get_schools(['user_id' => $user->_data['user_id']]);
      /* assign variables */
      $smarty->assign('schools', $schools);
      $smarty->assign('get', "joined_schools");
      break;

    case 'manage':
      // user access
      user_access();

      // page header
      page_header(__("My Schools") . ' | ' . __($system['system_title']));

      // get managed schools
      $schools = $user->get_schools(['managed' => true, 'user_id' => $user->_data['user_id']]);
      /* assign variables */
      $smarty->assign('schools', $schools);
      $smarty->assign('get', "schools");
      break;

    default:
      _error(404);
      break;
  }
  /* assign variables */
  $smarty->assign('view', $_GET['view']);
} catch (Exception $e) {
  _error(__("Error"), $e->getMessage());
}

// page footer
page_footer('schools');
