# 💰 HỆ THỐNG RÚT TIỀN - WITHDRAWAL SYSTEM

## 📋 TỔNG QUAN

Hệ thống rút tiền tự động tích hợp với Pay2S API, cho phép user rút tiền về tài khoản ngân hàng của họ.

**Ngày tạo:** 2025-10-11  
**Nhánh:** `tinh-nang/he-thong-rut-tien`  
**Database:** `sho73359_shopqi`

---

## 🎯 TÍNH NĂNG CHÍNH

### ✅ User Side
1. **Quản lý ngân hàng** - Thêm/xóa/set default bank account
2. **Tạo yêu cầu rút tiền** - Form rút tiền với preview
3. **Theo dõi trạng thái** - Real-time countdown
4. **Hủy yêu cầu** - Cancel và refund balance
5. **Lịch sử** - Xem trong "Lịch sử giao dịch"

### ✅ Admin Side
1. **Dashboard** - Xem pending withdrawals
2. **QR Code** - Scan để chuyển tiền
3. **Thống kê** - Stats về withdrawals
4. **Auto complete** - Webhook tự động complete

### ✅ System
1. **Auto expire** - Cron job expire sau 15 phút
2. **Auto refund** - Hoàn tiền khi expire/cancel
3. **Webhook** - Pay2S auto detect giao dịch OUT
4. **Logging** - Track toàn bộ transactions

---

## 📊 DATABASE SCHEMA

### 1. Bảng `user_bank_accounts` (MỚI)
```sql
- account_id (PK)
- user_id (FK → users)
- bank_code (VD: 970416)
- bank_name (VD: ACB)
- account_number (STK)
- account_holder (Tên chủ TK)
- account_nickname (Biệt danh)
- is_default (0/1)
- status (active/inactive)
```

### 2. Bảng `vietnam_banks` (MỚI)
```sql
- id (PK)
- bank_code (970416, 970422, etc)
- bank_name (Tên đầy đủ)
- short_name (ACB, MBBank, etc)
- 30 ngân hàng Việt Nam
```

### 3. Bảng `qr_code_mapping` (MỞ RỘNG)
Thêm 7 cột mới:
```sql
- transaction_type ('deposit'/'withdrawal')
- withdrawal_bank_code
- withdrawal_bank_name
- withdrawal_account_number
- withdrawal_account_holder
- fee (phí rút)
- qr_image_url (VietQR image)
```

---

## 🔄 FLOW HOÀN CHỈNH

### Flow 1: User Thêm Bank Account
```
1. User → /shop-ai/bank-accounts
2. Chọn ngân hàng từ dropdown (30 banks)
3. Nhập STK + Tên chủ TK (auto UPPERCASE)
4. Submit → Save vào user_bank_accounts
5. Tự động set default nếu là bank đầu tiên
```

### Flow 2: User Rút Tiền
```
1. User → /shop-ai/withdrawal
2. Chọn bank account (dropdown)
3. Nhập số tiền (min 50K, max balance)
4. Preview: Amount - Fee (1%) = Actual
5. Confirm → Hold balance ngay lập tức
6. Generate QR code (prefix WD + 6 ký tự)
7. Save vào qr_code_mapping (transaction_type='withdrawal')
8. Generate VietQR image cho admin
9. Show alert "Đang chờ xử lý"
10. Expires sau 15 phút
```

### Flow 3: Admin Xử Lý
```
1. Admin → /admincp/shop-ai
2. Xem bảng "Yêu cầu Rút Tiền Chờ Xử Lý"
3. Click "Xem QR" → Modal hiện QR code
4. Scan QR bằng banking app
5. App tự động điền:
   - Ngân hàng user
   - STK user
   - Tên chủ TK
   - Số tiền
   - Nội dung: WD7X9K2
6. Confirm chuyển tiền
```

### Flow 4: Webhook Auto Complete
```
1. Admin chuyển tiền → Pay2S detect
2. Webhook gửi về: type='out', amount<0
3. System extract QR code (WD7X9K2)
4. Find trong qr_code_mapping
5. Verify amount khớp
6. Complete withdrawal:
   - Update status='used'
   - Log vào bank_transactions
   - Log vào users_wallets_transactions
7. KHÔNG cộng/trừ balance (đã hold rồi)
8. Notify user (future)
```

### Flow 5: Expire & Refund
```
1. Cron job chạy mỗi 5 phút
2. Find withdrawals: status='active' AND expires_at < NOW
3. Refund balance
4. Update status='expired'
5. Log transaction
```

---

## 📁 FILES ĐÃ TẠO/SỬA

### Database
- ✅ `Script/sql/withdrawal_system.sql` - Schema chính
- ✅ `Script/sql/alter_qr_code_mapping.sql` - Alter table

### Backend
- ✅ `Script/shop-ai.php` - 8 API endpoints + 3 views
- ✅ `Script/webhook-pay2s.php` - Refactor + withdrawal handler
- ✅ `Script/admin.php` - Admin queries + stats
- ✅ `Script/includes/ajax/admin/shop-ai.php` - AJAX endpoints

