# 🏦 Hướng Dẫn Đăng Ký Pay2S API

## ❌ **Vấn đề hiện tại:**
- Pay2S API trả về: `"User not found"`
- Cần đăng ký tài khoản Pay2S trước khi sử dụng API

## 🔧 **Thông tin API của bạn:**
- **API Key**: `PAY2S23DW78K2CVCZFW9`
- **API Secret**: `88d3b56b2702dbf15a6648cc2eda93001f5c80ab9cdcc232393b4f368e9ec9c6`
- **Webhook Secret**: `1ece1f568539eeb7b971578c32a317369defbf0e64b8336124bdc47399a3419e`
- **Số tài khoản**: `46241987` (ACB)

## 📋 **Các bước đăng ký Pay2S:**

### **Bước 1: Truy cập Pay2S**
- URL: https://my.pay2s.vn
- Đăng ký tài khoản mới hoặc đăng nhập

### **Bước 2: Kích hoạt API**
- Vào phần "Tích hợp Web/App"
- Nhập API Key: `PAY2S23DW78K2CVCZFW9`
- Nhập API Secret: `88d3b56b2702dbf15a6648cc2eda93001f5c80ab9cdcc232393b4f368e9ec9c6`

### **Bước 3: Đăng ký số tài khoản**
- Thêm số tài khoản: `46241987`
- Chọn ngân hàng: ACB
- Xác thực tài khoản

### **Bước 4: Lấy Pay2S Token**
- Sau khi đăng ký thành công, lấy `pay2s-token` từ dashboard
- Cập nhật token trong file `pay2s-config.php`

## 🔄 **Sau khi đăng ký thành công:**

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

## 🚨 **Lưu ý quan trọng:**

### **API Rate Limits:**
- Tối đa 60 request/phút
- Nếu vượt quá sẽ trả về lỗi 429

### **Webhook URL:**
- Cần cập nhật webhook URL thật
- Hiện tại: `https://yourdomain.com/TCSN/Script/webhook-pay2s.php`

### **SSL Certificate:**
- Cần SSL certificate hợp lệ cho webhook
- Pay2S sẽ gửi POST request đến webhook URL

## 📞 **Hỗ trợ Pay2S:**
- Email: support@pay2s.vn
- Hotline: (nếu có)
- Documentation: https://my.pay2s.vn/docs

## ✅ **Sau khi hoàn thành:**
1. ✅ Đăng ký tài khoản Pay2S
2. ✅ Kích hoạt API với key/secret
3. ✅ Đăng ký số tài khoản 46241987
4. ✅ Lấy pay2s-token thật
5. ✅ Cập nhật cấu hình
6. ✅ Test API thành công
7. ✅ Thiết lập cron job
8. ✅ Hệ thống nạp tiền thật hoạt động

**🎯 Hệ thống đã sẵn sàng, chỉ cần đăng ký Pay2S là có thể sử dụng ngay!**

