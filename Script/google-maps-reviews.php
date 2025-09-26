<?php

/**
 * google-maps-reviews
 * 
 * @package Sngine
 * @author Zamblek
 */

// Handle API requests FIRST
if (isset($_GET['action']) || isset($_POST['action']) || (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false)) {
    // fetch bootloader for API
    require('bootloader.php');
    handleAPIRequest();
    exit;
}

// fetch bootloader for normal page
require('bootloader.php');

// user access
if (!$user->_logged_in) {
    user_login();
}

// Get view parameter
$view = isset($_GET['view']) ? $_GET['view'] : 'dashboard';

// page header
page_header(__("Google Maps Reviews"));

// Get user's Google Maps review requests
$user_requests = array();
$user_reviews = array();
$user_earnings = 0;
$user_wallet_balance = 0;

try {
    // Get user's balance from users table
    $get_balance = $db->query("SELECT user_wallet_balance FROM users WHERE user_id = '{$user->_data['user_id']}'");
    if ($get_balance->num_rows > 0) {
        $balance_data = $get_balance->fetch_assoc();
        $user_wallet_balance = $balance_data['user_wallet_balance'];
    }
    
    // Get user's review requests
    $get_requests = $db->query("
        SELECT gmr.*
        FROM google_maps_review_requests gmr
        WHERE gmr.requester_user_id = '{$user->_data['user_id']}'
        ORDER BY gmr.created_at DESC
    ");
    
    if ($get_requests->num_rows > 0) {
        while ($request = $get_requests->fetch_assoc()) {
            $user_requests[] = $request;
        }
    }
    
    // Get user's reviews
    $get_reviews = $db->query("
        SELECT gmr.*, gmr.place_name, gmr.reward_amount
        FROM google_maps_reviews gmr
        WHERE gmr.reviewer_user_id = '{$user->_data['user_id']}'
        ORDER BY gmr.created_at DESC
    ");
    
    if ($get_reviews->num_rows > 0) {
        while ($review = $get_reviews->fetch_assoc()) {
            $user_reviews[] = $review;
            if ($review['payment_status'] == 'paid') {
                $user_earnings += $review['reward_paid'];
            }
        }
    }
    
} catch (Exception $e) {
    error_log("Error getting user data: " . $e->getMessage());
}

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
        LIMIT 10
    ");
    
    if ($get_available_tasks->num_rows > 0) {
        while ($task = $get_available_tasks->fetch_assoc()) {
            $available_tasks[] = $task;
        }
    }
try {
    $get_tasks = $db->query("
        SELECT gmsr.*, gmr.place_name, gmr.place_address, gmr.reward_amount, p.page_name, p.page_title
        FROM google_maps_review_sub_requests gmsr
        LEFT JOIN google_maps_review_requests gmr ON gmsr.parent_request_id = gmr.request_id
        LEFT JOIN pages p ON gmr.page_id = p.page_id
        WHERE gmsr.status = 'available' AND gmsr.expires_at > NOW()
        ORDER BY gmsr.created_at DESC
        LIMIT 20
    ");
    
    if ($get_tasks->num_rows > 0) {
        while ($task = $get_tasks->fetch_assoc()) {
            $available_tasks[] = $task;
        }
    }
    
} catch (Exception $e) {
    error_log("Error getting available tasks: " . $e->getMessage());
}

// assign variables
$smarty->assign('user_requests', $user_requests);
$smarty->assign('user_reviews', $user_reviews);
$smarty->assign('user_earnings', $user_earnings);
$smarty->assign('available_tasks', $available_tasks);
$smarty->assign('user_wallet_balance', $user_wallet_balance);
$smarty->assign('view', $view);

// page footer
page_footer('google-maps-reviews');

/**
 * Handle API requests
 */
function handleAPIRequest() {
    global $db, $user;
    
    $action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');
    
    switch ($action) {
        case 'create_request':
            createReviewRequest();
            break;
        case 'assign_task':
            assignReviewTask();
            break;
        case 'submit_review':
            submitReview();
            break;
        case 'get_place_info':
            getPlaceInfo();
            break;
        default:
            echo json_encode(array('error' => 'Invalid action'));
            break;
    }
}

/**
 * Create new review request
 */
function createReviewRequest() {
    global $db, $user;
    
    try {
        // Không cần page_id nữa
        $place_name = isset($_POST['place_name']) ? $_POST['place_name'] : '';
        $place_address = isset($_POST['place_address']) ? $_POST['place_address'] : '';
        $place_url = isset($_POST['place_url']) ? $_POST['place_url'] : '';
        $reward_amount = 15000; // Chi phí cho người tạo chiến dịch
        $reviewer_reward = 10000; // Tiền thưởng cho người đánh giá
        $target_reviews = isset($_POST['target_reviews']) ? $_POST['target_reviews'] : 1;
        $expires_at = isset($_POST['expires_at']) ? $_POST['expires_at'] : '';
        
        if (empty($place_name) || empty($place_address)) {
            echo json_encode(array('error' => 'Vui lòng điền đầy đủ thông tin'));
            return;
        }
        
        // Cho phép tạo nhiều chiến dịch với cùng thông tin địa điểm
        
        $total_budget = $reward_amount * $target_reviews;
        
        // Check user balance from users table
        $get_balance = $db->query("SELECT user_wallet_balance FROM users WHERE user_id = '{$user->_data['user_id']}'");
        if ($get_balance->num_rows > 0) {
            $balance_data = $get_balance->fetch_assoc();
            $user_wallet_balance = $balance_data['user_wallet_balance'];
            
            if ($user_wallet_balance < $total_budget) {
                echo json_encode(array('error' => 'Số dư không đủ để tạo chiến dịch này'));
                return;
            }
        } else {
            echo json_encode(array('error' => 'Không thể lấy thông tin số dư từ bảng users'));
            return;
        }
        
        // Check if tables exist
        $check_tables = $db->query("SHOW TABLES LIKE 'google_maps_review_requests'");
        if ($check_tables->num_rows == 0) {
            echo json_encode(array('error' => 'Bảng google_maps_review_requests chưa tồn tại'));
            return;
        }
        
        $check_sub_tables = $db->query("SHOW TABLES LIKE 'google_maps_review_sub_requests'");
        if ($check_sub_tables->num_rows == 0) {
            echo json_encode(array('error' => 'Bảng google_maps_review_sub_requests chưa tồn tại'));
            return;
        }
        
        // Debug: Log all parameters
        error_log("Google Maps Debug - Page ID: $page_id");
        error_log("Google Maps Debug - Place Name: $place_name");
        error_log("Google Maps Debug - Place Address: $place_address");
        error_log("Google Maps Debug - Target Reviews: $target_reviews");
        error_log("Google Maps Debug - Total Budget: $total_budget");
        
        // Start transaction
        $db->query("START TRANSACTION");
        
        // Deduct balance from user
        $deduct_balance = $db->query("
            UPDATE users 
            SET user_wallet_balance = user_wallet_balance - {$total_budget} 
            WHERE user_id = '{$user->_data['user_id']}'
        ");
        
        if (!$deduct_balance) {
            throw new Exception("Lỗi trừ tiền: " . $db->error);
        }
        
        error_log("Google Maps Debug - Balance deducted successfully");
        
        // Create main request (chiến dịch mẹ)
        $insert_main = $db->query("
            INSERT INTO google_maps_review_requests 
            (requester_user_id, google_place_id, place_name, place_address, place_url, 
             reward_amount, target_reviews, total_budget, expires_at, status, created_at, updated_at)
            VALUES 
            ('{$user->_data['user_id']}', '', '{$place_name}', '{$place_address}', '{$place_url}', 
             '{$reward_amount}', '{$target_reviews}', '{$total_budget}', '{$expires_at}', 'active', NOW(), NOW())
        ");
        
        if (!$insert_main) {
            throw new Exception("Lỗi tạo chiến dịch mẹ: " . $db->error);
        }
        
        $request_id = $db->insert_id;
        error_log("Google Maps Debug - Main request created with ID: $request_id");
        
        // Create sub-requests (chiến dịch con) với tiền thưởng 10k cho người đánh giá
        for ($i = 0; $i < $target_reviews; $i++) {
            $insert_sub = $db->query("
                INSERT INTO google_maps_review_sub_requests 
                (parent_request_id, google_place_id, place_name, place_address, place_url, 
                 reward_amount, expires_at, status, created_at, updated_at)
                VALUES 
                ('{$request_id}', '', '{$place_name}', '{$place_address}', 
                 '{$place_url}', '{$reviewer_reward}', '{$expires_at}', 'available', NOW(), NOW())
            ");
            
            if (!$insert_sub) {
                throw new Exception("Lỗi tạo chiến dịch con: " . $db->error);
            }
        }
        
        error_log("Google Maps Debug - All sub-requests created successfully");
        
        // Commit transaction
        $db->query("COMMIT");
        
        echo json_encode(array('success' => true, 'request_id' => $request_id));
        
    } catch (Exception $e) {
        error_log("Google Maps Review Request Error: " . $e->getMessage());
        echo json_encode(array('error' => 'Lỗi: ' . $e->getMessage()));
    }
}

/**
 * Assign review task to user
 */
function assignReviewTask() {
    global $db, $user;
    
    try {
        $sub_request_id = isset($_POST['sub_request_id']) ? $_POST['sub_request_id'] : 0;
        
        error_log("Assign task debug - User ID: " . $user->_data['user_id']);
        error_log("Assign task debug - Sub request ID: " . $sub_request_id);
        
        if (empty($sub_request_id)) {
            echo json_encode(array('error' => 'Missing sub_request_id'));
            return;
        }
        
        if (empty($user->_data['user_id'])) {
            echo json_encode(array('error' => 'Vui lòng đăng nhập để nhận nhiệm vụ'));
            return;
        }
        
        // Check if task is still available
        $check_task = $db->query("
            SELECT * FROM google_maps_review_sub_requests 
            WHERE sub_request_id = '{$sub_request_id}' AND status = 'available'
        ");
        
        if ($check_task->num_rows == 0) {
            echo json_encode(array('error' => 'Task no longer available'));
            return;
        }
        
        $task = $check_task->fetch_assoc();
        
        // Check if user already has a task from this parent campaign
        $check_existing = $db->query("
            SELECT COUNT(*) as count FROM google_maps_review_sub_requests 
            WHERE parent_request_id = '{$task['parent_request_id']}' 
            AND assigned_user_id = '{$user->_data['user_id']}' 
            AND status IN ('assigned', 'completed')
        ");
        
        if ($check_existing->num_rows > 0) {
            $existing = $check_existing->fetch_assoc();
            if ($existing['count'] > 0) {
                echo json_encode(array('error' => 'Bạn đã nhận nhiệm vụ từ chiến dịch này rồi'));
                return;
            }
        }
        
        // Assign task to user
        $db->query("
            UPDATE google_maps_review_sub_requests 
            SET assigned_user_id = '{$user->_data['user_id']}', 
                assigned_at = NOW(), 
                status = 'assigned',
                updated_at = NOW()
            WHERE sub_request_id = '{$sub_request_id}'
        ");
        
        echo json_encode(array('success' => true));
        
    } catch (Exception $e) {
        echo json_encode(array('error' => $e->getMessage()));
    }
}

/**
 * Submit review
 */
function submitReview() {
    global $db, $user;
    
    try {
        $sub_request_id = isset($_POST['sub_request_id']) ? $_POST['sub_request_id'] : 0;
        $rating = isset($_POST['rating']) ? $_POST['rating'] : 0;
        $review_text = isset($_POST['review_text']) ? $_POST['review_text'] : '';
        $review_url = isset($_POST['review_url']) ? $_POST['review_url'] : '';
        $screenshot_proof = isset($_POST['screenshot_proof']) ? $_POST['screenshot_proof'] : '';
        
        if (empty($sub_request_id) || empty($rating)) {
            echo json_encode(array('error' => 'Missing required fields'));
            return;
        }
        
        // Get sub-request info
        $get_sub_request = $db->query("
            SELECT * FROM google_maps_review_sub_requests 
            WHERE sub_request_id = '{$sub_request_id}' AND assigned_user_id = '{$user->_data['user_id']}'
        ");
        
        if ($get_sub_request->num_rows == 0) {
            echo json_encode(array('error' => 'Task not found or not assigned to you'));
            return;
        }
        
        $sub_request = $get_sub_request->fetch_assoc();
        
        // Create review record
        $db->query("
            INSERT INTO google_maps_reviews 
            (request_id, sub_request_id, reviewer_user_id, google_place_id, rating, review_text, 
             review_url, screenshot_proof, verification_status, verification_method, 
             reward_paid, payment_status, created_at)
            VALUES 
            ('{$sub_request['parent_request_id']}', '{$sub_request_id}', '{$user->_data['user_id']}', 
             '{$sub_request['google_place_id']}', '{$rating}', '{$review_text}', '{$review_url}', 
             '{$screenshot_proof}', 'pending', 'screenshot', '{$sub_request['reward_amount']}', 
             'pending', NOW())
        ");
        
        $review_id = $db->insert_id;
        
        // Update sub-request status
        $db->query("
            UPDATE google_maps_review_sub_requests 
            SET status = 'completed', updated_at = NOW()
            WHERE sub_request_id = '{$sub_request_id}'
        ");
        
        echo json_encode(array('success' => true, 'review_id' => $review_id));
        
    } catch (Exception $e) {
        echo json_encode(array('error' => $e->getMessage()));
    }
}

/**
 * Get Google Place information
 */
function getPlaceInfo() {
    $place_id = isset($_GET['place_id']) ? $_GET['place_id'] : '';
    
    if (empty($place_id)) {
        echo json_encode(array('error' => 'Missing place_id'));
        return;
    }
    
    // This would integrate with Google Places API
    // For now, return mock data
    echo json_encode(array(
        'success' => true,
        'place' => array(
            'place_id' => $place_id,
            'name' => 'Sample Place',
            'address' => 'Sample Address',
            'rating' => 4.5,
            'user_ratings_total' => 100
        )
    ));
}
