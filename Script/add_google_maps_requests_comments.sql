-- ========================================
-- THÊM MÔ TẢ CHO CÁC TRƯỜNG TRONG BẢNG google_maps_review_requests
-- ========================================

USE db_mxh;

-- Thêm COMMENT cho bảng google_maps_review_requests (chiến dịch mẹ)
ALTER TABLE `google_maps_review_requests` 
  MODIFY COLUMN `request_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID duy nhất của chiến dịch mẹ',
  MODIFY COLUMN `requester_user_id` int(10) UNSIGNED NOT NULL COMMENT 'ID của user tạo chiến dịch (chủ địa điểm)',
  MODIFY COLUMN `google_place_id` varchar(256) DEFAULT NULL COMMENT 'Place ID của Google Maps (định danh duy nhất của địa điểm)',
  MODIFY COLUMN `place_name` varchar(256) NOT NULL COMMENT 'Tên địa điểm cần viết review (ví dụ: "Nhà hàng ABC")',
  MODIFY COLUMN `place_address` text NOT NULL COMMENT 'Địa chỉ đầy đủ của địa điểm',
  MODIFY COLUMN `place_url` text DEFAULT NULL COMMENT 'URL Google Maps của địa điểm',
  MODIFY COLUMN `reward_amount` decimal(10,2) NOT NULL COMMENT 'Số tiền thưởng cho mỗi review (VNĐ)',
  MODIFY COLUMN `target_reviews` int(10) UNSIGNED NOT NULL COMMENT 'Số lượng review mục tiêu cần đạt được',
  MODIFY COLUMN `total_budget` decimal(10,2) NOT NULL COMMENT 'Tổng ngân sách cho chiến dịch (reward_amount × target_reviews)',
  MODIFY COLUMN `expires_at` datetime NOT NULL COMMENT 'Thời gian hết hạn của chiến dịch',
  MODIFY COLUMN `status` enum('active','completed','cancelled') NOT NULL DEFAULT 'active' COMMENT 'Trạng thái: active=đang chạy, completed=hoàn thành, cancelled=đã hủy',
  MODIFY COLUMN `created_at` datetime NOT NULL COMMENT 'Thời gian tạo chiến dịch',
  MODIFY COLUMN `updated_at` datetime NOT NULL COMMENT 'Thời gian cập nhật chiến dịch gần nhất';

-- Kiểm tra kết quả
SHOW FULL COLUMNS FROM `google_maps_review_requests`;

