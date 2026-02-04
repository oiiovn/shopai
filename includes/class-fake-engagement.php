<?php

/**
 * Fake Engagement Class
 * 
 * Tự động tạo fake reactions cho bài viết của admin
 * - Fake reactions tăng dần theo lượt xem (luôn ít hơn views)
 * - Chỉ lấy users có ảnh đại diện, ảnh bìa và số điện thoại thật
 * 
 * @package Sngine
 */

class FakeEngagement
{
  /**
   * Lấy danh sách users "thật" (có avatar, cover, phone)
   * 
   * @param int $exclude_user_id - User ID cần loại trừ (người đăng bài)
   * @param array $exclude_ids - Danh sách user IDs cần loại trừ
   * @param int $limit - Số lượng users cần lấy
   * @return array
   */
  public static function get_real_users($exclude_user_id = 0, $exclude_ids = [], $limit = 100)
  {
    global $db;
    
    // Thêm author vào danh sách loại trừ
    $exclude_ids[] = $exclude_user_id;
    $exclude_ids = array_unique(array_filter($exclude_ids));
    $exclude_clause = !empty($exclude_ids) ? sprintf("AND user_id NOT IN (%s)", implode(',', array_map('intval', $exclude_ids))) : "";
    
    $query = "SELECT user_id, user_name, user_firstname, user_lastname, user_gender, user_picture 
              FROM users 
              WHERE user_picture IS NOT NULL 
                AND user_picture != '' 
                AND user_cover IS NOT NULL 
                AND user_cover != ''
                AND user_phone IS NOT NULL 
                AND user_phone != ''
                %s
              ORDER BY RAND()
              LIMIT %s";
    
    $get_users = $db->query(sprintf($query, $exclude_clause, secure($limit, 'int', false))) or _error('SQL_ERROR_THROWEN');
    
    $users = [];
    while ($user = $get_users->fetch_assoc()) {
      $users[] = $user;
    }
    
    return $users;
  }

  /**
   * Đánh dấu bài viết của admin để tạo fake reactions sau
   * (Gọi khi admin đăng bài - không tạo fake ngay)
   * 
   * @param int $post_id - ID bài viết
   * @param int $author_id - ID người đăng bài (admin)
   * @return void
   */
  public static function mark_admin_post($post_id, $author_id)
  {
    global $db, $date;
    
    // Đánh dấu bài viết này cần fake engagement
    // user_id = 0 nghĩa là marker, không phải fake reaction thật
    $db->query(sprintf(
      "INSERT IGNORE INTO posts_fake_reactions (post_id, user_id, reaction, reaction_time) 
       VALUES (%s, 0, 'marker', %s)",
      secure($post_id, 'int'),
      secure($date)
    ));
  }

  /**
   * Kiểm tra bài viết có được đánh dấu fake engagement không
   * 
   * @param int $post_id
   * @return bool
   */
  public static function is_marked_post($post_id)
  {
    global $db;
    
    $check = $db->query(sprintf(
      "SELECT id FROM posts_fake_reactions WHERE post_id = %s AND user_id = 0 AND reaction = 'marker'",
      secure($post_id, 'int')
    ));
    
    return ($check && $check->num_rows > 0);
  }

  /**
   * Lấy số lượng users đủ điều kiện làm fake reactions
   * 
   * @param int $exclude_user_id
   * @return int
   */
  public static function count_available_users($exclude_user_id = 0)
  {
    global $db;
    
    $exclude_clause = $exclude_user_id > 0 ? sprintf("AND user_id != %s", secure($exclude_user_id, 'int')) : "";
    
    $count = $db->query(sprintf(
      "SELECT COUNT(*) as count FROM users 
       WHERE user_picture IS NOT NULL 
         AND user_picture != '' 
         AND user_cover IS NOT NULL 
         AND user_cover != ''
         AND user_phone IS NOT NULL 
         AND user_phone != ''
         %s",
      $exclude_clause
    ));
    
    return (int) $count->fetch_assoc()['count'];
  }

