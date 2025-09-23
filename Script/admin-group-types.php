<?php

/**
 * admin-group-types
 * 
 * @package Sngine
 * @author Shop-AI Team
 */

// fetch bootloader
require('bootloader.php');

// user access
user_access();

// check admin|moderator permission
if (!$user->_is_admin && !$user->_is_moderator) {
  _error(404);
}

// include group types class
require_once('includes/class-group-types.php');
$group_types = new GroupTypes($db, $user, $system);

try {

  // get view content
  switch ($_GET['view']) {
    
    case '':
      // page header
      page_header(__("Group Types Management"), __("Manage group types and their features"));

      // get group types
      $types = $group_types->get_group_types('active');
      
      // get type statistics
      $statistics = $group_types->get_type_statistics();
      
      // assign variables
      $smarty->assign('types', $types);
      $smarty->assign('statistics', $statistics);
      break;

    case 'create':
      // page header
      page_header(__("Create Group Type"), __("Create a new group type"));

      // get available features
      $available_features = [
        'product_management' => 'Quản lý sản phẩm',
        'order_management' => 'Quản lý đơn hàng',
        'inventory_tracking' => 'Theo dõi kho hàng',
        'payment_gateway' => 'Cổng thanh toán',
        'customer_support' => 'Hỗ trợ khách hàng',
        'promotions' => 'Khuyến mãi',
        'shipping_management' => 'Quản lý vận chuyển',
        'reviews' => 'Đánh giá sản phẩm',
        'wishlist' => 'Danh sách yêu thích',
        'price_alerts' => 'Cảnh báo giá',
        'deals_sharing' => 'Chia sẻ deal',
        'buyer_guides' => 'Hướng dẫn mua hàng',
        'product_comparison' => 'So sánh sản phẩm',
        'group_buying' => 'Mua chung',
        'ticket_system' => 'Hệ thống ticket',
        'knowledge_base' => 'Cơ sở tri thức',
        'live_chat' => 'Chat trực tuyến',
        'faq_management' => 'Quản lý FAQ',
        'escalation_rules' => 'Quy tắc chuyển tiếp',
        'response_templates' => 'Mẫu phản hồi',
        'satisfaction_surveys' => 'Khảo sát hài lòng',
        'multi_vendor' => 'Đa người bán',
        'commission_management' => 'Quản lý hoa hồng',
        'vendor_verification' => 'Xác minh người bán',
        'marketplace_analytics' => 'Analytics marketplace',
        'dispute_resolution' => 'Giải quyết tranh chấp',
        'payment_processing' => 'Xử lý thanh toán',
        'vendor_ranking' => 'Xếp hạng người bán',
        'promotional_tools' => 'Công cụ khuyến mãi',
        'course_management' => 'Quản lý khóa học',
        'lesson_planning' => 'Lập kế hoạch bài học',
        'student_progress' => 'Tiến độ học viên',
        'assignments' => 'Bài tập',
        'quizzes' => 'Câu hỏi trắc nghiệm',
        'certificates' => 'Chứng chỉ',
        'resource_library' => 'Thư viện tài nguyên',
        'attendance_tracking' => 'Theo dõi điểm danh',
        'event_creation' => 'Tạo sự kiện',
        'attendee_management' => 'Quản lý người tham gia',
        'ticket_sales' => 'Bán vé',
        'venue_booking' => 'Đặt địa điểm',
        'sponsor_management' => 'Quản lý nhà tài trợ',
        'event_analytics' => 'Analytics sự kiện',
        'check_in_system' => 'Hệ thống check-in',
        'feedback_collection' => 'Thu thập phản hồi',
        'social_posts' => 'Bài đăng xã hội',
        'media_sharing' => 'Chia sẻ media',
        'user_profiles' => 'Hồ sơ người dùng',
        'friend_connections' => 'Kết nối bạn bè',
        'activity_feed' => 'Bảng tin hoạt động',
        'social_analytics' => 'Analytics xã hội',
        'content_moderation' => 'Kiểm duyệt nội dung',
        'engagement_tools' => 'Công cụ tương tác',
        'professional_profiles' => 'Hồ sơ chuyên nghiệp',
        'skill_endorsements' => 'Chứng thực kỹ năng',
        'job_postings' => 'Đăng tuyển việc làm',
        'networking_events' => 'Sự kiện kết nối',
        'mentorship_program' => 'Chương trình cố vấn',
        'industry_insights' => 'Thông tin ngành',
        'career_development' => 'Phát triển sự nghiệp',
        'professional_analytics' => 'Analytics chuyên nghiệp'
      ];
      
      // assign variables
      $smarty->assign('available_features', $available_features);
      break;

    case 'edit':
      /* valid inputs */
      if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['id'], 'int');
      
      // get group type
      $type = $group_types->get_group_type($type_id);
      if (!$type) {
        _error(404);
      }
      
      // page header
      page_header(__("Edit Group Type") . ' &rsaquo; ' . __($type['type_name']), __("Edit group type settings"));

      // get available features
      $available_features = [
        'product_management' => 'Quản lý sản phẩm',
        'order_management' => 'Quản lý đơn hàng',
        'inventory_tracking' => 'Theo dõi kho hàng',
        'payment_gateway' => 'Cổng thanh toán',
        'customer_support' => 'Hỗ trợ khách hàng',
        'promotions' => 'Khuyến mãi',
        'shipping_management' => 'Quản lý vận chuyển',
        'reviews' => 'Đánh giá sản phẩm',
        'wishlist' => 'Danh sách yêu thích',
        'price_alerts' => 'Cảnh báo giá',
        'deals_sharing' => 'Chia sẻ deal',
        'buyer_guides' => 'Hướng dẫn mua hàng',
        'product_comparison' => 'So sánh sản phẩm',
        'group_buying' => 'Mua chung',
        'ticket_system' => 'Hệ thống ticket',
        'knowledge_base' => 'Cơ sở tri thức',
        'live_chat' => 'Chat trực tuyến',
        'faq_management' => 'Quản lý FAQ',
        'escalation_rules' => 'Quy tắc chuyển tiếp',
        'response_templates' => 'Mẫu phản hồi',
        'satisfaction_surveys' => 'Khảo sát hài lòng',
        'multi_vendor' => 'Đa người bán',
        'commission_management' => 'Quản lý hoa hồng',
        'vendor_verification' => 'Xác minh người bán',
        'marketplace_analytics' => 'Analytics marketplace',
        'dispute_resolution' => 'Giải quyết tranh chấp',
        'payment_processing' => 'Xử lý thanh toán',
        'vendor_ranking' => 'Xếp hạng người bán',
        'promotional_tools' => 'Công cụ khuyến mãi',
        'course_management' => 'Quản lý khóa học',
        'lesson_planning' => 'Lập kế hoạch bài học',
        'student_progress' => 'Tiến độ học viên',
        'assignments' => 'Bài tập',
        'quizzes' => 'Câu hỏi trắc nghiệm',
        'certificates' => 'Chứng chỉ',
        'resource_library' => 'Thư viện tài nguyên',
        'attendance_tracking' => 'Theo dõi điểm danh',
        'event_creation' => 'Tạo sự kiện',
        'attendee_management' => 'Quản lý người tham gia',
        'ticket_sales' => 'Bán vé',
        'venue_booking' => 'Đặt địa điểm',
        'sponsor_management' => 'Quản lý nhà tài trợ',
        'event_analytics' => 'Analytics sự kiện',
        'check_in_system' => 'Hệ thống check-in',
        'feedback_collection' => 'Thu thập phản hồi',
        'social_posts' => 'Bài đăng xã hội',
        'media_sharing' => 'Chia sẻ media',
        'user_profiles' => 'Hồ sơ người dùng',
        'friend_connections' => 'Kết nối bạn bè',
        'activity_feed' => 'Bảng tin hoạt động',
        'social_analytics' => 'Analytics xã hội',
        'content_moderation' => 'Kiểm duyệt nội dung',
        'engagement_tools' => 'Công cụ tương tác',
        'professional_profiles' => 'Hồ sơ chuyên nghiệp',
        'skill_endorsements' => 'Chứng thực kỹ năng',
        'job_postings' => 'Đăng tuyển việc làm',
        'networking_events' => 'Sự kiện kết nối',
        'mentorship_program' => 'Chương trình cố vấn',
        'industry_insights' => 'Thông tin ngành',
        'career_development' => 'Phát triển sự nghiệp',
        'professional_analytics' => 'Analytics chuyên nghiệp'
      ];
      
      // assign variables
      $smarty->assign('type', $type);
      $smarty->assign('available_features', $available_features);
      break;

    case 'groups':
      /* valid inputs */
      if (!isset($_GET['type_id']) || !is_numeric($_GET['type_id'])) {
        _error(400);
      }
      
      $type_id = secure($_GET['type_id'], 'int');
      
      // get group type
      $type = $group_types->get_group_type($type_id);
      if (!$type) {
        _error(404);
      }
      
      // get groups by type
      $groups = $group_types->get_groups_by_type($type_id, 50);
      
      // page header
      page_header(__("Groups by Type") . ' &rsaquo; ' . __($type['type_name']), __("Groups using this type"));

      // assign variables
      $smarty->assign('type', $type);
      $smarty->assign('groups', $groups);
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
page_footer('admin-group-types');
