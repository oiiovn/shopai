<?php

/**
 * index
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootloader
require('bootloader.php');

try {

  // check user logged in
  if (!$user->_logged_in) {

    // page header
    page_header(__("Welcome to") . ' ' . __($system['system_title']));

    if (!$system['newsfeed_public']) {

      // get genders
      $smarty->assign('genders', $user->get_genders());

      // get countries if not defined
      if (!$countries) {
        $smarty->assign('countries', $user->get_countries());
      }

      // get custom fields
      $smarty->assign('custom_fields', $user->get_custom_fields());
    } else {

      // newsfeed location filter
      if ($system['newsfeed_location_filter_enabled']) {
        // get countries if not defined
        if (!$countries) {
          $smarty->assign('countries', $user->get_countries());
        }

        // get selected country
        if (isset($_GET['country'])) {
          $selected_country = $user->get_country_by_name($_GET['country']);
          /* assign variables */
          $smarty->assign('selected_country', $selected_country);
        }
      }

      // get boosted post
      if ($system['packages_enabled']) {
        $boosted_post = $user->get_boosted_post();
        $smarty->assign('boosted_post', $boosted_post);
      }

      // get posts (newsfeed)
      $posts = ($selected_country) ? $user->get_posts(['country' => $selected_country['country_id']]) : $user->get_posts();
      /* assign variables */
      $smarty->assign('posts', $posts);

      // get ads campaigns
      $ads_campaigns = $user->ads_campaigns();
      /* assign variables */
      $smarty->assign('ads_campaigns', $ads_campaigns);
    }
  } else {

    // user access
    user_access();

    // get announcements
    $announcements = $user->announcements();
    /* assign variables */
    $smarty->assign('announcements', $announcements);

    // get view content
    switch ($_GET['view']) {
      case '':
        // page header
        page_header(__($system['system_title']));

        // get stories
        if ($system['stories_enabled']) {
          $smarty->assign('stories', $user->get_stories());
          $smarty->assign('has_story', $user->get_my_story());
        }

        // prepare publisher
        $smarty->assign('feelings', get_feelings());
        $smarty->assign('feelings_types', get_feelings_types());
        if ($system['colored_posts_enabled']) {
          $smarty->assign('colored_patterns', $user->get_posts_colored_patterns());
        }
        if ($user->_data['can_upload_videos']) {
          $smarty->assign('videos_categories', $user->get_categories("posts_videos_categories"));
        }

        // check daytime messages
        $daytime_msg_enabled = (isset($_COOKIE['dt_msg'])) ? false : $system['daytime_msg_enabled'];
        $smarty->assign('daytime_msg_enabled', $daytime_msg_enabled);

        // get boosted post
        if ($system['packages_enabled']) {
          $boosted_post = $user->get_boosted_post();
          $smarty->assign('boosted_post', $boosted_post);
        }

        // newsfeed location filter
        if ($system['newsfeed_location_filter_enabled']) {
          // get selected country
          if (isset($_GET['country'])) {
            $selected_country = $user->get_country_by_name($_GET['country']);
            /* assign variables */
            $smarty->assign('selected_country', $selected_country);
          }
        }

        // get posts (newsfeed)
        $posts = ($selected_country) ? $user->get_posts(['country' => $selected_country['country_id']]) : $user->get_posts();
        /* assign variables */
        $smarty->assign('posts', $posts);

        // get available review tasks (hiển thị 1 nhiệm vụ con từ mỗi chiến dịch mẹ khác nhau)
        // Loại bỏ các chiến dịch mà user đã tạo và đã nhận
        $available_tasks = array();
        $get_available_tasks = $db->query("
            SELECT gmsr.*, gmr.place_name, gmr.place_address, gmr.place_url, gmr.expires_at as parent_expires_at,
                   u.user_firstname, u.user_lastname, u.user_picture, u.user_verified
            FROM google_maps_review_sub_requests gmsr
            LEFT JOIN google_maps_review_requests gmr ON gmsr.parent_request_id = gmr.request_id
            LEFT JOIN users u ON gmr.requester_user_id = u.user_id
            WHERE gmsr.status = 'available' 
            AND gmsr.expires_at > CONVERT_TZ(NOW(), '+00:00', '+07:00')
            AND gmr.status = 'active'
            AND gmr.requester_user_id != '{$user->_data['user_id']}'
            AND gmr.request_id NOT IN (
                SELECT DISTINCT parent_request_id 
                FROM google_maps_review_sub_requests 
                WHERE assigned_user_id = '{$user->_data['user_id']}' 
                AND status IN ('assigned', 'completed')
            )
            GROUP BY gmr.request_id
            ORDER BY gmsr.created_at DESC
            LIMIT 3
        ");
        
        error_log("Available tasks query result: " . $get_available_tasks->num_rows . " rows");
        
        if ($get_available_tasks->num_rows > 0) {
            while ($task = $get_available_tasks->fetch_assoc()) {
                $available_tasks[] = $task;
                error_log("Task found: " . $task['place_name']);
            }
        }
        /* assign variables */
        $smarty->assign('available_tasks', $available_tasks);
        break;

      case 'popular':
        // check if popular posts enabled
        if (!$system['popular_posts_enabled']) {
          _error(404);
        }

        // page header
        page_header(__("Popular Posts"));

        // get posts (popular)
        $posts = $user->get_posts(array('get' => 'popular'));
        /* assign variables */
        $smarty->assign('posts', $posts);
        break;

      case 'discover':
        // check if discover posts enabled
        if (!$system['discover_posts_enabled']) {
          _error(404);
        }

        // page header
        page_header(__("Discover Posts"));

        // get posts (discover)
        $posts = $user->get_posts(array('get' => 'discover'));
        /* assign variables */
        $smarty->assign('posts', $posts);
        break;

      case 'articles':
        // check if blogs enabled
        if (!$system['blogs_enabled']) {
          _error(404);
        }

        // check blogs permission
        if (!$user->_data['can_write_articles']) {
          _error(404);
        }

        // page header
        page_header(__("My Articles"));

        // get posts (articles)
        $posts = $user->get_posts(array('get' => 'posts_profile', 'id' => $user->_data['user_id'], 'filter' => 'article'));
        /* assign variables */
        $smarty->assign('posts', $posts);
        break;

      case 'products':
        // check if market enabled
        if (!$system['market_enabled']) {
          _error(404);
        }

        // check market permission
        if (!$user->_data['can_sell_products']) {
          _error(404);
        }

        // page header
        page_header(__("My Products"));

        // get posts (products)
        $posts = $user->get_posts(array('get' => 'posts_profile', 'id' => $user->_data['user_id'], 'filter' => 'product'));
        /* assign variables */
        $smarty->assign('posts', $posts);
        break;

      case 'funding_requests':
        // check if funding enabled
        if (!$system['funding_enabled']) {
          _error(404);
        }

        // check funding permission
        if (!$user->_data['can_raise_funding']) {
          _error(404);
        }

        // page header
        page_header(__("My Funding Requests"));

        // get posts (funding)
        $posts = $user->get_posts(array('get' => 'posts_profile', 'id' => $user->_data['user_id'], 'filter' => 'funding'));
        /* assign variables */
        $smarty->assign('posts', $posts);
        break;

      case 'saved':
        // page header
        page_header(__("Saved Posts"));

        // get posts (saved)
        $posts = $user->get_posts(array('get' => 'saved'));
        /* assign variables */
        $smarty->assign('posts', $posts);
        break;

      case 'memories':
        // page header
        page_header(__("Memories"));

        // get posts (memories)
        $posts = $user->get_posts(array('get' => 'memories'));
        /* assign variables */
        $smarty->assign('posts', $posts);
        break;

      case 'boosted_posts':
        // check if packages enabled
        if (!$system['packages_enabled']) {
          error(404);
        }

        // page header
        page_header(__("Boosted Posts"));

        // get posts (boosted)
        $posts = $user->get_posts(array('get' => 'boosted'));
        /* assign variables */
        $smarty->assign('posts', $posts);
        break;

      case 'boosted_pages':
        // check if packages enabled
        if (!$system['packages_enabled']) {
          error(404);
        }

        // check if pages enabled
        if (!$system['pages_enabled']) {
          error(404);
        }

        // page header
        page_header(__("Boosted Pages"));

        // get pages (boosted)
        $boosted_pages = $user->get_pages(array('boosted' => true));
        /* assign variables */
        $smarty->assign('boosted_pages', $boosted_pages);
        break;

      case 'watch':
        // check if watch enabled
        if (!$system['watch_enabled']) {
          _error(404);
        }

        // page header
        page_header(__("Watch") . ' | ' . __($system['system_title']));

        // newsfeed location filter
        if ($system['newsfeed_location_filter_enabled']) {
          // get selected country
          if (isset($_GET['country'])) {
            $selected_country = $user->get_country_by_name($_GET['country']);
            /* assign variables */
            $smarty->assign('selected_country', $selected_country);
          }
        }

        // get posts (watch)
        $posts = ($selected_country) ? $user->get_posts(['get' => 'discover', 'filter' => 'video', 'country' => $selected_country['country_id']]) : $user->get_posts(['get' => 'discover', 'filter' => 'video']);
        /* assign variables */
        $smarty->assign('posts', $posts);
        break;
      default:
        _error(404);
        break;
    }
    /* assign variables */
    $smarty->assign('view', $_GET['view']);

    // get pro members & pages
    if ($system['packages_enabled']) {
      // get pro members
      $pro_members = $user->get_pro_members();
      /* assign variables */
      $smarty->assign('pro_members', $pro_members);
      // get promoted pages
      if ($system['pages_enabled']) {
        $promoted_pages = $user->get_pages(array('promoted' => true));
        /* assign variables */
        $smarty->assign('promoted_pages', $promoted_pages);
      }
    }

    // get suggested peopel
    $new_people = $user->get_new_people(0, true);
    /* assign variables */
    $smarty->assign('new_people', $new_people);

    // get suggested pages
    if ($system['pages_enabled']) {
      $new_pages = $user->get_pages(array('suggested' => true, 'random' => 'true', 'results' => 5));
      /* assign variables */
      $smarty->assign('new_pages', $new_pages);
    }

    // get suggested groups
    if ($system['groups_enabled']) {
      $new_groups = $user->get_groups(array('suggested' => true, 'random' => 'true', 'results' => 5));
      /* assign variables */
      $smarty->assign('new_groups', $new_groups);
    }

    // get suggested events
    if ($system['events_enabled']) {
      $new_events = $user->get_events(array('suggested' => true, 'random' => 'true', 'results' => 5));
      /* assign variables */
      $smarty->assign('new_events', $new_events);
    }

    // get ads campaigns
    $ads_campaigns = $user->ads_campaigns();
    /* assign variables */
    $smarty->assign('ads_campaigns', $ads_campaigns);
  }

  // get trending hashtags
  if ($system['trending_hashtags_enabled']) {
    $trending_hashtags = $user->get_trending_hashtags();
    /* assign variables */
    $smarty->assign('trending_hashtags', $trending_hashtags);
  }

  // get ads
  $ads = $user->ads('home');
  /* assign variables */
  $smarty->assign('ads', $ads);

  // get widgets
  $widgets = $user->widgets('home');
  /* assign variables */
  $smarty->assign('widgets', $widgets);
} catch (Exception $e) {
  _error(__("Error"), $e->getMessage());
}

// page footer
page_footer('index');
