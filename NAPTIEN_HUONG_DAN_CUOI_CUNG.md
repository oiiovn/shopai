# 🎯 HƯỚNG DẪN NẠP TIỀN TỰ ĐỘNG - CUỐI CÙNG

## ✅ HỆ THỐNG ĐÃ SẴN SÀNG!

### 🔧 **Các thành phần đã được cài đặt:**

1. **✅ Cron Job**: Chạy mỗi phút để kiểm tra giao dịch mới
2. **✅ Pay2S API**: Kết nối với API thật để lấy giao dịch
3. **✅ Database**: Các bảng cần thiết đã được tạo
4. **✅ Thông báo**: Hệ thống thông báo đã hoạt động
5. **✅ QR Code**: Tự động tạo QR code cho mỗi lần nạp tiền

---

## 🚀 **CÁCH NẠP TIỀN:**

### **Bước 1: Truy cập trang nạp tiền**
```
http://localhost/TCSN/Script/shop-ai/recharge
```

### **Bước 2: Nhập số tiền**
- Nhập số tiền muốn nạp (tối thiểu: 10,000 VNĐ)
- Hoặc chọn nhanh: 50K, 100K, 200K, 500K

### **Bước 3: Tạo QR Code**
- Click "Nạp tiền ngay"
- Hệ thống sẽ tạo QR code với nội dung duy nhất (VD: RZ1ABC123)

### **Bước 4: Chuyển khoản**
- Quét QR code bằng app ngân hàng
- Chuyển khoản đến tài khoản: **ACB 46241987**
- Nội dung chuyển khoản: **RZ1ABC123** (chính xác)

### **Bước 5: Chờ xử lý**
- Hệ thống tự động kiểm tra mỗi phút
- Khi phát hiện giao dịch → Tự động cộng tiền
- Gửi thông báo: "Nạp tiền thành công: X VNĐ"

---

## ⚡ **QUY TRÌNH TỰ ĐỘNG:**

```
1. User tạo QR code → Lưu vào qr_code_mapping
2. User chuyển khoản với nội dung QR code
3. Pay2S API nhận giao dịch → Lưu vào bank_transactions
4. Cron job chạy mỗi phút:
   - Lấy giao dịch mới từ Pay2S
   - Tìm QR code trong mô tả giao dịch
   - Tìm user tương ứng trong qr_code_mapping
   - Cộng tiền vào balance
   - Gửi thông báo
   - Đánh dấu QR code đã sử dụng
```

---

## 🔔 **THÔNG BÁO:**

- **Khi nạp thành công**: "Nạp tiền thành công: 10.000 VNĐ. Số dư hiện tại: 20.000 VNĐ"
- **Xem thông báo**: Click icon chuông 🔔 trên header
- **Lịch sử giao dịch**: Tab "Giao dịch" → Xem chi tiết

---

## 🛠️ **KIỂM TRA HỆ THỐNG:**

### **1. Kiểm tra cron job:**
```bash
crontab -l | grep cron-pay2s
```

### **2. Kiểm tra log:**
```bash
tail -f /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/logs/cron-real.log
```

### **3. Kiểm tra database:**
```bash
# Xem giao dịch mới
mysql -u root -P 3306 db_mxh -e "SELECT * FROM bank_transactions ORDER BY created_at DESC LIMIT 5;"

# Xem số dư
mysql -u root -P 3306 db_mxh -e "SELECT balance FROM users WHERE user_id = 1;"

# Xem thông báo
mysql -u root -P 3306 db_mxh -e "SELECT * FROM notifications WHERE to_user_id = 1 ORDER BY time DESC LIMIT 3;"
```

---

## ⚠️ **LƯU Ý QUAN TRỌNG:**

1. **Nội dung chuyển khoản phải CHÍNH XÁC** (VD: RZ1ABC123)
2. **Chuyển khoản đến đúng tài khoản**: ACB 46241987
3. **Hệ thống kiểm tra mỗi phút** → Có thể mất 1-2 phút
4. **Nếu không tự động**: Kiểm tra log và database
5. **QR code chỉ dùng 1 lần** → Tạo QR mới cho lần nạp tiếp theo

---

## 🎉 **SẴN SÀNG NẠP TIỀN!**

**Hệ thống đã hoàn toàn sẵn sàng! Bạn có thể tiến hành nạp tiền ngay bây giờ!**

### **📱 Truy cập:**
- **Nạp tiền**: http://localhost/TCSN/Script/shop-ai/recharge
- **Lịch sử**: http://localhost/TCSN/Script/shop-ai/transactions
- **Trang chủ**: http://localhost/TCSN/Script/shop-ai

**Chúc bạn nạp tiền thành công! 🚀**

