<?php
// Final school.php - working version
error_reporting(E_ALL);
ini_set('display_errors', 1);

// fetch bootloader
require('bootloader.php');

// user access
if (!$user->_logged_in && !$system['system_public']) {
  user_access();
}

// check username
if (is_empty($_GET['username']) || !valid_username($_GET['username'])) {
  http_response_code(404);
  echo "School not found";
  exit;
}

try {
  // [1] get main school info
  $get_school = $db->query(sprintf("SELECT `schools`.*, schools_categories.category_name as school_category_name FROM `schools` LEFT JOIN schools_categories ON `schools`.school_category = schools_categories.category_id WHERE `schools`.school_name = %s", secure($_GET['username'])));
  
  if (!$get_school || $get_school->num_rows == 0) {
    http_response_code(404);
    echo "School not found";
    exit;
  }
  
  $school = $get_school->fetch_assoc();
  
  /* check username case */
  if (strtolower($_GET['username']) == strtolower($school['school_name']) && $_GET['username'] != $school['school_name']) {
    redirect('/schools/' . $school['school_name']);
  }
  
  /* get school picture */
  $school['school_picture_default'] = ($school['school_picture']) ? false : true;
  $school['school_picture'] = get_picture($school['school_picture'], 'school');
  $school['school_picture_full'] = '';
  
  /* get school cover */
  $school['school_cover'] = ($school['school_cover']) ? $system['system_uploads'] . '/' . $school['school_cover'] : $school['school_cover'];
  $school['school_cover_full'] = '';
  
  /* check school category */
  $school['school_category_name'] = (!$school['school_category_name']) ? __('N/A') : $school['school_category_name'];
  
  /* get the connection */
  if ($user->_logged_in) {
    $school['i_admin'] = $user->check_school_adminship($user->_data['user_id'], $school['school_id']);
    $school['i_joined'] = $user->check_school_membership($user->_data['user_id'], $school['school_id']);
  } else {
    $school['i_admin'] = false;
    $school['i_joined'] = false;
  }
  
  /* get chatbox converstaion */
  if ($school['school_chatbox_enabled'] && $school['i_joined'] == "approved") {
    $school['chatbox_conversation'] = $user->get_chatbox($school['school_chatbox_conversation_id']);
  }
  
  /* get school posts count */
  $school['posts_count'] = $user->get_posts_count($school['school_id'], 'school');
  
  /* get school photos count */
  $school['photos_count'] = $user->get_photos_count($school['school_id'], 'school');
  
  /* get school videos count */
  if ($system['videos_enabled']) {
    $school['videos_count'] = $user->get_videos_count($school['school_id'], 'school');
  }
  
  /* check if school's admin can monetize content */
  $school['can_monetize_content'] = $system['monetization_enabled'] && $user->check_user_permission($school['school_admin'], 'monetization_permission');
  
  /* check if school has monetization enabled && subscriptions plans */
  $school['has_subscriptions_plans'] = $school['can_monetize_content'] && $school['school_monetization_enabled'] && $school['school_monetization_plans'] > 0;
  
  /* check if the school needs subscription (exclude: admins & mods & school's admin) */
  $school['needs_subscription'] = false;
  if ($school['has_subscriptions_plans']) {
    if ($user->_logged_in) {
      if ($user->_data['user_group'] == 3 && !$school['i_admin']) {
        if (!$user->is_subscribed($school['school_id'], 'school')) {
          $school['needs_subscription'] = true;
        }
      }
    } else {
      $school['needs_subscription'] = true;
    }
  }

  // [2] get view content
  /* check school privacy */
  if ($school['school_privacy'] == "secret") {
    if ($school['i_joined'] !== "approved" && !$school['i_admin']) {
      if (!$user->_is_admin && !$user->_is_moderator) {
        http_response_code(404);
        echo "School not found";
        exit;
      }
    }
  }
  if ($school['school_privacy'] == "closed") {
    if ($school['i_joined'] !== "approved" && !$school['i_admin']) {
      if (!$user->_is_admin && !$user->_is_moderator) {
        $_GET['view'] = 'members';
      }
    }
  }
  
  switch ($_GET['view']) {
    case '':
      /* get custom fields */
      $smarty->assign('custom_fields', $user->get_custom_fields(array("for" => "school", "get" => "profile", "node_id" => $school['school_id'])));

      /* get subscribers */
      if ($school['has_subscriptions_plans']) {
        /* get subscribers count */
        $school['subscribers_count'] = $user->get_subscribers_count($school['school_id'], 'school');
        /* get subscribers */
        $school['subscribers'] = $user->get_subscribers($school['school_id'], 'school');
        /* assign variables */
        $smarty->assign('subscribers', $school['subscribers']);
      }

      /* get pinned post */
      if ($school['school_pinned_post']) {
        $pinned_post = $user->get_post($school['school_pinned_post']);
        if ($pinned_post) {
          $smarty->assign('pinned_post', $pinned_post);
        }
      }

      /* get posts */
      $school['posts'] = $user->get_posts(array('get' => 'posts_school', 'id' => $school['school_id'], 'needs_subscription' => $school['needs_subscription']));
      /* assign variables */
      $smarty->assign('posts', $school['posts']);

      // page header
      page_header($school['school_title'] . ' | ' . __($system['system_title']), $school['school_description']);
      break;

    case 'members':
      /* get school members */
      $school['members'] = $user->get_school_members($school['school_id']);
      /* assign variables */
      $smarty->assign('members', $school['members']);

      // page header
      page_header(__("Members") . ' | ' . $school['school_title'] . ' | ' . __($system['system_title']));
      break;

    case 'photos':
      if (!$system['photos_enabled']) {
        http_response_code(404);
        echo "Page not found";
        exit;
      }
      /* get school photos */
      $school['photos'] = $user->get_photos(array('get' => 'photos_school', 'id' => $school['school_id']));
      /* assign variables */
      $smarty->assign('photos', $school['photos']);

      // page header
      page_header(__("Photos") . ' | ' . $school['school_title'] . ' | ' . __($system['system_title']));
      break;

    case 'videos':
      if (!$system['videos_enabled']) {
        http_response_code(404);
        echo "Page not found";
        exit;
      }
      /* get school videos */
      $school['videos'] = $user->get_videos(array('get' => 'videos_school', 'id' => $school['school_id']));
      /* assign variables */
      $smarty->assign('videos', $school['videos']);

      // page header
      page_header(__("Videos") . ' | ' . $school['school_title'] . ' | ' . __($system['system_title']));
      break;

    case 'settings':
      /* user access */
      user_access();
      if (!$school['i_admin']) {
        http_response_code(404);
        echo "Page not found";
        exit;
      }

      // page header
      page_header(__("Settings") . ' | ' . $school['school_title'] . ' | ' . __($system['system_title']));
      break;

    default:
      http_response_code(404);
      echo "Page not found";
      exit;
  }

  // assign variables
  $smarty->assign('school', $school);
  $smarty->assign('view', $_GET['view']);

  // page footer
  page_footer('school');

} catch (Exception $e) {
  http_response_code(500);
  echo "Error: " . $e->getMessage();
} catch (Error $e) {
  http_response_code(500);
  echo "Fatal Error: " . $e->getMessage();
}
?>
