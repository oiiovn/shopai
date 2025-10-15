# 🔄 Google Maps Timeout Handler System

## 📋 Tổng quan

Hệ thống tự động xử lý timeout và tạo lại chiến dịch con cho Google Maps Reviews để đảm bảo tỷ lệ hoàn thành cao mà không ảnh hưởng toàn bộ chiến dịch mẹ.

## 🎯 Chức năng chính

### 1. **Timeout khi đã nhận nhiệm vụ (Assigned Timeout)**

**Vấn đề:** User nhận nhiệm vụ nhưng không hoàn thành trong thời gian quy định.

**Giải pháp:**
- ⏱️ Sau **30 phút** từ `assigned_at` mà vẫn ở trạng thái `assigned`
- ❌ Chuyển nhiệm vụ cũ sang status `timeout`
- 🔗 Tách khỏi chiến dịch mẹ (set `parent_request_id = NULL`)
- ✨ Tạo chiến dịch con mới với status `available`
- 📝 Ghi chú: "Không hoàn thành trong 30 phút - Timeout"

**Timeline:**
```
User nhận task → 30 phút → Vẫn "assigned" → Chuyển "timeout" + Tạo task mới
```

### 2. **Xác minh thất bại (Failed Verification)**

**Vấn đề:** User submit proof nhưng bị phát hiện lấy review của người khác hoặc xác minh thất bại.

**Giải pháp:**
- ⏱️ Sau **30 phút** từ `completed_at` 
- ❌ Nếu status là `expired` hoặc có ghi chú "Sử dụng đánh giá của người khác"
- 🔄 Chuyển nhiệm vụ cũ sang status `verification_failed`
- 🔗 Tách khỏi chiến dịch mẹ (set `parent_request_id = NULL`)
- ✨ Tạo chiến dịch con mới để người khác nhận
- 📝 Ghi chú: "Tách khỏi chiến dịch mẹ và tạo nhiệm vụ thay thế"

**Timeline:**
```
Submit proof → GPT verify failed → 30 phút → Chuyển "verification_failed" + Tạo task mới
```

### 3. **Cập nhật trạng thái chiến dịch mẹ**

- ✅ Tự động đánh dấu `completed` khi đủ số lượng review đã verified
- 📊 Không bị ảnh hưởng bởi các task timeout/failed (vì đã tách khỏi parent)

## 📊 Các Status mới

| Status | Ý nghĩa | Khi nào xảy ra |
|--------|---------|----------------|
| `timeout` | Không hoàn thành trong 30 phút | User nhận task nhưng không submit proof sau 30p |
| `verification_failed` | Xác minh thất bại | GPT phát hiện lấy review người khác hoặc sai sót |

## 🗄️ Thay đổi Database

### Cấu trúc mới:

```sql
-- parent_request_id cho phép NULL
parent_request_id int(10) UNSIGNED DEFAULT NULL

-- Status enum mới
status enum(
    'available',
    'assigned',
    'completed',
    'verified',
    'expired',
    'timeout',              -- MỚI
    'verification_failed'   -- MỚI
)

-- Foreign key với ON DELETE SET NULL
CONSTRAINT `fk_sub_parent` 
FOREIGN KEY (`parent_request_id`) 
REFERENCES `google_maps_review_requests`(`request_id`) 
ON DELETE SET NULL
```

## 🚀 Cài đặt

### Bước 1: Chạy migration database

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script
/Applications/XAMPP/xamppfiles/bin/mysql -u root < migrate_google_maps_allow_null_parent.sql
```

### Bước 2: Setup cron job

```bash
chmod +x setup_google_maps_timeout_cron.sh
./setup_google_maps_timeout_cron.sh
```

### Bước 3: Kiểm tra cron job

```bash
crontab -l | grep google-maps-timeout
```

Kết quả mong đợi:
```
*/5 * * * * /Applications/XAMPP/xamppfiles/bin/php /path/to/cron-google-maps-timeout-handler.php >> /path/to/logs/google_maps_timeout_handler.log 2>&1
```

## 📝 Log Files

**Vị trí:** `Script/logs/google_maps_timeout_handler.log`

**Nội dung log:**
```
[2025-10-09 14:35:00] Starting Google Maps Timeout Handler Cron Job
[2025-10-09 14:35:00] Database connected
[2025-10-09 14:35:00] Checking assigned tasks timeout...
Found 2 assigned tasks with timeout

Processing timeout assigned task #123:
  - Parent: #45
  - Place: Nhà hàng Phở Việt
  - Assigned to user: 78
  - Minutes since assigned: 35
  ✓ Updated old task to timeout status
  ✓ Created new replacement task #456
  ✓ Transaction committed successfully

[2025-10-09 14:35:01] Checking failed verification tasks...
Found 1 failed verification tasks
...
```

## 🔍 Monitoring

### Kiểm tra các task timeout

```sql
SELECT 
    sub_request_id,
    place_name,
    status,
    assigned_at,
    TIMESTAMPDIFF(MINUTE, assigned_at, NOW()) as minutes_timeout
FROM google_maps_review_sub_requests
WHERE status = 'timeout'
ORDER BY assigned_at DESC
LIMIT 10;
```

### Kiểm tra các task verification failed

```sql
SELECT 
    sub_request_id,
    place_name,
    status,
    verification_notes,
    completed_at
FROM google_maps_review_sub_requests
WHERE status = 'verification_failed'
ORDER BY completed_at DESC
LIMIT 10;
```

### Thống kê hiệu quả

```sql
SELECT 
    DATE(created_at) as date,
    COUNT(*) as total_tasks,
    SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified,
    SUM(CASE WHEN status = 'timeout' THEN 1 ELSE 0 END) as timeout,
    SUM(CASE WHEN status = 'verification_failed' THEN 1 ELSE 0 END) as failed,
    ROUND(SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) as success_rate
FROM google_maps_review_sub_requests
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
GROUP BY DATE(created_at)
ORDER BY date DESC;
```

## 🎯 Lợi ích

1. ✅ **Tăng tỷ lệ hoàn thành:** Task timeout sẽ được tạo lại tự động
2. ✅ **Không ảnh hưởng chiến dịch mẹ:** Task failed được tách ra khỏi parent
3. ✅ **Công bằng hơn:** User không hoàn thành sẽ bị timeout, người khác có cơ hội nhận
4. ✅ **Tự động hóa:** Không cần admin can thiệp thủ công
5. ✅ **Tracking tốt hơn:** Log chi tiết mọi thay đổi

## 🛠️ Troubleshooting

### Cron job không chạy

```bash
# Kiểm tra cron service
sudo launchctl list | grep cron

# Xem log
tail -f Script/logs/google_maps_timeout_handler.log

# Test chạy thủ công
/Applications/XAMPP/xamppfiles/bin/php Script/cron-google-maps-timeout-handler.php
```

### Task không được tạo lại

- Kiểm tra chiến dịch mẹ còn active không (`gmr.status = 'active'`)
- Kiểm tra chiến dịch mẹ chưa hết hạn (`gmr.expires_at > NOW()`)
- Xem log để biết lỗi cụ thể

## 📞 Support

Nếu có vấn đề, kiểm tra:
1. Log file: `logs/google_maps_timeout_handler.log`
2. Database: Xem các query ở trên
3. Crontab: `crontab -l`

---

**Cập nhật lần cuối:** 2025-10-09
**Version:** 1.0.0

