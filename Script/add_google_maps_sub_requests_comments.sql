-- ========================================
-- THÊM MÔ TẢ CHO CÁC TRƯỜNG TRONG BẢNG google_maps_review_sub_requests
-- ========================================

USE db_mxh;

-- Thêm COMMENT cho bảng google_maps_review_sub_requests
ALTER TABLE `google_maps_review_sub_requests` 
  MODIFY COLUMN `sub_request_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID duy nhất của yêu cầu con (sub-request)',
  MODIFY COLUMN `parent_request_id` int(10) UNSIGNED NOT NULL COMMENT 'ID của chiến dịch mẹ (liên kết đến google_maps_review_requests)',
  MODIFY COLUMN `assigned_user_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID của user được gán nhiệm vụ viết review',
  MODIFY COLUMN `google_place_id` varchar(256) DEFAULT NULL COMMENT 'Place ID của Google Maps (định danh duy nhất của địa điểm)',
  MODIFY COLUMN `place_name` varchar(256) NOT NULL COMMENT 'Tên địa điểm cần viết review (ví dụ: "Nhà hàng ABC")',
  MODIFY COLUMN `place_address` text NOT NULL COMMENT 'Địa chỉ đầy đủ của địa điểm',
  MODIFY COLUMN `place_url` text DEFAULT NULL COMMENT 'URL Google Maps của địa điểm để reviewer truy cập',
  MODIFY COLUMN `reward_amount` decimal(10,2) NOT NULL COMMENT 'Số tiền thưởng cho 1 review (VNĐ)',
  MODIFY COLUMN `expires_at` datetime NOT NULL COMMENT 'Thời gian hết hạn của nhiệm vụ',
  MODIFY COLUMN `status` enum('available','assigned','completed','verified','expired') NOT NULL DEFAULT 'available' COMMENT 'Trạng thái: available=chưa gán, assigned=đã gán, completed=đã hoàn thành, verified=đã xác minh, expired=hết hạn',
  MODIFY COLUMN `assigned_at` datetime DEFAULT NULL COMMENT 'Thời điểm nhiệm vụ được gán cho user',
  MODIFY COLUMN `completed_at` datetime DEFAULT NULL COMMENT 'Thời điểm user hoàn thành nhiệm vụ (submit proof)',
  MODIFY COLUMN `verified_at` datetime DEFAULT NULL COMMENT 'Thời điểm admin xác minh và duyệt review',
  MODIFY COLUMN `verified_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'ID của admin đã xác minh review',
  MODIFY COLUMN `verification_notes` text DEFAULT NULL COMMENT 'Ghi chú của admin khi xác minh (lý do từ chối, comment, v.v.)',
  MODIFY COLUMN `created_at` datetime NOT NULL COMMENT 'Thời gian tạo sub-request',
  MODIFY COLUMN `updated_at` datetime NOT NULL COMMENT 'Thời gian cập nhật sub-request gần nhất';

-- Kiểm tra kết quả
SHOW FULL COLUMNS FROM `google_maps_review_sub_requests`;

