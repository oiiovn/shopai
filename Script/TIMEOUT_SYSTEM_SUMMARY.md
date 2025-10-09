# ✅ HỆ THỐNG TIMEOUT HANDLER - HOÀN THÀNH

## 🎯 Tổng quan

Đã xây dựng xong hệ thống tự động xử lý timeout và tạo lại chiến dịch con cho Google Maps Reviews.

## 📦 Các file đã tạo

### 1. **Cron Job Handler**
📄 `cron-google-maps-timeout-handler.php`
- Xử lý timeout khi assigned (30 phút)
- Xử lý xác minh thất bại (30 phút)
- Tạo lại chiến dịch con mới
- Tách chiến dịch cũ khỏi chiến dịch mẹ
- Cập nhật trạng thái chiến dịch mẹ

### 2. **Database Migrations**
📄 `migrate_google_maps_allow_null_parent.sql`
- Cho phép `parent_request_id` NULL
- Cập nhật foreign key constraint (ON DELETE SET NULL)
- Thêm 2 status mới: `timeout`, `verification_failed`

📄 `update_google_maps_sub_request_status.sql`
- Cập nhật enum status với 7 giá trị
- Backup dữ liệu trước khi thay đổi

📄 `create_google_maps_tables.sql` (đã cập nhật)
- Schema mới với `parent_request_id` nullable
- Status enum đầy đủ
- Comment chi tiết cho mọi trường

### 3. **Setup Scripts**
📄 `setup_google_maps_timeout_cron.sh`
- Script tự động setup cron job
- Backup crontab trước khi thay đổi
- Kiểm tra file và PHP binary
- Tạo thư mục logs

### 4. **Documentation**
📄 `GOOGLE_MAPS_TIMEOUT_HANDLER_GUIDE.md`
- Hướng dẫn đầy đủ về hệ thống
- Cài đặt và cấu hình
- Monitoring và troubleshooting
- SQL queries để tracking

📄 `TIMEOUT_SYSTEM_SUMMARY.md` (file này)
- Tóm tắt toàn bộ hệ thống

## 🗄️ Thay đổi Database

### Cấu trúc bảng `google_maps_review_sub_requests`

**Trước:**
```sql
parent_request_id int(10) UNSIGNED NOT NULL
status enum('available','assigned','completed','verified','expired')
CONSTRAINT fk_sub_parent ... ON DELETE CASCADE
```

**Sau:**
```sql
parent_request_id int(10) UNSIGNED DEFAULT NULL  -- Cho phép NULL
status enum(
    'available','assigned','completed','verified','expired',
    'timeout',              -- MỚI
    'verification_failed'   -- MỚI
)
CONSTRAINT fk_sub_parent ... ON DELETE SET NULL  -- Changed
```

## 🔄 Workflow

### Timeout khi Assigned (30 phút)

```
User nhận task (assigned)
         ↓
    30 phút trôi qua
         ↓
    Vẫn "assigned"?
         ↓
   [CRON JOB]
         ↓
┌─────────────────────────┐
│ 1. Chuyển status:       │
│    assigned → timeout   │
│                         │
│ 2. Tách khỏi parent:    │
│    parent_id → NULL     │
│                         │
│ 3. Tạo task mới:        │
│    status = available   │
│    parent_id = original │
└─────────────────────────┘
         ↓
   Task mới available
   cho người khác nhận
```

### Xác minh thất bại (30 phút)

```
Submit proof (completed)
         ↓
   GPT verify failed
   (expired/lỗi)
         ↓
    30 phút trôi qua
         ↓
   [CRON JOB]
         ↓
┌────────────────────────────┐
│ 1. Chuyển status:          │
│    expired → verification_ │
│              failed        │
│                            │
│ 2. Tách khỏi parent:       │
│    parent_id → NULL        │
│                            │
│ 3. Tạo task mới:           │
│    status = available      │
│    parent_id = original    │
└────────────────────────────┘
         ↓
   Task mới available
   cho người khác nhận
```

## 🚀 Cài đặt nhanh

```bash
# 1. Chạy migration
cd /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script
/Applications/XAMPP/xamppfiles/bin/mysql -u root < migrate_google_maps_allow_null_parent.sql

# 2. Test cron script
/Applications/XAMPP/xamppfiles/bin/php cron-google-maps-timeout-handler.php

# 3. Setup cron job (tự động chạy mỗi 5 phút)
chmod +x setup_google_maps_timeout_cron.sh
./setup_google_maps_timeout_cron.sh

# 4. Kiểm tra
crontab -l | grep google-maps-timeout
tail -f logs/google_maps_timeout_handler.log
```

## 📊 7 Status trong hệ thống

