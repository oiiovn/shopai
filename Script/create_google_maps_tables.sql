-- ========================================
-- TẠO BẢNG GOOGLE MAPS REVIEWS
-- ========================================

USE db_mxh;

-- Tạo bảng google_maps_review_requests (chiến dịch mẹ)
CREATE TABLE IF NOT EXISTS `google_maps_review_requests` (
  `request_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID duy nhất của chiến dịch mẹ',
  `requester_user_id` int(10) UNSIGNED NOT NULL COMMENT 'ID của user tạo chiến dịch (chủ địa điểm)',
  `google_place_id` varchar(256) DEFAULT NULL COMMENT 'Place ID của Google Maps (định danh duy nhất của địa điểm)',
  `place_name` varchar(256) NOT NULL COMMENT 'Tên địa điểm cần viết review (ví dụ: "Nhà hàng ABC")',
  `place_address` text NOT NULL COMMENT 'Địa chỉ đầy đủ của địa điểm',
  `place_url` text DEFAULT NULL COMMENT 'URL Google Maps của địa điểm',
  `reward_amount` decimal(10,2) NOT NULL COMMENT 'Số tiền thưởng cho mỗi review (VNĐ)',
  `target_reviews` int(10) UNSIGNED NOT NULL COMMENT 'Số lượng review mục tiêu cần đạt được',
  `total_budget` decimal(10,2) NOT NULL COMMENT 'Tổng ngân sách cho chiến dịch (reward_amount × target_reviews)',
  `expires_at` datetime NOT NULL COMMENT 'Thời gian hết hạn của chiến dịch',
  `status` enum('active','completed','cancelled') NOT NULL DEFAULT 'active' COMMENT 'Trạng thái: active=đang chạy, completed=hoàn thành, cancelled=đã hủy',
  `created_at` datetime NOT NULL COMMENT 'Thời gian tạo chiến dịch',
  `updated_at` datetime NOT NULL COMMENT 'Thời gian cập nhật chiến dịch gần nhất',
  PRIMARY KEY (`request_id`),
  KEY `requester_user_id` (`requester_user_id`),
  KEY `status` (`status`),
  KEY `expires_at` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Tạo bảng google_maps_review_sub_requests (chiến dịch con)
CREATE TABLE IF NOT EXISTS `google_maps_review_sub_requests` (
  `sub_request_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID duy nhất của yêu cầu con (sub-request)',
  `parent_request_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID của chiến dịch mẹ (liên kết đến google_maps_review_requests) - NULL nếu đã tách khỏi chiến dịch',
  `assigned_user_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID của user được gán nhiệm vụ viết review',
  `google_place_id` varchar(256) DEFAULT NULL COMMENT 'Place ID của Google Maps (định danh duy nhất của địa điểm)',
  `place_name` varchar(256) NOT NULL COMMENT 'Tên địa điểm cần viết review (ví dụ: "Nhà hàng ABC")',
  `place_address` text NOT NULL COMMENT 'Địa chỉ đầy đủ của địa điểm',
  `place_url` text DEFAULT NULL COMMENT 'URL Google Maps của địa điểm để reviewer truy cập',
  `reward_amount` decimal(10,2) NOT NULL COMMENT 'Số tiền thưởng cho 1 review (VNĐ)',
  `expires_at` datetime NOT NULL COMMENT 'Thời gian hết hạn của nhiệm vụ',
  `status` enum('available','assigned','completed','verified','expired','timeout','verification_failed') NOT NULL DEFAULT 'available' COMMENT 'Trạng thái: available=chưa gán, assigned=đã gán, completed=đã hoàn thành, verified=đã xác minh, expired=hết hạn, timeout=không hoàn thành trong 30p, verification_failed=xác minh thất bại',
  `assigned_at` datetime DEFAULT NULL COMMENT 'Thời điểm nhiệm vụ được gán cho user',
  `completed_at` datetime DEFAULT NULL COMMENT 'Thời điểm user hoàn thành nhiệm vụ (submit proof)',
  `verified_at` datetime DEFAULT NULL COMMENT 'Thời điểm admin xác minh và duyệt review',
  `verified_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID của admin đã xác minh review',
  `verification_notes` text DEFAULT NULL COMMENT 'Ghi chú của admin khi xác minh (lý do từ chối, comment, v.v.)',
  `created_at` datetime NOT NULL COMMENT 'Thời gian tạo sub-request',
  `updated_at` datetime NOT NULL COMMENT 'Thời gian cập nhật sub-request gần nhất',
  PRIMARY KEY (`sub_request_id`),
  KEY `parent_request_id` (`parent_request_id`),
  KEY `assigned_user_id` (`assigned_user_id`),
  KEY `status` (`status`),
  KEY `expires_at` (`expires_at`),
  KEY `idx_verified_at` (`verified_at`),
  KEY `idx_verified_by` (`verified_by`),
  CONSTRAINT `fk_sub_parent` FOREIGN KEY (`parent_request_id`) REFERENCES `google_maps_review_requests`(`request_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_sub_assigned` FOREIGN KEY (`assigned_user_id`) REFERENCES `users`(`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;
