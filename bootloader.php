<?php

/**
 * bootloader
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootstrap
require('bootstrap.php');

try {
  // user logged in
  if ($user->_logged_in) {
    // get user data
    /* get friend requests */
    $user->_data['friend_requests'] = $user->get_friend_requests();
    /* get search log */
    $user->_data['search_log'] = $user->get_search_log();
    /* get conversations */
    $user->_data['conversations'] = $user->get_conversations();
    /* get notifications */
    $user->_data['notifications'] = $user->get_notifications();
    /* get online & offline friends */
    $detect = new Mobile_Detect;
    if ($system['chat_enabled'] && $user->_data['user_chat_enabled'] && !($detect->isMobile() && !$detect->isTablet())) {
      /* get online friends */
      $online_friends = $user->get_online_friends();
      /* get offline friends */
      $offline_friends = $user->get_offline_friends();
      /* get sidebar friends */
      $sidebar_friends = array_merge($online_friends, $offline_friends);
      /* assign variables */
      $smarty->assign('sidebar_friends', $sidebar_friends);
      $smarty->assign('online_friends_count', count($online_friends));
    }
    /* check if user subscribed */
    if ($system['packages_enabled']) {
      $user->check_user_package();
    }

    /* check if phone number is required */
    $require_phone_number = false;
    if (empty($user->_data['user_phone'])) {
      // Kiểm tra user có cả avatar và cover không (không phải default)
      $hasAvatar = !empty($user->_data['user_picture']) && (isset($user->_data['user_picture_default']) && !$user->_data['user_picture_default']);
      $hasCover = !empty($user->_data['user_cover']);
      
      if ($hasAvatar && $hasCover && !empty($user->_data['user_picture_id']) && !empty($user->_data['user_cover_id'])) {
        // Lấy thời gian upload avatar và cover từ bảng posts
        $check_time_query = $db->query(sprintf(
          "SELECT 
            (SELECT p.time FROM posts p 
             INNER JOIN posts_photos pp ON p.post_id = pp.post_id 
             WHERE pp.photo_id = %s AND p.post_type = 'profile_picture' 
             ORDER BY p.time DESC LIMIT 1) as avatar_time,
            (SELECT p.time FROM posts p 
             INNER JOIN posts_photos pp ON p.post_id = pp.post_id 
             WHERE pp.photo_id = %s AND p.post_type = 'profile_cover' 
             ORDER BY p.time DESC LIMIT 1) as cover_time",
          secure($user->_data['user_picture_id'], 'int'),
          secure($user->_data['user_cover_id'], 'int')
        ));
        
        if ($check_time_query && $check_time_query->num_rows > 0) {
          $time_data = $check_time_query->fetch_assoc();
          
          if (!empty($time_data['avatar_time']) && !empty($time_data['cover_time'])) {
            // Tính thời gian từ lần upload gần nhất
            $avatar_time = strtotime($time_data['avatar_time']);
            $cover_time = strtotime($time_data['cover_time']);
            
            // Lấy thời gian upload muộn nhất (avatar hoặc cover)
            $latest_upload = max($avatar_time, $cover_time);
            $hours_since_upload = (time() - $latest_upload) / 3600;
            
            // Nếu đã upload > 24h thì yêu cầu nhập SĐT
            if ($hours_since_upload >= 24) {
              $require_phone_number = true;
            }
          }
        }
      }
    }
    $smarty->assign('require_phone_number', $require_phone_number);

    // get countries
    if ($system['2checkout_enabled'] || $system['newsfeed_location_filter_enabled']) {
      $countries = $user->get_countries();
      /* assign variables */
      $smarty->assign('countries', $countries);
    }
  }


  // init affiliates system
  $user->init_affiliates();


  // get static pages
  $smarty->assign('static_pages', $user->get_static_pages());


  // get ads (header & footer)
  $ads_master['header'] = $user->ads('header');
  $ads_master['footer'] = $user->ads('footer');
  /* assign variables */
  $smarty->assign('ads_master', $ads_master);
} catch (Exception $e) {
  _error(__("Error"), $e->getMessage());
}
