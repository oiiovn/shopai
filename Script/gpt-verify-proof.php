<?php
/**
 * GPT Verification for Google Maps Review Proof
 * API endpoint để admin trigger xác minh bằng chứng bằng GPT
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include system files
try {
    require_once('bootloader.php');
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'System error: ' . $e->getMessage()]);
    exit;
}

// Debug: Check if variables are loaded
if (!isset($user)) {
    http_response_code(500);
    echo json_encode(['error' => 'User object not loaded']);
    exit;
}

// Check if user is logged in
if (!$user->_logged_in) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied. Please login.']);
    exit;
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Debug: Log POST data
error_log('POST data: ' . print_r($_POST, true));
error_log('FILES data: ' . print_r($_FILES, true));

// Get sub_request_id
$sub_request_id = isset($_POST['sub_request_id']) ? (int)$_POST['sub_request_id'] : 0;

if (!$sub_request_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing sub_request_id', 'post_data' => $_POST]);
    exit;
}

try {
    // Get task details
    $task_query = $db->query("
        SELECT gmsr.*, gmr.place_name, gmr.place_address, gmsr.reward_amount
        FROM google_maps_review_sub_requests gmsr
        LEFT JOIN google_maps_review_requests gmr ON gmsr.parent_request_id = gmr.request_id
        WHERE gmsr.sub_request_id = '{$sub_request_id}'
        AND gmsr.assigned_user_id = '{$user->_data['user_id']}'
        AND gmsr.status IN ('assigned', 'completed')
    ");
    
    if ($task_query->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Task not found or access denied']);
        exit;
    }
    
    $task = $task_query->fetch_assoc();
    
    // Handle file upload if this is a new submission
    if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === UPLOAD_ERR_OK) {
        // Create uploads directory if not exists
        $upload_dir = 'content/uploads/google_maps_proofs/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Generate unique filename
        $file_extension = pathinfo($_FILES['screenshot']['name'], PATHINFO_EXTENSION);
        $filename = 'proof_' . $sub_request_id . '_' . time() . '.' . $file_extension;
        $upload_path = $upload_dir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $upload_path)) {
            // Update task with proof data and mark as completed
            $proof_data = [
                'image_path' => $upload_path,
                'shared_link' => $_POST['shared_link'] ?? '',
                'submitted_at' => date('Y-m-d H:i:s'),
                'submitted_by' => $user->_data['user_id']
            ];
            
            $db->query("
                UPDATE google_maps_review_sub_requests 
                SET 
                    proof_data = '" . json_encode($proof_data) . "',
                    completed_at = NOW()
                WHERE sub_request_id = '{$sub_request_id}'
            ");
            
            $task['proof_data'] = json_encode($proof_data);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to upload image']);
            exit;
        }
    }
    
    if (empty($task['proof_data'])) {
        http_response_code(400);
        echo json_encode(['error' => 'No proof data found. Please upload screenshot first.']);
        exit;
    }
    
    $proof_data = json_decode($task['proof_data'], true);
    
           // Get OpenAI API key from existing function
           include_once('includes/openai-functions.php');
           $openai_api_key = getOpenAIAPIKey();
    
    if (empty($openai_api_key)) {
        http_response_code(500);
        echo json_encode(['error' => 'OpenAI API key not configured']);
        exit;
    }
    
    // Prepare image for OpenAI Vision API
    $image_path = $proof_data['image_path'];
    if (!file_exists($image_path)) {
        http_response_code(400);
        echo json_encode(['error' => 'Proof image not found']);
        exit;
    }
    
    // Convert image to base64
    $image_data = file_get_contents($image_path);
    $image_base64 = base64_encode($image_data);
    $image_mime_type = mime_content_type($image_path);
    
    // Prepare GPT prompt
    $prompt = "Please analyze this Google Maps review image and provide information about what you see.

TASK INFORMATION:
- Place name: {$task['place_name']}
- Address: {$task['place_address']}
- Review link: {$proof_data['shared_link']}

IMPORTANT VERIFICATION CRITERIA:

1. PLACE NAME MATCHING (place_name_match):
   - The screenshot may show PARTIAL place name (ảnh có thể chỉ hiển thị một phần tên)
   - If you find ANY PART of the place name in the image, especially the BEGINNING of the name = VALID
   - Example: Place name is \"Nhà hàng Phở Việt Nam\" but image only shows \"Nhà hàng Phở\" or \"Phở Việt\" = Still VALID ✓
   - The full name doesn't need to be visible because the photo may be cropped
   - Set place_name_match = true if you see at least 3+ words or 50% of the place name

2. REVIEW TIMESTAMP:
   - Look for time like \"X phút trước\", \"X giờ trước\", \"X ngày trước\", \"X tháng trước\", or \"X năm trước\"
   - This is usually shown next to the star rating or reviewer name

Please respond with JSON format (use Vietnamese for text fields):
{
    \"verified\": true/false,
    \"place_name_match\": true/false,
    \"rating_stars\": 1-5,
    \"review_content\": \"nội dung đánh giá\",
    \"review_link_valid\": true/false,
    \"review_time_minutes\": 0-60,
    \"verification_notes\": \"ghi chú xác minh\",
    \"reason\": \"lý do nếu không xác minh được\"
}

Note: For review_time_minutes, convert time to minutes:
- \"vừa xong\" hoặc \"just now\" = 1 minute (mặc định)
- \"X phút trước\" = X minutes
- \"X giờ trước\" = X * 60 minutes  
- \"X ngày trước\" = X * 1440 minutes
- \"X tháng trước\" = X * 43200 minutes
- \"X năm trước\" = X * 525600 minutes

IMPORTANT: Review must be posted within 15 minutes to be valid.

Return only JSON, no additional text.";

    // Call OpenAI Vision API using our function
    $gpt_result = callOpenAIVisionAPI($openai_api_key, $image_base64, $image_mime_type, $prompt);
    $http_code = $gpt_result['http_code'];
    $response = $gpt_result['response'];
    
    if ($http_code !== 200) {
        error_log("OpenAI API error: " . $response);
        http_response_code(500);
        echo json_encode(['error' => 'Failed to verify with OpenAI']);
        exit;
    }
    
    $openai_result = json_decode($response, true);
    $gpt_response = $openai_result['choices'][0]['message']['content'] ?? '';
    
    // Clean GPT response (remove markdown code blocks if any)
    $clean_response = $gpt_response;
    if (strpos($clean_response, '```json') !== false) {
        $clean_response = preg_replace('/```json\s*/', '', $clean_response);
        $clean_response = preg_replace('/```\s*$/', '', $clean_response);
    }
    if (strpos($clean_response, '```') !== false) {
        $clean_response = preg_replace('/```\s*/', '', $clean_response);
    }
    
    // Parse GPT response
    $verification_result = json_decode($clean_response, true);
    
    if (!$verification_result) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to parse GPT response']);
        exit;
    }
    
    // Check time criteria - kiểm tra thời gian đánh giá
    $review_time_minutes = isset($verification_result['review_time_minutes']) ? (int)$verification_result['review_time_minutes'] : 0;
    $time_valid = $review_time_minutes <= 15; // Tiêu chí: dưới 15 phút
    
    // Update database based on verification result
    $new_status = $verification_result['verified'] ? 'completed' : 'expired';
    $verification_notes = $verification_result['verification_notes'] ?? '';
    
    // Kiểm tra URL trùng lặp trước khi xử lý
    $review_link = $proof_data['shared_link'] ?? '';
    if (!empty($review_link)) {
        $check_duplicate = $db->query("
            SELECT sub_request_id 
            FROM google_maps_review_sub_requests 
            WHERE JSON_EXTRACT(proof_data, '$.shared_link') = '{$review_link}'
            AND sub_request_id != '{$sub_request_id}'
            AND status IN ('completed', 'verified')
        ");
        
        if ($check_duplicate->num_rows > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'URL đánh giá này đã được sử dụng trước đó. Vui lòng sử dụng URL khác.',
                'error_type' => 'duplicate_url'
            ]);
            exit;
        }
    }
    
    // Nếu GPT đã verify nhưng thời gian không hợp lệ, đánh dấu thất bại với lý do rõ ràng
    if ($verification_result['verified'] && !$time_valid) {
        $new_status = 'expired';
        $verification_notes = "Sử dụng đánh giá của người khác";
    } elseif (!$verification_result['verified']) {
        $verification_notes = $verification_result['reason'] ?? 'Verification failed';
    }
    
    $update_query = $db->query("
        UPDATE google_maps_review_sub_requests 
        SET status = '{$new_status}',
            verified_at = NOW(),
            verified_by = '{$user->_data['user_id']}',
            verification_notes = '{$verification_notes}',
            gpt_response = '{$gpt_response}',
            gpt_verified = " . ($verification_result['verified'] ? 1 : 0) . ",
            gpt_place_name_match = " . (isset($verification_result['place_name_match']) ? ($verification_result['place_name_match'] ? 1 : 0) : 'NULL') . ",
            gpt_rating_stars = " . (isset($verification_result['rating_stars']) ? $verification_result['rating_stars'] : 'NULL') . ",
            gpt_review_content = '" . (isset($verification_result['review_content']) ? addslashes($verification_result['review_content']) : '') . "',
            gpt_review_link_valid = " . (isset($verification_result['review_link_valid']) ? ($verification_result['review_link_valid'] ? 1 : 0) : 'NULL') . ",
            gpt_review_time_minutes = " . $review_time_minutes . "
        WHERE sub_request_id = '{$sub_request_id}'
    ");
    
    if (!$update_query) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update verification result']);
        exit;
    }
    
    // If verified AND time is valid, add reward to user wallet
    if ($verification_result['verified'] && $time_valid) {
        $reward_amount = $task['reward_amount'];
        $user_id = $task['assigned_user_id'];
        
        // Start transaction for wallet update
        $db->query("START TRANSACTION");
        
        try {
            // Add to user wallet
            $wallet_query = $db->query("
                UPDATE users 
                SET user_wallet_balance = user_wallet_balance + '{$reward_amount}'
                WHERE user_id = '{$user_id}'
            ");
            
            if (!$wallet_query || $db->affected_rows == 0) {
                throw new Exception("Failed to update user wallet balance");
            }
            
            // Create wallet transaction record with HCM time
            $transaction_query = $db->query("
                INSERT INTO users_wallets_transactions 
                (user_id, type, amount, description, time)
                VALUES (
                    '{$user_id}',
                    'recharge',
                    '{$reward_amount}',
                    'Google Maps Review Reward - Task #{$sub_request_id}',
                    CONVERT_TZ(NOW(), '+00:00', '+07:00')
                )
            ");
            
            if (!$transaction_query) {
                throw new Exception("Failed to create wallet transaction record");
            }
            
            // Commit transaction
            $db->query("COMMIT");
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $db->query("ROLLBACK");
            error_log("Wallet update failed: " . $e->getMessage());
        }
    }
    
    // Return verification result
    echo json_encode([
        'success' => true,
        'message' => 'Verification completed',
        'verification_result' => $verification_result,
        'status' => $new_status
    ]);
    
} catch (Exception $e) {
    error_log("GPT verification error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
?>
