<?php
/**
 * Submit Proof for Google Maps Review Task
 * API endpoint để user gửi bằng chứng đánh giá
 */

// Include system files
require_once('bootloader.php');

// Check if user is logged in
if (!$user->_logged_in) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get sub_request_id from URL or POST data
$sub_request_id = isset($_GET['id']) ? (int)$_GET['id'] : (int)$_POST['sub_request_id'];

if (!$sub_request_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing sub_request_id']);
    exit;
}

try {
    // Verify task belongs to user and is in 'assigned' status
    $check_task = $db->query("
        SELECT gmsr.*, gmr.place_name, gmr.place_address, gmr.reward_amount
        FROM google_maps_review_sub_requests gmsr
        LEFT JOIN google_maps_review_requests gmr ON gmsr.parent_request_id = gmr.request_id
        WHERE gmsr.sub_request_id = '{$sub_request_id}' 
        AND gmsr.assigned_user_id = '{$user->_data['user_id']}'
        AND gmsr.status = 'assigned'
    ");
    
    if ($check_task->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Task not found or not available for submission']);
        exit;
    }
    
    $task = $check_task->fetch_assoc();
    
    // Validate required fields
    if (empty($_POST['review_link'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Review link is required']);
        exit;
    }
    
    // Validate uploaded image
    if (!isset($_FILES['proof_image']) || $_FILES['proof_image']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['error' => 'Proof image is required']);
        exit;
    }
    
    $review_link = trim($_POST['review_link']);
    $proof_image = $_FILES['proof_image'];
    
    // Validate image file
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!in_array($proof_image['type'], $allowed_types)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid image type. Only JPEG, PNG, GIF allowed']);
        exit;
    }
    
    // Validate image size (max 5MB)
    if ($proof_image['size'] > 5 * 1024 * 1024) {
        http_response_code(400);
        echo json_encode(['error' => 'Image too large. Maximum 5MB allowed']);
        exit;
    }
    
    // Create upload directory if not exists
    $upload_dir = $system['system_uploads'] . '/proof_images/' . date('Y/m/');
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Generate unique filename
    $file_extension = pathinfo($proof_image['name'], PATHINFO_EXTENSION);
    $filename = 'proof_' . $sub_request_id . '_' . time() . '_' . uniqid() . '.' . $file_extension;
    $file_path = $upload_dir . $filename;
    
    // Move uploaded file
    if (!move_uploaded_file($proof_image['tmp_name'], $file_path)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to upload image']);
        exit;
    }
    
    // Update task status to 'completed' and save proof data
    $proof_data = json_encode([
        'review_link' => $review_link,
        'image_path' => $file_path,
        'submitted_at' => date('Y-m-d H:i:s'),
        'submitted_by' => $user->_data['user_id']
    ]);
    
    $update_query = $db->query("
        UPDATE google_maps_review_sub_requests 
        SET status = 'completed',
            completed_at = NOW(),
            proof_data = '{$proof_data}'
        WHERE sub_request_id = '{$sub_request_id}'
    ");
    
    if (!$update_query) {
        // Delete uploaded file if database update fails
        unlink($file_path);
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save proof data']);
        exit;
    }
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Proof submitted successfully. Your submission is being reviewed.',
        'sub_request_id' => $sub_request_id,
        'status' => 'completed'
    ]);
    
} catch (Exception $e) {
    error_log("Submit proof error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
?>