  /**
   * Tính số fake reactions dựa trên số users có sẵn và views
   * - Lấy 20-80% số users có sẵn
   * - Nhưng KHÔNG VƯỢT QUÁ 30% của views
   * - Mỗi bài viết có tỷ lệ khác nhau (dựa trên post_id)
   * 
   * @param int $views - Số lượt xem hiện tại
   * @param int $post_id - ID bài viết
   * @param int $total_available_users - Tổng số users có sẵn
   * @param int $min_percent - Phần trăm tối thiểu của users
   * @param int $max_percent - Phần trăm tối đa của users
   * @return int
   */
  public static function calculate_fake_count($views, $post_id = 0, $total_available_users = 0, $min_percent = 20, $max_percent = 80)
  {
    if ($views <= 0 || $total_available_users <= 0) {
      return 0;
    }
    
    // Tạo tỷ lệ riêng cho mỗi bài viết dựa trên post_id (1-5% của views)
    if ($post_id > 0) {
      $seed = $post_id * 7919;
      // Tỷ lệ từ 1% đến 5% của views
      $view_percent = 1 + ($seed % 5); // 1-5%
    } else {
      $view_percent = rand(1, 5);
    }
    
    // Tính số fake dựa trên % của views (max 5%)
    $count_by_views = (int) floor($views * $view_percent / 100);
    
    // Không vượt quá số users có sẵn
    $count = min($count_by_views, $total_available_users);
    
    // Tối thiểu 0, tối đa 500
    return max(0, min($count, 500));
  }

  /**
   * Cập nhật fake reactions dựa trên lượt xem hiện tại
   * Gọi mỗi khi bài viết được xem
   * 
   * @param int $post_id - ID bài viết
   * @param int $author_id - ID người đăng bài
   * @param int $current_views - Số lượt xem hiện tại
   * @return void
   */
  public static function update_fake_reactions_by_views($post_id, $author_id, $current_views)
  {
    global $db, $system, $date;
    
    // Lấy số fake reactions hiện tại
    $current_fake = self::count_fake_reactions($post_id);
    
    // Lấy số users đủ điều kiện (loại trừ author)
    $total_available_users = self::count_available_users($author_id);
    
    // Tính số fake reactions cần có
    // Dựa trên số users có sẵn, nhưng luôn ít hơn views
    $min_percent = isset($system['fake_engagement_min_percent']) ? (int)$system['fake_engagement_min_percent'] : 20;
    $max_percent = isset($system['fake_engagement_max_percent']) ? (int)$system['fake_engagement_max_percent'] : 80;
    $target_fake = self::calculate_fake_count($current_views, $post_id, $total_available_users, $min_percent, $max_percent);
    
    // Nếu cần thêm fake reactions
    $need_to_add = $target_fake - $current_fake;
    
    if ($need_to_add > 0) {
      // Lấy danh sách user IDs đã có fake reaction
      $existing_ids = self::get_existing_fake_user_ids($post_id);
      
      // Lấy users mới để thêm fake reactions
      $new_users = self::get_real_users($author_id, $existing_ids, $need_to_add);
      
      if (!empty($new_users)) {
        self::add_fake_reactions($post_id, $new_users);
      }
    }
  }

  /**
   * Lấy danh sách user IDs đã có fake reaction cho bài viết
   * 
   * @param int $post_id
   * @return array
   */
  public static function get_existing_fake_user_ids($post_id)
  {
    global $db;
    
    $ids = [];
    $get_ids = $db->query(sprintf(
      "SELECT user_id FROM posts_fake_reactions WHERE post_id = %s AND user_id > 0",
      secure($post_id, 'int')
    ));
    
    while ($row = $get_ids->fetch_assoc()) {
      $ids[] = (int) $row['user_id'];
    }
    
    return $ids;
  }

  /**
   * Thêm fake reactions cho danh sách users
   * 
   * @param int $post_id
   * @param array $users
   * @return void
   */
  public static function add_fake_reactions($post_id, $users)
  {
    global $db, $date;
    
    // Các loại reactions với tỷ lệ - hạn chế sad và angry
    $reactions = [
      'like'  => 45,  // 45%
      'love'  => 30,  // 30%
      'haha'  => 15,  // 15%
      'wow'   => 8,   // 8%
      'sad'   => 1,   // 1% - rất ít
      'angry' => 1    // 1% - rất ít
    ];
    
    foreach ($users as $user) {
      // Chọn ngẫu nhiên loại reaction theo tỷ lệ
      $reaction = self::weighted_random($reactions);
      
      // Random thời gian trong vòng vài phút gần đây
      $random_minutes = rand(1, 30);
      $reaction_time = date('Y-m-d H:i:s', strtotime("-{$random_minutes} minutes"));
      
      // Insert vào bảng fake reactions
      $db->query(sprintf(
        "INSERT IGNORE INTO posts_fake_reactions (post_id, user_id, reaction, reaction_time) 
         VALUES (%s, %s, %s, %s)",
        secure($post_id, 'int'),
        secure($user['user_id'], 'int'),
        secure($reaction),
        secure($reaction_time)
      ));
    }
    
    // Cập nhật counter trong bảng posts
    self::update_post_reaction_counts($post_id);
  }

