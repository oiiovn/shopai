# 🔧 Hướng Dẫn Khắc Phục Pay2S API

## ❌ **Vấn đề hiện tại:**
- Pay2S API trả về: `"User not found"`
- Endpoint `/transactions` yêu cầu `pay2s-token` nhưng không hoạt động

## 🔍 **Nguyên nhân có thể:**

### **1. Tài khoản Pay2S chưa được kích hoạt đầy đủ**
### **2. Số tài khoản `46241987` chưa được đăng ký với Pay2S**
### **3. Cần xác thực tài khoản ngân hàng trước**

---

## 📋 **Các bước kiểm tra trong Pay2S Dashboard:**

### **Bước 1: Đăng nhập Pay2S**
- Truy cập: https://my.pay2s.vn
- Đăng nhập với tài khoản của bạn

### **Bước 2: Kiểm tra thông tin tích hợp**
- Vào mục "Tích hợp Website/Application"
- Xác nhận các thông tin:
  - ✅ **Partner code**: `PAY2S23DW78K2CVCZFW9`
  - ✅ **Access key**: `88d3b56b2702dbf15a6648cc2eda93001f5c80ab9cdcc232393b4f368e9ec9c6`
  - ✅ **Secret key**: `1ece1f568539eeb7b971578c32a317369defbf0e64b8336124bdc47399a3419e`

### **Bước 3: Kiểm tra tài khoản ngân hàng**
- Tìm mục "Tài khoản ngân hàng" hoặc "Bank Accounts"
- Kiểm tra xem có số tài khoản `46241987` (ACB) chưa?
- Nếu chưa có, cần thêm tài khoản này

### **Bước 4: Lấy Pay2S Token**
- Tìm mục "Token" hoặc "Access Token"
- Copy token thật (có dạng `eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...`)
- **KHÔNG phải** Partner code hay Access key

### **Bước 5: Kiểm tra trạng thái tài khoản**
- Xem tài khoản có bị khóa hay chưa kích hoạt không?
- Có cần xác thực thêm gì không?

---

## 🚨 **Các vấn đề thường gặp:**

### **1. "User not found"**
- **Nguyên nhân**: Tài khoản chưa được kích hoạt hoặc chưa đăng ký số tài khoản
- **Giải pháp**: Đăng ký số tài khoản `46241987` trong Pay2S dashboard

### **2. "Missing pay2s-token"**
- **Nguyên nhân**: Sử dụng sai header hoặc token
- **Giải pháp**: Sử dụng `pay2s-token` header với token thật

### **3. "Invalid token"**
- **Nguyên nhân**: Token không đúng hoặc đã hết hạn
- **Giải pháp**: Lấy token mới từ Pay2S dashboard

---

## 📞 **Liên hệ hỗ trợ Pay2S:**

### **Thông tin cần cung cấp:**
- Partner code: `PAY2S23DW78K2CVCZFW9`
- Số tài khoản: `46241987` (ACB)
- Lỗi: "User not found" khi gọi API `/transactions`

### **Câu hỏi cần hỏi:**
1. Tài khoản đã được kích hoạt đầy đủ chưa?
2. Số tài khoản `46241987` đã được đăng ký chưa?
3. Cần làm gì để lấy `pay2s-token` thật?
4. Có cần xác thực thêm gì không?

---

## 🔄 **Sau khi khắc phục:**

### **1. Cập nhật cấu hình:**
```php
// Trong pay2s-config.php
'pay2s_token' => 'TOKEN_THẬT_TỪ_PAY2S_DASHBOARD',
```

### **2. Test API:**
```bash
php /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/cron-pay2s-real-only.php
```

### **3. Thiết lập cron job:**
```bash
crontab -e
```
Thêm dòng:
```bash
* * * * * /usr/bin/php /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/cron-pay2s-real-only.php >> /Applications/XAMPP/xamppfiles/htdocs/TCSN/Script/logs/cron-real.log 2>&1
```

---

## ✅ **Checklist hoàn thành:**

- [ ] Đăng nhập được Pay2S dashboard
- [ ] Xác nhận Partner code, Access key, Secret key
- [ ] Đăng ký số tài khoản `46241987` (ACB)
- [ ] Lấy được `pay2s-token` thật
- [ ] Test API thành công
- [ ] Thiết lập cron job
- [ ] Hệ thống nạp tiền hoạt động

**🎯 Hãy kiểm tra từng bước và cho tôi biết kết quả!**

