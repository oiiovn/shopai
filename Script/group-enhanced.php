<?php

/**
 * group-enhanced
 * 
 * @package Sngine
 * @author Shop-AI Team
 */

// fetch bootloader
require('bootloader.php');

// groups enabled
if (!$system['groups_enabled']) {
  _error(404);
}

// user access
user_access();

// include group enhancement class
require_once('includes/class-group-enhancement.php');
$group_enhancement = new GroupEnhancement($db, $user, $system);

try {

  // get view content
  switch ($_GET['view']) {
    
    case 'analytics':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['id'], 'int');
      
      // Check if user has permission to view analytics
      if (!$user->check_group_adminship($user->_data['user_id'], $group_id)) {
        _error(403);
      }
      
      // Get group info
      $get_group = $db->query(sprintf("SELECT * FROM `groups` WHERE `group_id` = %s", secure($group_id, 'int'))) or _error('SQL_ERROR_THROWEN');
      if ($get_group->num_rows == 0) {
        _error(404);
      }
      $group = $get_group->fetch_assoc();
      
      // Get analytics data
      $period = secure($_GET['period']) ?: 'daily';
      $limit = secure($_GET['limit'], 'int') ?: 30;
      $analytics = $group_enhancement->get_group_analytics($group_id, $period, $limit);
      
      // Assign variables
      $smarty->assign('group', $group);
      $smarty->assign('analytics', $analytics);
      $smarty->assign('period', $period);
      
      // page header
      page_header(__("Analytics") . ' &rsaquo; ' . __($group['group_title']), __("Group analytics and insights"));
      break;

    case 'events':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['id'], 'int');
      
      // Get group info
      $get_group = $db->query(sprintf("SELECT * FROM `groups` WHERE `group_id` = %s", secure($group_id, 'int'))) or _error('SQL_ERROR_THROWEN');
      if ($get_group->num_rows == 0) {
        _error(404);
      }
      $group = $get_group->fetch_assoc();
      
      // Check if user is member
      if (!$user->check_group_membership($user->_data['user_id'], $group_id)) {
        _error(403);
      }
      
      // Get events
      $status = secure($_GET['status']) ?: 'published';
      $events = $group_enhancement->get_group_events($group_id, $status);
      
      // Assign variables
      $smarty->assign('group', $group);
      $smarty->assign('events', $events);
      $smarty->assign('status', $status);
      
      // page header
      page_header(__("Events") . ' &rsaquo; ' . __($group['group_title']), __("Group events and activities"));
      break;

    case 'polls':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['id'], 'int');
      
      // Get group info
      $get_group = $db->query(sprintf("SELECT * FROM `groups` WHERE `group_id` = %s", secure($group_id, 'int'))) or _error('SQL_ERROR_THROWEN');
      if ($get_group->num_rows == 0) {
        _error(404);
      }
      $group = $get_group->fetch_assoc();
      
      // Check if user is member
      if (!$user->check_group_membership($user->_data['user_id'], $group_id)) {
        _error(403);
      }
      
      // Get polls
      $status = secure($_GET['status']) ?: 'active';
      $polls = $group_enhancement->get_group_polls($group_id, $status);
      
      // Assign variables
      $smarty->assign('group', $group);
      $smarty->assign('polls', $polls);
      $smarty->assign('status', $status);
      
      // page header
      page header(__("Polls") . ' &rsaquo; ' . __($group['group_title']), __("Group polls and surveys"));
      break;

    case 'announcements':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['id'], 'int');
      
      // Get group info
      $get_group = $db->query(sprintf("SELECT * FROM `groups` WHERE `group_id` = %s", secure($group_id, 'int'))) or _error('SQL_ERROR_THROWEN');
      if ($get_group->num_rows == 0) {
        _error(404);
      }
      $group = $get_group->fetch_assoc();
      
      // Check if user is member
      if (!$user->check_group_membership($user->_data['user_id'], $group_id)) {
        _error(403);
      }
      
      // Get announcements
      $status = secure($_GET['status']) ?: 'published';
      $announcements = $group_enhancement->get_group_announcements($group_id, $status);
      
      // Assign variables
      $smarty->assign('group', $group);
      $smarty->assign('announcements', $announcements);
      $smarty->assign('status', $status);
      
      // page header
      page_header(__("Announcements") . ' &rsaquo; ' . __($group['group_title']), __("Group announcements and updates"));
      break;

    case 'shopai-integration':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $group_id = secure($_GET['id'], 'int');
      
      // Get group info
      $get_group = $db->query(sprintf("SELECT * FROM `groups` WHERE `group_id` = %s", secure($group_id, 'int'))) or _error('SQL_ERROR_THROWEN');
      if ($get_group->num_rows == 0) {
        _error(404);
      }
      $group = $get_group->fetch_assoc();
      
      // Check if user is group admin
      if (!$user->check_group_adminship($user->_data['user_id'], $group_id)) {
        _error(403);
      }
      
      // Get Shop-AI integration settings
      $integration = $group_enhancement->get_shopai_integration($group_id);
      
      // Assign variables
      $smarty->assign('group', $group);
      $smarty->assign('integration', $integration);
      
      // page header
      page_header(__("Shop-AI Integration") . ' &rsaquo; ' . __($group['group_title']), __("Integrate your group with Shop-AI"));
      break;

    case 'templates':
      // Get group templates
      $category = secure($_GET['category']);
      $templates = $group_enhancement->get_group_templates($category);
      
      // Assign variables
      $smarty->assign('templates', $templates);
      $smarty->assign('category', $category);
      
      // page header
      page_header(__("Group Templates"), __("Choose a template for your group"));
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
page_footer('group-enhanced');
