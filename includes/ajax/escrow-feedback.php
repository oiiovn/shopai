<?php

/**
 * ajax -> escrow-feedback
 * Gửi phản hồi Giao dịch trung gian: quan tâm (interest) hoặc góp ý (feedback)
 */

require('../../bootstrap.php');

// Không gọi is_ajax() để tránh lỗi khi proxy/host xóa header X-Requested-With trên production
if (!$user->_logged_in) {
  return_json(['error' => true, 'message' => __('Vui lòng đăng nhập để gửi phản hồi.')]);
}

$type = isset($_POST['type']) ? trim($_POST['type']) : '';
if (!in_array($type, ['interest', 'feedback'], true)) {
  return_json(['error' => true, 'message' => __('Loại phản hồi không hợp lệ.')]);
}

try {
  global $db;
  $db->query("
    CREATE TABLE IF NOT EXISTS escrow_feedback (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      user_id INT UNSIGNED NOT NULL,
      type ENUM('interest','feedback') NOT NULL,
      message TEXT NULL,
      created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      INDEX idx_user_id (user_id),
      INDEX idx_type (type),
      INDEX idx_created (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
  ");

  $message = $type === 'feedback' && isset($_POST['message']) ? trim($_POST['message']) : null;
  if ($message !== null && $message !== '') {
    $db->query(sprintf(
      "INSERT INTO escrow_feedback (user_id, type, message) VALUES (%s, %s, %s)",
      secure($user->_data['user_id'], 'int'),
      secure($type, 'string'),
      secure($message, 'string')
    ));
  } else {
    $db->query(sprintf(
      "INSERT INTO escrow_feedback (user_id, type) VALUES (%s, %s)",
      secure($user->_data['user_id'], 'int'),
      secure($type, 'string')
    ));
  }

  $msg = $type === 'interest' ? __('Cảm ơn bạn đã quan tâm! Chúng tôi sẽ thông báo khi tính năng ra mắt.') : __('Cảm ơn bạn đã góp ý!');
  return_json(['success' => true, 'message' => $msg]);
} catch (Exception $e) {
  return_json(['error' => true, 'message' => __('Có lỗi. Vui lòng thử lại sau.')]);
}
