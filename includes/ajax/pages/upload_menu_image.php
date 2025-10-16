<?php

/**
 * ajax -> pages -> upload_menu_image
 * Upload ảnh cho menu items
 * 
 * @package Sngine
 * @author Custom Development
 */

// fetch bootstrap
require('../../bootstrap.php');

// check AJAX Request
is_ajax();

// user access
user_access(true);

try {
    
    // check if file was uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception(__("No file uploaded or upload error"));
    }
    
    $file = $_FILES['image'];
    
    // validate file type
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed_types)) {
        throw new Exception(__("Invalid file type. Only JPEG, PNG, GIF and WebP images are allowed"));
    }
    
    // validate file size (max 5MB)
    $max_size = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $max_size) {
        throw new Exception(__("File size too large. Maximum 5MB allowed"));
    }
    
    // generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'menu_' . uniqid() . '_' . time() . '.' . $extension;
    
    // create upload directory if not exists
    $upload_dir = ABSPATH . 'content/uploads/photos/' . date('Y') . '/' . date('m') . '/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $upload_path = $upload_dir . $filename;
    
    // move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
        throw new Exception(__("Failed to save uploaded file"));
    }
    
    // generate URL
    $file_url = $system['system_url'] . '/content/uploads/photos/' . date('Y') . '/' . date('m') . '/' . $filename;
    
    // return success response
    return_json([
        'success' => true,
        'file_url' => $file_url,
        'filename' => $filename
    ]);
    
} catch (Exception $e) {
    return_json(['error' => true, 'message' => $e->getMessage()]);
}

?>