  /**
   * Tạo fake reactions cho bài viết (legacy - để tương thích)
   * Giờ sẽ không tạo ngay mà chỉ đánh dấu
   * 
   * @param int $post_id - ID bài viết
   * @param int $author_id - ID người đăng bài (admin)
   * @param int $min_percent - Phần trăm tối thiểu (mặc định 20)
   * @param int $max_percent - Phần trăm tối đa (mặc định 80)
   * @return array - Số lượng fake reactions đã tạo theo loại
   */
  public static function generate_fake_reactions($post_id, $author_id, $min_percent = 20, $max_percent = 80)
  {
    // Đánh dấu bài viết admin, không tạo fake ngay
    self::mark_admin_post($post_id, $author_id);
    
    return [
      'like' => 0,
      'love' => 0,
      'haha' => 0,
      'yay' => 0,
      'wow' => 0,
      'sad' => 0,
      'angry' => 0
    ];
  }

  /**
   * Chọn ngẫu nhiên theo tỷ lệ weighted
   * 
   * @param array $weighted_values - Mảng [value => weight]
   * @return string
   */
  private static function weighted_random($weighted_values)
  {
    $rand = rand(1, array_sum($weighted_values));
    
    foreach ($weighted_values as $key => $value) {
      $rand -= $value;
      if ($rand <= 0) {
        return $key;
      }
    }
    
    return array_key_first($weighted_values);
  }

  /**
   * Cập nhật số lượng reactions trong bảng posts
   * 
   * @param int $post_id
   * @return void
   */
  public static function update_post_reaction_counts($post_id)
  {
    global $db;
    
    // Đếm fake reactions theo loại (không tính marker với user_id = 0)
    $get_counts = $db->query(sprintf(
      "SELECT reaction, COUNT(*) as count 
       FROM posts_fake_reactions 
       WHERE post_id = %s AND user_id > 0
       GROUP BY reaction",
      secure($post_id, 'int')
    ));
    
    $fake_counts = [
      'like' => 0,
      'love' => 0,
      'haha' => 0,
      'yay' => 0,
      'wow' => 0,
      'sad' => 0,
      'angry' => 0
    ];
    
    while ($row = $get_counts->fetch_assoc()) {
      $fake_counts[$row['reaction']] = (int) $row['count'];
    }
    
    // Lấy số reactions thật
    $get_real_counts = $db->query(sprintf(
      "SELECT reaction, COUNT(*) as count 
       FROM posts_reactions 
       WHERE post_id = %s 
       GROUP BY reaction",
      secure($post_id, 'int')
    ));
    
    $real_counts = [
      'like' => 0,
      'love' => 0,
      'haha' => 0,
      'yay' => 0,
      'wow' => 0,
      'sad' => 0,
      'angry' => 0
    ];
    
    while ($row = $get_real_counts->fetch_assoc()) {
      $real_counts[$row['reaction']] = (int) $row['count'];
    }
    
    // Cộng tổng real + fake
    $total_like = $real_counts['like'] + $fake_counts['like'];
    $total_love = $real_counts['love'] + $fake_counts['love'];
    $total_haha = $real_counts['haha'] + $fake_counts['haha'];
    $total_yay = $real_counts['yay'] + $fake_counts['yay'];
    $total_wow = $real_counts['wow'] + $fake_counts['wow'];
    $total_sad = $real_counts['sad'] + $fake_counts['sad'];
    $total_angry = $real_counts['angry'] + $fake_counts['angry'];
    
    // Update bảng posts
    $db->query(sprintf(
      "UPDATE posts SET 
        reaction_like_count = %s,
        reaction_love_count = %s,
        reaction_haha_count = %s,
        reaction_yay_count = %s,
        reaction_wow_count = %s,
        reaction_sad_count = %s,
        reaction_angry_count = %s
       WHERE post_id = %s",
      $total_like, $total_love, $total_haha, $total_yay, $total_wow, $total_sad, $total_angry,
      secure($post_id, 'int')
    ));
  }

