-- Tạo bảng QR Code mapping cho Shop-AI Recharge
CREATE TABLE IF NOT EXISTS `qr_code_mapping` (
  `qr_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `qr_code` varchar(50) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text,
  `status` enum('active','used','expired','cancelled') DEFAULT 'active',
  `expires_at` datetime NOT NULL,
  `used_at` datetime NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`qr_id`),
  UNIQUE KEY `qr_code` (`qr_code`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `expires_at` (`expires_at`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng wallet transactions nếu chưa có (cho Shop-AI)
CREATE TABLE IF NOT EXISTS `users_wallets_transactions` (
  `transaction_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` enum('recharge','withdraw','send','receive') NOT NULL DEFAULT 'recharge',
  `amount` float UNSIGNED NOT NULL,
  `description` text,
  `time` datetime NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `user_id` (`user_id`),
  KEY `type` (`type`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Thêm cột user_wallet_balance vào bảng users nếu chưa có
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `user_wallet_balance` decimal(15,2) NOT NULL DEFAULT '0.00' 
AFTER `user_verified`;

-- Tạo index cho cột user_wallet_balance
ALTER TABLE `users` 
ADD INDEX IF NOT EXISTS `user_wallet_balance` (`user_wallet_balance`);

-- Tạo bảng shop-ai recharge sessions để theo dõi phiên nạp tiền
CREATE TABLE IF NOT EXISTS `shop_ai_recharge_sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `qr_code` varchar(50) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `bank_account` varchar(50) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `qr_image_url` text,
  `status` enum('pending','completed','expired','cancelled') DEFAULT 'pending',
  `expires_at` datetime NOT NULL,
  `completed_at` datetime NULL,
  `transaction_id` varchar(100) NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `qr_code` (`qr_code`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `expires_at` (`expires_at`),
  KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo trigger để tự động xóa QR code hết hạn
DELIMITER $$
CREATE EVENT IF NOT EXISTS `cleanup_expired_qr_codes`
ON SCHEDULE EVERY 1 HOUR
DO
BEGIN
  -- Đánh dấu QR codes hết hạn
  UPDATE qr_code_mapping 
  SET status = 'expired' 
  WHERE status = 'active' 
  AND expires_at < NOW();
  
  -- Đánh dấu recharge sessions hết hạn
  UPDATE shop_ai_recharge_sessions 
  SET status = 'expired' 
  WHERE status = 'pending' 
  AND expires_at < NOW();
END$$
DELIMITER ;

-- Bật event scheduler nếu chưa bật
SET GLOBAL event_scheduler = ON;
