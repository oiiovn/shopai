# 🚀 Hướng Dẫn Deploy TCSN lên Hosting

## 📋 Checklist Trước Khi Deploy

### 1. **Cập nhật cấu hình cho Production**
- [ ] Thay đổi `SYS_URL` trong `Script/includes/config.php`
- [ ] Cập nhật thông tin database production
- [ ] Bật `DEBUGGING = false`
- [ ] Kiểm tra file `.htaccess`

### 2. **Database Setup**
- [ ] Tạo database mới trên hosting
- [ ] Import file `Script/create_tables.sql`
- [ ] Import file `Script/page_business_types_system.sql`
- [ ] Import file `Script/setup_shop_ai_recharge_tables.sql`

### 3. **File Upload**
- [ ] Upload toàn bộ thư mục `Script/` lên hosting
- [ ] Set permissions cho thư mục `content/uploads/` (755)
- [ ] Set permissions cho thư mục `content/cache/` (755)

### 4. **Cron Jobs Setup**
- [ ] Setup cron job cho `cron-shop-ai-recharge-checker.php`
- [ ] Setup cron job cho `cron-bank-transactions.php`
- [ ] Kiểm tra timezone server

## 🔧 Cấu Hình Production

### File: `Script/includes/config.php`
```php
// ** MySQL settings ** //
define('DB_NAME', 'your_production_db_name');
define('DB_USER', 'your_production_db_user');
define('DB_PASSWORD', 'your_production_db_password');
define('DB_HOST', 'localhost'); // hoặc IP server
define('DB_PORT', '3306'); // port mặc định

// ** System URL ** //
define('SYS_URL', 'https://yourdomain.com'); // URL production

// ** Debugging ** //
define('DEBUGGING', false); // Tắt debug cho production
```

## 📁 Cấu Trúc File Cần Upload

```
public_html/
├── Script/
│   ├── includes/
│   │   └── config.php (cập nhật cho production)
│   ├── content/
│   │   ├── uploads/ (set permission 755)
│   │   └── cache/ (set permission 755)
│   ├── .htaccess
│   └── ... (tất cả file khác)
```

## 🗄️ Database Migration

### 1. Tạo Database
```sql
CREATE DATABASE your_production_db_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Import Tables
```bash
# Import cấu trúc cơ bản
mysql -u username -p your_production_db_name < Script/create_tables.sql

# Import Page Business Types System
mysql -u username -p your_production_db_name < Script/page_business_types_system.sql

# Import Shop-AI Tables
mysql -u username -p your_production_db_name < Script/setup_shop_ai_recharge_tables.sql
```

## ⏰ Cron Jobs Setup

### 1. Shop-AI Recharge Checker
```bash
# Chạy mỗi 5 phút
*/5 * * * * /usr/bin/php /path/to/Script/cron-shop-ai-recharge-checker.php
```

### 2. Bank Transactions Sync
```bash
# Chạy mỗi 10 phút
*/10 * * * * /usr/bin/php /path/to/Script/cron-bank-transactions.php
```

## 🔐 Security Checklist

- [ ] Đổi mật khẩu admin mặc định
- [ ] Cập nhật API keys (checkso.pro, Pay2S)
- [ ] Kiểm tra file permissions
- [ ] Enable SSL/HTTPS
- [ ] Cấu hình firewall

## 🧪 Testing Sau Deploy

- [ ] Test đăng nhập/đăng ký
- [ ] Test Shop-AI check số điện thoại
- [ ] Test nạp tiền QR code
- [ ] Test Page Business Types
- [ ] Test Menu trực tuyến
- [ ] Test cron jobs

## 📞 Support

Nếu gặp vấn đề, kiểm tra:
1. Error logs trong hosting
2. Database connection
3. File permissions
4. Cron job status