  /**
   * Lấy danh sách users đã react (real + fake, loại trừ viewer khỏi fake)
   * 
   * @param int $post_id
   * @param int $viewer_id - ID người đang xem
   * @param string $reaction_type - Loại reaction (all, like, love, ...)
   * @param int $offset
   * @param int $limit
   * @return array
   */
  public static function get_reactions_list($post_id, $viewer_id, $reaction_type = 'all', $offset = 0, $limit = 10)
  {
    global $db;
    
    $users = [];
    $where_reaction = ($reaction_type == 'all') ? "" : sprintf("AND reaction = %s", secure($reaction_type));
    
    // Lấy real reactions
    $get_real = $db->query(sprintf(
      "SELECT pr.reaction, u.user_id, u.user_name, u.user_firstname, u.user_lastname, 
              u.user_gender, u.user_picture, u.user_subscribed, u.user_verified,
              'real' as source
       FROM posts_reactions pr
       INNER JOIN users u ON pr.user_id = u.user_id
       WHERE pr.post_id = %s %s",
      secure($post_id, 'int'),
      $where_reaction
    ));
    
    while ($row = $get_real->fetch_assoc()) {
      $users[$row['user_id']] = $row;
    }
    
    // Lấy fake reactions (loại trừ viewer và những user đã react thật)
    $exclude_ids = array_keys($users);
    $exclude_ids[] = $viewer_id;
    $exclude_clause = !empty($exclude_ids) ? sprintf("AND pfr.user_id NOT IN (%s)", implode(',', array_map('intval', $exclude_ids))) : "";
    
    $get_fake = $db->query(sprintf(
      "SELECT pfr.reaction, u.user_id, u.user_name, u.user_firstname, u.user_lastname, 
              u.user_gender, u.user_picture, u.user_subscribed, u.user_verified,
              'fake' as source
       FROM posts_fake_reactions pfr
       INNER JOIN users u ON pfr.user_id = u.user_id
       WHERE pfr.post_id = %s %s %s",
      secure($post_id, 'int'),
      $where_reaction,
      $exclude_clause
    ));
    
    while ($row = $get_fake->fetch_assoc()) {
      if (!isset($users[$row['user_id']])) {
        $users[$row['user_id']] = $row;
      }
    }
    
    // Shuffle và phân trang
    $users = array_values($users);
    shuffle($users);
    
    return array_slice($users, $offset, $limit);
  }

  /**
   * Kiểm tra user có phải admin không
   * 
   * @param int $user_id
   * @return bool
   */
  public static function is_admin($user_id)
  {
    global $db;
    
    $check = $db->query(sprintf(
      "SELECT user_group FROM users WHERE user_id = %s",
      secure($user_id, 'int')
    ));
    
    if ($check->num_rows > 0) {
      $user = $check->fetch_assoc();
      return ($user['user_group'] == 1); // Group 1 = Admin
    }
    
    return false;
  }

  /**
   * Xóa fake reactions khi xóa bài viết
   * 
   * @param int $post_id
   * @return void
   */
  public static function delete_fake_reactions($post_id)
  {
    global $db;
    
    $db->query(sprintf(
      "DELETE FROM posts_fake_reactions WHERE post_id = %s",
      secure($post_id, 'int')
    ));
  }

  /**
   * Đếm tổng fake reactions của bài viết (không tính marker)
   * 
   * @param int $post_id
   * @param int $viewer_id - Loại trừ viewer
   * @return int
   */
  public static function count_fake_reactions($post_id, $viewer_id = 0)
  {
    global $db;
    
    $exclude_clause = $viewer_id > 0 ? sprintf("AND user_id != %s", secure($viewer_id, 'int')) : "";
    
    $count = $db->query(sprintf(
      "SELECT COUNT(*) as count FROM posts_fake_reactions WHERE post_id = %s AND user_id > 0 %s",
      secure($post_id, 'int'),
      $exclude_clause
    ));
    
    return (int) $count->fetch_assoc()['count'];
  }

  /**
   * Kiểm tra user có trong danh sách fake không
   * 
   * @param int $post_id
   * @param int $user_id
   * @return bool
   */
  public static function is_fake_reactor($post_id, $user_id)
  {
    global $db;
    
    $check = $db->query(sprintf(
      "SELECT id FROM posts_fake_reactions WHERE post_id = %s AND user_id = %s",
      secure($post_id, 'int'),
      secure($user_id, 'int')
    ));
    
    return ($check->num_rows > 0);
  }

  /**
   * Xóa user khỏi fake reactions khi họ react thật
   * 
   * @param int $post_id
   * @param int $user_id
   * @return void
   */
  public static function remove_from_fake($post_id, $user_id)
  {
    global $db;
    
    $db->query(sprintf(
      "DELETE FROM posts_fake_reactions WHERE post_id = %s AND user_id = %s",
      secure($post_id, 'int'),
      secure($user_id, 'int')
    ));
    
    // Cập nhật lại counter
    self::update_post_reaction_counts($post_id);
  }
}
