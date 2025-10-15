# Hướng dẫn cài đặt Cron Job cho Bank Transaction System

## Tổng quan
Cron job này sẽ tự động kiểm tra và xử lý các giao dịch ngân hàng mới mỗi 1 phút.

## Cài đặt

### 1. Cấp quyền thực thi cho script
```bash
chmod +x /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/cron-bank-transactions-cli.php
```

### 2. Cài đặt cron job
```bash
# Mở crontab editor
crontab -e

# Thêm dòng sau vào crontab (chạy mỗi 1 phút):
* * * * * /usr/bin/php /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/cron-bank-transactions-cli.php >/dev/null 2>&1

# Hoặc với logging chi tiết:
* * * * * /usr/bin/php /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/cron-bank-transactions-cli.php >> /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/logs/cron.log 2>&1
```

### 3. Kiểm tra cron job
```bash
# Xem danh sách cron jobs
crontab -l

# Kiểm tra log
tail -f /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/logs/cron-bank-transactions.log
```

## Các tần suất khác

- **Mỗi phút**: `* * * * *`
- **Mỗi 5 phút**: `*/5 * * * *`
- **Mỗi 10 phút**: `*/10 * * * *`
- **Mỗi 30 phút**: `*/30 * * * *`
- **Mỗi giờ**: `0 * * * *`
- **Mỗi ngày lúc 2:00 AM**: `0 2 * * *`

## Chức năng

Cron job sẽ:
1. Tìm tất cả giao dịch có status = 'pending' trong bảng `bank_transactions`
2. Cập nhật status thành 'matched'
3. Cộng số tiền vào balance của user
4. Ghi log vào bảng `balance_transactions`
5. Ghi log chi tiết vào file log

## Log Files

- **Cron log**: `/Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/logs/cron-bank-transactions.log`
- **PHP error log**: `/Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/logs/php-errors.log`

## Troubleshooting

### Kiểm tra cron job có chạy không
```bash
# Xem log gần nhất
tail -f /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/logs/cron-bank-transactions.log

# Kiểm tra process
ps aux | grep cron
```

### Test manual
```bash
# Chạy thủ công để test
php /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/cron-bank-transactions-cli.php
```

### Kiểm tra database
```bash
# Xem giao dịch pending
mysql -u root -P 3307 db_mxh -e "SELECT * FROM bank_transactions WHERE status = 'pending';"

# Xem balance_transactions
mysql -u root -P 3307 db_mxh -e "SELECT * FROM balance_transactions ORDER BY created_at DESC LIMIT 10;"
```

## Lưu ý

- Đảm bảo MySQL service đang chạy
- Đảm bảo có quyền ghi vào thư mục logs
- Cron job sử dụng MySQL command line nên cần cài đặt mysql client
- Script sẽ tự động tạo thư mục logs nếu chưa có
