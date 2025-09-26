<?php

/**
 * google-maps-reviews
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootloader
require('bootloader.php');

// Handle API requests
if (isset($_GET['action']) || (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false)) {
    handleAPIRequest();
    exit;
}

// user access
if (!$user->_logged_in) {
    user_login();
}

// Get view parameter
$view = $_GET['view'] ?? 'dashboard';

// page header
page_header(__("Google Maps Reviews"));

// Get user's Google Maps review requests
$user_requests = [];
$user_reviews = [];
$user_earnings = 0;
$user_balance = 0;

try {
    // Get user's balance
    $get_balance = $db->query("SELECT user_balance FROM users WHERE user_id = '{$user->_data['user_id']}'");
    if ($get_balance->num_rows > 0) {
        $balance_data = $get_balance->fetch_assoc();
        $user_balance = $balance_data['user_balance'];
    }
    
    // Get user's review requests
    $get_requests = $db->query("
        SELECT gmr.*, p.page_name, p.page_title
        FROM google_maps_review_requests gmr
        LEFT JOIN pages p ON gmr.page_id = p.page_id
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

// Get available review tasks
$available_tasks = [];
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
$smarty->assign('user_balance', $user_balance);
$smarty->assign('view', $view);

// page footer
page_footer('google-maps-reviews');

/**
 * Handle API requests
 */
function handleAPIRequest() {
    global $db, $user;
    
    $action = $_GET['action'] ?? '';
    
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
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
}

/**
 * Create new review request
 */
function createReviewRequest() {
    global $db, $user;
    
    try {
        $place_name = $_POST['place_name'] ?? '';
        $place_address = $_POST['place_address'] ?? '';
        $place_url = $_POST['place_url'] ?? '';
        $reward_amount = 15000; // Fixed amount
        $target_reviews = $_POST['target_reviews'] ?? 1;
        $expires_at = $_POST['expires_at'] ?? '';
        
        if (empty($place_name) || empty($place_address)) {
            echo json_encode(['error' => 'Vui lòng điền đầy đủ thông tin']);
            return;
        }
        
        $total_budget = $reward_amount * $target_reviews;
        
        // Check user balance
        $get_balance = $db->query("SELECT user_balance FROM users WHERE user_id = '{$user->_data['user_id']}'");
        if ($get_balance->num_rows > 0) {
            $balance_data = $get_balance->fetch_assoc();
            $user_balance = $balance_data['user_balance'];
            
            if ($user_balance < $total_budget) {
                echo json_encode(['error' => 'Số dư không đủ để tạo chiến dịch này']);
                return;
            }
        } else {
            echo json_encode(['error' => 'Không thể lấy thông tin số dư']);
            return;
        }
        
        // Start transaction
        $db->query("START TRANSACTION");
        
        // Deduct balance from user
        $db->query("
            UPDATE users 
            SET user_balance = user_balance - {$total_budget} 
            WHERE user_id = '{$user->_data['user_id']}'
        ");
        
        // Create main request
        $db->query("
            INSERT INTO google_maps_review_requests 
            (requester_user_id, place_name, place_address, place_url, 
             reward_amount, target_reviews, total_budget, expires_at, created_at, updated_at)
            VALUES 
            ('{$user->_data['user_id']}', '{$place_name}', '{$place_address}', '{$place_url}', 
             '{$reward_amount}', '{$target_reviews}', '{$total_budget}', '{$expires_at}', NOW(), NOW())
        ");
        
        $request_id = $db->insert_id;
        
        // Create sub-requests
        for ($i = 0; $i < $target_reviews; $i++) {
            $db->query("
                INSERT INTO google_maps_review_sub_requests 
                (parent_request_id, place_name, place_address, place_url, 
                 reward_amount, expires_at, created_at, updated_at)
                VALUES 
                ('{$request_id}', '{$place_name}', '{$place_address}', 
                 '{$place_url}', '{$reward_amount}', '{$expires_at}', NOW(), NOW())
            ");
        }
        
        // Commit transaction
        $db->query("COMMIT");
        
        echo json_encode(['success' => true, 'request_id' => $request_id]);
        
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

/**
 * Assign review task to user
 */
function assignReviewTask() {
    global $db, $user;
    
    try {
        $sub_request_id = $_POST['sub_request_id'] ?? 0;
        
        if (empty($sub_request_id)) {
            echo json_encode(['error' => 'Missing sub_request_id']);
            return;
        }
        
        // Check if task is still available
        $check_task = $db->query("
            SELECT * FROM google_maps_review_sub_requests 
            WHERE sub_request_id = '{$sub_request_id}' AND status = 'available'
        ");
        
        if ($check_task->num_rows == 0) {
            echo json_encode(['error' => 'Task no longer available']);
            return;
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
        
        echo json_encode(['success' => true]);
        
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

/**
 * Submit review
 */
function submitReview() {
    global $db, $user;
    
    try {
        $sub_request_id = $_POST['sub_request_id'] ?? 0;
        $rating = $_POST['rating'] ?? 0;
        $review_text = $_POST['review_text'] ?? '';
        $review_url = $_POST['review_url'] ?? '';
        $screenshot_proof = $_POST['screenshot_proof'] ?? '';
        
        if (empty($sub_request_id) || empty($rating)) {
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }
        
        // Get sub-request info
        $get_sub_request = $db->query("
            SELECT * FROM google_maps_review_sub_requests 
            WHERE sub_request_id = '{$sub_request_id}' AND assigned_user_id = '{$user->_data['user_id']}'
        ");
        
        if ($get_sub_request->num_rows == 0) {
            echo json_encode(['error' => 'Task not found or not assigned to you']);
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
        
        echo json_encode(['success' => true, 'review_id' => $review_id]);
        
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

/**
 * Get Google Place information
 */
function getPlaceInfo() {
    $place_id = $_GET['place_id'] ?? '';
    
    if (empty($place_id)) {
        echo json_encode(['error' => 'Missing place_id']);
        return;
    }
    
    // This would integrate with Google Places API
    // For now, return mock data
    echo json_encode([
        'success' => true,
        'place' => [
            'place_id' => $place_id,
            'name' => 'Sample Place',
            'address' => 'Sample Address',
            'rating' => 4.5,
            'user_ratings_total' => 100
        ]
    ]);
}
