USE sho73359_shopqi;

CREATE TABLE IF NOT EXISTS user_bank_accounts (
    account_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    bank_code VARCHAR(20) NOT NULL,
    bank_name VARCHAR(100) NOT NULL,
    account_number VARCHAR(50) NOT NULL,
    account_holder VARCHAR(255) NOT NULL,
    account_nickname VARCHAR(100) DEFAULT NULL,
    is_default TINYINT(1) DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_used_at DATETIME DEFAULT NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_is_default (is_default),
    INDEX idx_status (status),
    UNIQUE KEY unique_user_bank (user_id, bank_code, account_number),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS vietnam_banks (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    bank_code VARCHAR(20) NOT NULL UNIQUE,
    bank_name VARCHAR(100) NOT NULL,
    short_name VARCHAR(50) NOT NULL,
    logo_url VARCHAR(255) DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 999,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO vietnam_banks (bank_code, bank_name, short_name, display_order) VALUES
('970405', 'Ngân hàng Nông nghiệp và Phát triển Nông thôn Việt Nam', 'Agribank', 1),
('970422', 'Ngân hàng Quân đội', 'MBBank', 2),
('970407', 'Ngân hàng Kỹ thương Việt Nam', 'Techcombank', 3),
('970415', 'Ngân hàng Công thương Việt Nam', 'Vietinbank', 4),
('970416', 'Ngân hàng Á Châu', 'ACB', 5),
('970418', 'Ngân hàng Đầu tư và Phát triển Việt Nam', 'BIDV', 6),
('970403', 'Ngân hàng Sài Gòn Thương Tín', 'Sacombank', 7),
('970423', 'Ngân hàng Tiên Phong', 'TPBank', 8),
('970432', 'Ngân hàng Việt Nam Thịnh Vượng', 'VPBank', 9),
('970436', 'Ngân hàng Ngoại thương Việt Nam', 'Vietcombank', 10),
('970441', 'Ngân hàng Quốc tế', 'VIB', 11),
('970443', 'Ngân hàng Sài Gòn - Hà Nội', 'SHB', 12),
('970448', 'Ngân hàng Phương Đông', 'OCB', 13),
('970454', 'Ngân hàng Bản Việt', 'VietCapitalBank', 14),
('970437', 'Ngân hàng Phát triển Thành phố Hồ Chí Minh', 'HDBank', 15),
('970429', 'Ngân hàng Sài Gòn', 'SCB', 16),
('970449', 'Ngân hàng Bưu điện Liên Việt', 'LienVietPostBank', 17),
('970426', 'Ngân hàng Hàng Hải', 'MSB', 18),
('970438', 'Ngân hàng Bảo Việt', 'BaoVietBank', 19),
('970433', 'Ngân hàng Việt Nam Thương Tín', 'VietBank', 20),
('970440', 'Ngân hàng Đông Nam Á', 'SeABank', 21),
('970419', 'Ngân hàng Quốc Dân', 'NCB', 22),
('970406', 'Ngân hàng Đông Á', 'DongABank', 23),
('970409', 'Ngân hàng Bắc Á', 'BacABank', 24),
('970412', 'Ngân hàng Đại Chúng Việt Nam', 'PVcomBank', 25),
('970425', 'Ngân hàng An Bình', 'ABBank', 26),
('970427', 'Ngân hàng Việt Á', 'VietABank', 27),
('970428', 'Ngân hàng Nam Á', 'NamABank', 28),
('970431', 'Ngân hàng Xuất Nhập khẩu Việt Nam', 'Eximbank', 29),
('970452', 'Ngân hàng Kiên Long', 'KienLongBank', 30);
