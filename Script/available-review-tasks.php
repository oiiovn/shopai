<?php

/**
 * available-review-tasks
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootloader
require('bootloader.php');

// user access
if (!$user->_logged_in) {
    user_login();
}

// page header
page_header(__("Nhiệm vụ đánh giá có sẵn"));

// Get available review tasks (hiển thị 1 nhiệm vụ con từ mỗi chiến dịch mẹ khác nhau)
// Loại bỏ các chiến dịch mà user đã tạo và đã nhận
$available_tasks = array();
$get_available_tasks = $db->query("
    SELECT gmsr.*, gmr.place_name, gmr.place_address, gmr.place_url, gmr.expires_at as parent_expires_at
    FROM google_maps_review_sub_requests gmsr
    LEFT JOIN google_maps_review_requests gmr ON gmsr.parent_request_id = gmr.request_id
    WHERE gmsr.status = 'available' 
    AND gmsr.expires_at > NOW()
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
    LIMIT 20
");

if ($get_available_tasks->num_rows > 0) {
    while ($task = $get_available_tasks->fetch_assoc()) {
        $available_tasks[] = $task;
    }
}

// assign variables
$smarty->assign('available_tasks', $available_tasks);

// page footer
page_footer("available-review-tasks");

?>