### Templates
- ✅ `Script/content/themes/default/templates/shop-ai.tpl` - Menu + includes
- ✅ `Script/content/themes/default/templates/shop-ai-bank-accounts.tpl` - Bank management UI
- ✅ `Script/content/themes/default/templates/shop-ai-withdrawal.tpl` - Withdrawal UI
- ✅ `Script/content/themes/default/templates/admin.shop-ai.tpl` - Admin dashboard

### Cron & Config
- ✅ `Script/cron-withdrawal-expire.php` - Cron job
- ✅ `Script/setup_withdrawal_cron.sh` - Setup script
- ✅ `Script/.htaccess` - URL rewrite rules

---

## 🔌 API ENDPOINTS

### User APIs
```
POST /shop-ai.php?action=add_bank_account
POST /shop-ai.php?action=list_bank_accounts
POST /shop-ai.php?action=delete_bank_account
POST /shop-ai.php?action=set_default_bank
POST /shop-ai.php?action=create_withdrawal
POST /shop-ai.php?action=check_withdrawal_status
POST /shop-ai.php?action=cancel_withdrawal
GET  /shop-ai.php?action=get_withdrawal_history
```

### Admin APIs
```
GET /includes/ajax/admin/shop-ai.php?action=check_withdrawal_updates
POST /includes/ajax/admin/shop-ai.php?action=get_withdrawal_details
```

---

## 🌐 ROUTES (URLs)

```
/shop-ai/bank-accounts    - Quản lý ngân hàng
/shop-ai/withdrawal       - Rút tiền
/shop-ai/transactions     - Lịch sử (bao gồm cả rút tiền)
/admincp/shop-ai          - Admin dashboard
```

---

## ⚙️ SETUP & DEPLOYMENT

### Bước 1: Import Database
```bash
# Trong phpMyAdmin hoặc MySQL:
mysql -u root sho73359_shopqi < Script/sql/withdrawal_system.sql
mysql -u root sho73359_shopqi < Script/sql/alter_qr_code_mapping.sql
```

### Bước 2: Setup Cron Job
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script
chmod +x setup_withdrawal_cron.sh
./setup_withdrawal_cron.sh
```

### Bước 3: Verify
```bash
# Check tables
mysql -u root sho73359_shopqi -e "SHOW TABLES LIKE '%bank%';"

# Check cron
crontab -l | grep withdrawal
```

---

## 🧪 TESTING

### Test 1: Add Bank Account
```
1. Vào /shop-ai/bank-accounts
2. Chọn ACB
3. Nhập STK: 123456789
4. Nhập tên: NGUYEN VAN A
5. Submit → Check database
```

### Test 2: Create Withdrawal
```
1. Vào /shop-ai/withdrawal
2. Chọn bank account
3. Nhập: 100,000 VNĐ
4. Confirm → Check balance bị hold
5. Check qr_code_mapping có record mới
```

### Test 3: Admin Process
```
1. Admin vào /admincp/shop-ai
2. Xem pending withdrawal
3. Click "Xem QR"
4. Test: Admin chuyển tiền với content WD...
5. Check webhook log
6. Verify auto complete
```

### Test 4: Expire & Refund
```
1. Tạo withdrawal
2. Đợi 15 phút hoặc manual update expires_at
3. Chạy cron: php cron-withdrawal-expire.php
4. Check balance được refund
5. Check status = 'expired'
```

---

## 💡 BUSINESS RULES

- **Min withdrawal:** 50,000 VNĐ
- **Max withdrawal:** 50,000,000 VNĐ/lần
- **Fee:** 1% (tính từ số tiền rút)
- **Expire time:** 15 phút
- **QR prefix:** WD + 6 ký tự (VD: WD7X9K2)
- **Auto refund:** Có (khi expire/cancel/failed)

---

## 🔒 SECURITY

- ✅ Authentication required
- ✅ User ownership verification
- ✅ Amount validation
- ✅ Balance check
- ✅ Rate limiting (future)
- ✅ Bank account validation
- ✅ Transaction logging

---

## 📝 NOTES

1. **Webhook dependency:** Cần Pay2S API hoạt động bình thường
2. **VietQR API:** Cần internet để generate QR
3. **Cron job:** Chạy mỗi 5 phút để expire
4. **Database:** Tất cả dùng PDO, không shell_exec
5. **Transaction types:**
   - `withdraw_request` - Tạo request
   - `withdraw_completed` - Hoàn thành
   - `withdraw_cancelled` - Hủy
   - `withdraw_expired_refund` - Hết hạn refund

---

## 🚀 NEXT STEPS

### Optional Enhancements
- [ ] OTP verification trước khi rút
- [ ] Email notification khi complete
- [ ] Bank account ownership verification
- [ ] Daily/weekly withdrawal limits
- [ ] Fraud detection
- [ ] Multiple admin approval
- [ ] Export reports

---

## 📞 SUPPORT

Nếu có vấn đề:
1. Check logs: `Script/logs/withdrawal-expire.log`
2. Check webhook: `Script/logs/pay2s-webhook.log`
3. Check database: qr_code_mapping table
4. Verify cron job: `crontab -l`

---

**Developed by:** AI Assistant  
**Date:** 2025-10-11  
**Version:** 1.0.0

