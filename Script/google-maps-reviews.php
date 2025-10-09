<?php

/**
 * google-maps-reviews
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootloader
require('bootloader.php');

// Load OpenAI functions
require_once('includes/openai-functions.php');

// Handle API requests for AJAX calls (only for POST requests with action)
if (isset($_POST['action']) || (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false)) {
    handleAPIRequest();
    exit;
}

// Handle specific routes for pages (not API calls) - BEFORE user login check
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if ($action == 'submit-proof' && isset($_GET['id'])) {
        // Check user login first for submit-proof page
        if (!$user->_logged_in) {
            user_login();
        }
        
        // Submit proof page
        $sub_request_id = (int)$_GET['id'];
        
        // Get task details
        $task_query = $db->query("
            SELECT gmsr.*, gmr.place_name, gmr.place_address, gmsr.reward_amount
            FROM google_maps_review_sub_requests gmsr
            LEFT JOIN google_maps_review_requests gmr ON gmsr.parent_request_id = gmr.request_id
            WHERE gmsr.sub_request_id = '{$sub_request_id}'
            AND gmsr.assigned_user_id = '{$user->_data['user_id']}'
            AND gmsr.status = 'assigned'
        ");
        
        $task = $task_query->num_rows > 0 ? $task_query->fetch_assoc() : null;
        
        page_header(__("Submit Proof"));
        $smarty->assign('task', $task);
        $smarty->display('submit-proof.tpl');
        exit;
        
    } elseif ($action == 'view-proof' && isset($_GET['id'])) {
        // Check user login first for view-proof page
        if (!$user->_logged_in) {
            user_login();
        }
        
        // View proof page
        $sub_request_id = (int)$_GET['id'];
        
        // Get task details (allow viewing if user is assigned or admin)
        $task_query = $db->query("
            SELECT gmsr.*, gmr.place_name, gmr.place_address, gmsr.reward_amount
            FROM google_maps_review_sub_requests gmsr
            LEFT JOIN google_maps_review_requests gmr ON gmsr.parent_request_id = gmr.request_id
            WHERE gmsr.sub_request_id = '{$sub_request_id}'
            AND (gmsr.assigned_user_id = '{$user->_data['user_id']}' OR '{$user->_is_admin}' = '1')
        ");
        
        $task = null;
        $proof_data = null;
        
        if ($task_query->num_rows > 0) {
            $task = $task_query->fetch_assoc();
            if (!empty($task['proof_data'])) {
                $proof_data = json_decode($task['proof_data'], true);
            }
        }
        
        page_header(__("View Proof"));
        $smarty->assign('task', $task);
        $smarty->assign('proof_data', $proof_data);
        $smarty->display('view-proof.tpl');
        exit;
        
    } elseif ($action == 'request-details' && isset($_GET['id'])) {
        // Check user login first
        if (!$user->_logged_in) {
            user_login();
        }
        
        // Request details page - Chi tiết chiến dịch mẹ
        $request_id = (int)$_GET['id'];
        
        // Get campaign details (chỉ cho phép xem nếu là người tạo)
        $campaign_query = $db->query("
            SELECT gmr.*
            FROM google_maps_review_requests gmr
            WHERE gmr.request_id = '{$request_id}'
            AND gmr.requester_user_id = '{$user->_data['user_id']}'
        ");
        
        if ($campaign_query->num_rows == 0) {
            _error(403);
        }
        
        $campaign = $campaign_query->fetch_assoc();
        
        // Get all sub-requests của chiến dịch này
        // Rating và review content đã được lưu trực tiếp trong bảng google_maps_review_sub_requests
        $sub_requests = array();
        $get_sub_requests = $db->query("
            SELECT gmsr.*,
                   u.user_firstname, u.user_lastname, u.user_name, u.user_picture, u.user_verified, u.user_gender
            FROM google_maps_review_sub_requests gmsr
            LEFT JOIN users u ON gmsr.assigned_user_id = u.user_id
            WHERE gmsr.parent_request_id = '{$request_id}'
            ORDER BY gmsr.created_at ASC
        ");
        
        if ($get_sub_requests && $get_sub_requests->num_rows > 0) {
            while ($sub = $get_sub_requests->fetch_assoc()) {
                $sub_requests[] = $sub;
            }
        }
        
        page_header(__("Chi tiết chiến dịch: ") . $campaign['place_name']);
        $smarty->assign('campaign', $campaign);
        $smarty->assign('sub_requests', $sub_requests);
        $smarty->display('google-maps-request-details.tpl');
        exit;
    }
}

// user access for other pages
if (!$user->_logged_in) {
    user_login();
}

// Get view parameter
$view = isset($_GET['view']) ? $_GET['view'] : 'dashboard';

// page header
if ($view == 'my-reviews') {
    page_header(__("My Reviews"));
} elseif ($view == 'reward-history') {
    page_header(__("Lịch sử thưởng"));
} else {
    page_header(__("Google Maps Reviews"));
}

// Get user's Google Maps review requests
$user_requests = array();
$user_reviews = array();
$user_earnings = 0;
$user_wallet_balance = 0;

// Get user's assigned review tasks (for my-reviews view)
$assigned_tasks = array();

try {
    // Get user's balance from users table
    $get_balance = $db->query("SELECT user_wallet_balance FROM users WHERE user_id = '{$user->_data['user_id']}'");
    if ($get_balance->num_rows > 0) {
        $balance_data = $get_balance->fetch_assoc();
        $user_wallet_balance = $balance_data['user_wallet_balance'];
    }
    
    // Get user's review requests with sub-request counts
    $get_requests = $db->query("
        SELECT 
            gmr.*,
            COUNT(CASE WHEN gmsr.parent_request_id IS NOT NULL THEN 1 END) as total_valid_subs,
            COUNT(CASE WHEN gmsr.status IN ('completed', 'verified') AND gmsr.parent_request_id IS NOT NULL THEN 1 END) as completed_subs
        FROM google_maps_review_requests gmr
        LEFT JOIN google_maps_review_sub_requests gmsr ON gmr.request_id = gmsr.parent_request_id
        WHERE gmr.requester_user_id = '{$user->_data['user_id']}'
        GROUP BY gmr.request_id
        ORDER BY gmr.created_at DESC
    ");
    
    if ($get_requests->num_rows > 0) {
        while ($request = $get_requests->fetch_assoc()) {
            // Calculate progress percentage based on completed tasks
            $request['progress_percent'] = $request['total_valid_subs'] > 0 
                ? round(($request['completed_subs'] / $request['total_valid_subs']) * 100) 
                : 0;
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
    
    // Get user's reward history (for reward-history view)
    $reward_history = array();
    if ($view == 'reward-history') {
        $get_reward_history = $db->query("
            SELECT 
                gmsr.sub_request_id,
                gmsr.reward_amount,
                gmsr.created_at,
                gmsr.status,
                gmsr.completed_at,
                gmsr.verified_at,
                gmr.place_name,
                gmr.place_address
            FROM google_maps_review_sub_requests gmsr
            LEFT JOIN google_maps_review_requests gmr ON gmsr.parent_request_id = gmr.request_id
            WHERE gmsr.assigned_user_id = '{$user->_data['user_id']}'
            AND gmsr.status IN ('completed', 'verified')
            ORDER BY gmsr.created_at DESC
        ");
        
        if ($get_reward_history->num_rows > 0) {
            while ($reward = $get_reward_history->fetch_assoc()) {
                $reward_history[] = $reward;
            }
        }
    }
    
    // Get user's assigned review tasks (for my-reviews view)
    if ($view == 'my-reviews') {
        // Pagination settings
        $per_page = 9; // 9 cards per page
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($current_page - 1) * $per_page;
        
        // Get total count for pagination
        $count_query = $db->query("
            SELECT COUNT(*) as total
            FROM google_maps_review_sub_requests gmsr
            LEFT JOIN google_maps_review_requests gmr ON gmsr.parent_request_id = gmr.request_id
            WHERE gmsr.assigned_user_id = '{$user->_data['user_id']}'
        ");
        $total_tasks = $count_query->fetch_assoc()['total'];
        $total_pages = ceil($total_tasks / $per_page);
        
        // Get paginated tasks (bao gồm generated_review_content)
        $get_assigned_tasks = $db->query("
            SELECT gmsr.*, gmr.requester_user_id, gmr.place_name as parent_place_name, gmr.place_address as parent_place_address, gmr.place_url, gmsr.generated_review_content
            FROM google_maps_review_sub_requests gmsr
            LEFT JOIN google_maps_review_requests gmr ON gmsr.parent_request_id = gmr.request_id
            WHERE gmsr.assigned_user_id = '{$user->_data['user_id']}'
            ORDER BY gmsr.assigned_at DESC
            LIMIT {$per_page} OFFSET {$offset}
        ");
        
        if ($get_assigned_tasks->num_rows > 0) {
            while ($task = $get_assigned_tasks->fetch_assoc()) {
                $assigned_tasks[] = $task;
            }
        }
    }
    
} catch (Exception $e) {
    error_log("Error getting user data: " . $e->getMessage());
}


// assign variables
$smarty->assign('user_requests', $user_requests);
$smarty->assign('user_reviews', $user_reviews);
$smarty->assign('user_earnings', $user_earnings);
$smarty->assign('user_wallet_balance', $user_wallet_balance);
$smarty->assign('assigned_tasks', $assigned_tasks);
$smarty->assign('reward_history', $reward_history);
$smarty->assign('view', $view);

// Pagination variables
if ($view == 'my-reviews') {
    $smarty->assign('current_page', $current_page);
    $smarty->assign('total_pages', $total_pages);
    $smarty->assign('total_tasks', $total_tasks);
}

// Display template based on view
if ($view == 'reward-history') {
    $smarty->display('reward-history.tpl');
} else {
    // page footer
    page_footer('google-maps-reviews');
}

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
        // Get and escape input data
        $place_name = $db->real_escape_string(trim($_POST['place_name'] ?? ''));
        $place_address = $db->real_escape_string(trim($_POST['place_address'] ?? ''));
        $place_url = $db->real_escape_string(trim($_POST['place_url'] ?? ''));
        $review_template = $db->real_escape_string(trim($_POST['review_template'] ?? ''));
        $reward_amount = 10000; // Chi phí cho người tạo chiến dịch
        $reviewer_reward = 5000; // Tiền thưởng cho người đánh giá
        $target_reviews = intval($_POST['target_reviews'] ?? 1);
        $expires_at = trim($_POST['expires_at'] ?? '');
        
        // Validate required fields
        if (empty($place_name) || empty($place_address)) {
            echo json_encode(array('error' => 'Vui lòng điền đầy đủ thông tin bắt buộc'));
            return;
        }
        
        // Validate place_url (bắt buộc)
        if (empty($place_url)) {
            echo json_encode(array('error' => 'Vui lòng nhập URL địa điểm Google Maps'));
            return;
        }
        
        // Validate target_reviews
        $target_reviews = intval($target_reviews);
        if ($target_reviews < 1 || $target_reviews > 100) {
            echo json_encode(array('error' => 'Số lượng đánh giá phải từ 1 đến 100'));
            return;
        }
        
        // Validate expires_at
        if (empty($expires_at)) {
            echo json_encode(array('error' => 'Vui lòng chọn thời gian hết hạn'));
            return;
        }
        
        $expires_timestamp = strtotime($expires_at);
        if ($expires_timestamp <= time()) {
            echo json_encode(array('error' => 'Thời gian hết hạn phải là thời điểm trong tương lai'));
            return;
        }
        
        // Calculate total budget
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
        
        // Start transaction
        $db->query("START TRANSACTION");
        
        // Check số dư TRONG transaction để tránh race condition
        $check_balance_again = $db->query("
            SELECT user_wallet_balance 
            FROM users 
            WHERE user_id = '{$user->_data['user_id']}' 
            FOR UPDATE
        ");
        
        if ($check_balance_again && $check_balance_again->num_rows > 0) {
            $current_balance = $check_balance_again->fetch_assoc()['user_wallet_balance'];
            
            if ($current_balance < $total_budget) {
                $db->query("ROLLBACK");
                echo json_encode([
                    'error' => 'Số dư không đủ! Cần: ' . number_format($total_budget, 0, ',', '.') . ' VNĐ, Hiện có: ' . number_format($current_balance, 0, ',', '.') . ' VNĐ',
                    'required_amount' => $total_budget,
                    'current_balance' => $current_balance
                ]);
                return;
            }
        }
        
        // Deduct balance from user (chỉ trừ nếu đủ tiền)
        $deduct_balance = $db->query("
            UPDATE users 
            SET user_wallet_balance = user_wallet_balance - {$total_budget} 
            WHERE user_id = '{$user->_data['user_id']}'
            AND user_wallet_balance >= {$total_budget}
        ");
        
        if (!$deduct_balance || $db->affected_rows == 0) {
            $db->query("ROLLBACK");
            throw new Exception("Không thể trừ tiền. Số dư có thể đã thay đổi hoặc không đủ.");
        }
        
        // Tạo lịch sử giao dịch trong users_wallets_transactions
        $transaction_description = "Tạo chiến dịch Google Maps: {$place_name} ({$target_reviews} đánh giá)";
        $create_transaction = $db->query("
            INSERT INTO users_wallets_transactions 
            (user_id, amount, type, description, time) 
            VALUES 
            ('{$user->_data['user_id']}', '{$total_budget}', 'withdraw', '{$transaction_description}', CONVERT_TZ(NOW(), '+00:00', '+07:00'))
        ");
        
        if (!$create_transaction) {
            throw new Exception("Lỗi tạo lịch sử giao dịch: " . $db->error);
        }
        
        
        // Create main request (chiến dịch mẹ) với review_template (đã escape ở trên)
        $insert_main = $db->query("
            INSERT INTO google_maps_review_requests 
            (requester_user_id, google_place_id, place_name, place_address, place_url, review_template,
             reward_amount, target_reviews, total_budget, expires_at, status, created_at, updated_at)
            VALUES 
            ('{$user->_data['user_id']}', '', '{$place_name}', '{$place_address}', '{$place_url}', '{$review_template}',
             '{$reward_amount}', '{$target_reviews}', '{$total_budget}', '{$expires_at}', 'active', CONVERT_TZ(NOW(), '+00:00', '+07:00'), CONVERT_TZ(NOW(), '+00:00', '+07:00'))
        ");
        
        if (!$insert_main) {
            throw new Exception("Lỗi tạo chiến dịch mẹ: " . $db->error);
        }
        
        $request_id = $db->insert_id;
        
        // Get OpenAI API key for generating reviews
        $openai_api_key = getOpenAIAPIKey();
        
        // Create sub-requests (chiến dịch con) với tiền thưởng 5k cho người đánh giá
        for ($i = 0; $i < $target_reviews; $i++) {
            $generated_content = '';
            
            // Generate unique review content using GPT nếu có API key và review template
            if (!empty($openai_api_key) && !empty($review_template)) {
                $gpt_result = generateReviewContent($openai_api_key, $place_name, $place_address, $review_template);
                
                if ($gpt_result['success']) {
                    $generated_content = $gpt_result['content'];
                    error_log("GPT generated review #{$i}: " . mb_strlen($generated_content, 'UTF-8') . " chars");
                } else {
                    error_log("GPT generation failed for sub-request #{$i}: " . $gpt_result['error']);
                }
                
                // Ngủ một chút giữa các request để tránh rate limit
                if ($i < $target_reviews - 1) {
                    usleep(500000); // 0.5 giây
                }
            }
            
            $generated_content_escaped = $db->real_escape_string($generated_content);
            
            $insert_sub = $db->query("
                INSERT INTO google_maps_review_sub_requests 
                (parent_request_id, google_place_id, place_name, place_address, place_url, generated_review_content,
                 reward_amount, expires_at, status, created_at, updated_at)
                VALUES 
                ('{$request_id}', '', '{$place_name}', '{$place_address}', 
                 '{$place_url}', '{$generated_content_escaped}', '{$reviewer_reward}', '{$expires_at}', 'available', CONVERT_TZ(NOW(), '+00:00', '+07:00'), CONVERT_TZ(NOW(), '+00:00', '+07:00'))
            ");
            
            if (!$insert_sub) {
                throw new Exception("Lỗi tạo chiến dịch con: " . $db->error);
            }
        }
        
        
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
        
        // Get requester_user_id from parent campaign
        $get_requester = $db->query("
            SELECT requester_user_id FROM google_maps_review_requests 
            WHERE request_id = '{$task['parent_request_id']}'
        ");
        
        if ($get_requester->num_rows == 0) {
            echo json_encode(array('error' => 'Campaign not found'));
            return;
        }
        
        $requester_data = $get_requester->fetch_assoc();
        $requester_user_id = $requester_data['requester_user_id'];
        
        // Assign task to user
        $update_result = $db->query("
            UPDATE google_maps_review_sub_requests 
            SET assigned_user_id = '{$user->_data['user_id']}', 
                assigned_at = CONVERT_TZ(NOW(), '+00:00', '+07:00'), 
                status = 'assigned',
                updated_at = CONVERT_TZ(NOW(), '+00:00', '+07:00')
            WHERE sub_request_id = '{$sub_request_id}' AND status = 'available'
        ");
        
        if (!$update_result) {
            throw new Exception("Database update failed: " . $db->error);
        }
        
        $affected_rows = $db->affected_rows;
        
        if ($affected_rows == 0) {
            echo json_encode(array('error' => 'Task no longer available or already assigned'));
            return;
        }
        
        // Insert tracking record (chỉ insert lần đầu, không update nếu đã tồn tại)
        $check_tracking = $db->query("
            SELECT tracking_id FROM google_maps_user_requester_tracking 
            WHERE user_id = '{$user->_data['user_id']}' 
            AND requester_user_id = '{$requester_user_id}'
        ");
        
        if ($check_tracking->num_rows == 0) {
            // Chưa có record → Insert mới
            $insert_tracking = $db->query("
                INSERT INTO google_maps_user_requester_tracking 
                (user_id, requester_user_id, first_task_id, first_task_date, created_at)
                VALUES 
                ('{$user->_data['user_id']}', '{$requester_user_id}', '{$sub_request_id}', CONVERT_TZ(NOW(), '+00:00', '+07:00'), CONVERT_TZ(NOW(), '+00:00', '+07:00'))
            ");
            
            if (!$insert_tracking) {
                error_log("Failed to insert tracking record: " . $db->error);
                // Không throw exception vì task đã được assign thành công
            } else {
                error_log("Tracking inserted: User {$user->_data['user_id']} - Shop {$requester_user_id}");
            }
        } else {
            error_log("Tracking already exists: User {$user->_data['user_id']} - Shop {$requester_user_id}");
        }
        
        echo json_encode(array('success' => true, 'affected_rows' => $affected_rows));
        
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
        
        // Create review record với đúng schema
        $insert_review = $db->query("
            INSERT INTO google_maps_reviews 
            (sub_request_id, reviewer_user_id, google_place_id, review_text, rating, 
             review_url, screenshot_url, status, created_at, updated_at)
            VALUES 
            ('{$sub_request_id}', '{$user->_data['user_id']}', '{$sub_request['google_place_id']}', 
             '{$review_text}', '{$rating}', '{$review_url}', '{$screenshot_proof}', 
             'pending', CONVERT_TZ(NOW(), '+00:00', '+07:00'), CONVERT_TZ(NOW(), '+00:00', '+07:00'))
        ");
        
        if (!$insert_review) {
            throw new Exception("Lỗi tạo review: " . $db->error);
        }
        
        $review_id = $db->insert_id;
        
        // Cộng tiền thưởng vào ví người dùng
        $reward_amount = $sub_request['reward_amount'];
        $add_balance = $db->query("
            UPDATE users 
            SET user_wallet_balance = user_wallet_balance + {$reward_amount} 
            WHERE user_id = '{$user->_data['user_id']}'
        ");
        
        if (!$add_balance) {
            throw new Exception("Lỗi cộng tiền thưởng: " . $db->error);
        }
        
        // Tạo lịch sử giao dịch cho người đánh giá
        $reward_description = "Thưởng đánh giá Google Maps: {$sub_request['place_name']}";
        $create_reward_transaction = $db->query("
            INSERT INTO users_wallets_transactions 
            (user_id, amount, type, description, time) 
            VALUES 
            ('{$user->_data['user_id']}', '{$reward_amount}', 'recharge', '{$reward_description}', CONVERT_TZ(NOW(), '+00:00', '+07:00'))
        ");
        
        if (!$create_reward_transaction) {
            throw new Exception("Lỗi tạo lịch sử giao dịch thưởng: " . $db->error);
        }
        
        // Update sub-request status
        $db->query("
            UPDATE google_maps_review_sub_requests 
            SET status = 'completed', updated_at = CONVERT_TZ(NOW(), '+00:00', '+07:00')
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