| Status | Ý nghĩa | Khi nào |
|--------|---------|---------|
| `available` | Chưa có ai nhận | Task mới tạo hoặc task thay thế |
| `assigned` | Đã được nhận | User nhận task |
| `completed` | Đã hoàn thành | User submit proof |
| `verified` | Đã xác minh | Admin/GPT verify OK, đã trả thưởng |
| `expired` | Hết hạn | Quá expires_at hoặc verify failed |
| `timeout` ⭐ | Không hoàn thành | 30p sau assigned vẫn chưa completed |
| `verification_failed` ⭐ | Xác minh thất bại | Lấy review người khác, tách khỏi parent |

## 🎁 Lợi ích

1. ✅ **Tăng tỷ lệ hoàn thành:**
   - Task timeout → Tạo lại → Người khác có cơ hội
   - Campaign không bị ảnh hưởng bởi user không hoàn thành

2. ✅ **Công bằng hơn:**
   - User không hoàn thành → Timeout → Mất quyền
   - User vi phạm → Tách ra → Không ảnh hưởng campaign

3. ✅ **Tự động hóa:**
   - Không cần admin can thiệp thủ công
   - Cron job chạy mỗi 5 phút

4. ✅ **Tracking tốt:**
   - Log chi tiết mọi thay đổi
   - SQL queries để monitoring

5. ✅ **Không ảnh hưởng parent:**
   - Task failed/timeout tách ra (parent_id = NULL)
   - Campaign mẹ chỉ đếm task valid

## 📝 Log Monitoring

### Xem log realtime:
```bash
tail -f logs/google_maps_timeout_handler.log
```

### Sample log output:
```
[2025-10-09 14:35:00] Starting Google Maps Timeout Handler Cron Job
[2025-10-09 14:35:00] Checking assigned tasks timeout...
Found 3 assigned tasks with timeout

Processing timeout assigned task #123:
  - Parent: #45
  - Place: Nhà hàng ABC
  - Minutes since assigned: 35
  ✓ Updated old task to timeout status
  ✓ Created new replacement task #456
  ✓ Transaction committed successfully

SUMMARY:
  - Timeout assigned tasks processed: 3
  - Failed verification tasks processed: 1
  - Parent campaigns completed: 2
```

## 🔍 SQL Queries hữu ích

### Xem task timeout:
```sql
SELECT * FROM google_maps_review_sub_requests 
WHERE status = 'timeout' 
ORDER BY updated_at DESC LIMIT 10;
```

### Xem task verification failed:
```sql
SELECT * FROM google_maps_review_sub_requests 
WHERE status = 'verification_failed' 
ORDER BY updated_at DESC LIMIT 10;
```

### Thống kê theo ngày:
```sql
SELECT 
    DATE(created_at) as date,
    COUNT(*) as total,
    SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) as verified,
    SUM(CASE WHEN status = 'timeout' THEN 1 ELSE 0 END) as timeout,
    SUM(CASE WHEN status = 'verification_failed' THEN 1 ELSE 0 END) as failed
FROM google_maps_review_sub_requests
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
GROUP BY DATE(created_at);
```

## ⚠️ Lưu ý

1. **Cron job chạy mỗi 5 phút**
   - Đủ nhanh để xử lý timeout kịp thời
   - Không quá tải server

2. **Timeout 30 phút**
   - Assigned → 30p → Timeout
   - Completed (failed) → 30p → Verification failed

3. **Transaction safety**
   - Mọi thay đổi đều dùng transaction
   - Rollback nếu có lỗi

4. **Parent_id NULL**
   - Task timeout/failed tách ra khỏi parent
   - Campaign mẹ không bị ảnh hưởng

## ✅ Testing

### Test cron script:
```bash
/Applications/XAMPP/xamppfiles/bin/php cron-google-maps-timeout-handler.php
```

### Test với task giả:
```sql
-- Tạo task assigned cách đây 31 phút
INSERT INTO google_maps_review_sub_requests 
(parent_request_id, place_name, place_address, reward_amount, 
 expires_at, status, assigned_user_id, assigned_at, created_at, updated_at)
VALUES 
(1, 'Test Place', 'Test Address', 50000, 
 DATE_ADD(NOW(), INTERVAL 1 DAY), 'assigned', 1, 
 DATE_SUB(NOW(), INTERVAL 31 MINUTE), NOW(), NOW());
```

Sau đó chạy cron script và check log.

## 🎉 Kết luận

Hệ thống timeout handler đã hoàn thành và sẵn sàng sử dụng. Tất cả các tính năng đã được test và hoạt động tốt.

**Files quan trọng:**
- ✅ `cron-google-maps-timeout-handler.php` - Cron job chính
- ✅ `migrate_google_maps_allow_null_parent.sql` - Migration
- ✅ `setup_google_maps_timeout_cron.sh` - Setup script
- ✅ `GOOGLE_MAPS_TIMEOUT_HANDLER_GUIDE.md` - Hướng dẫn chi tiết

**Next steps:**
1. ✅ Migration đã chạy thành công
2. ⏳ Setup cron job khi deploy production
3. ⏳ Monitor logs để đảm bảo hoạt động tốt

---

**Ngày tạo:** 2025-10-09  
**Version:** 1.0.0  
**Status:** ✅ Ready for production

