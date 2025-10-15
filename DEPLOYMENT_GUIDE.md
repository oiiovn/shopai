# 🚀 Hướng dẫn Deploy Phương Nhi Chatbot lên Production

## 📋 Tổng quan
Tính năng Phương Nhi Chatbot đã hoàn thành và sẵn sàng deploy lên production server.

## 🗄️ Database Setup

### 1. Tạo các bảng cần thiết
```bash
# Chạy script SQL trên production server
mysql -u your_username -p your_database_name < setup_production_database.sql
```

### 2. Các bảng được tạo:
- `phuong_nhi_config` - Cấu hình API key
- `phuong_nhi_conversations` - Cuộc trò chuyện
- `phuong_nhi_messages` - Tin nhắn chat
- `phuong_nhi_knowledge` - Kiến thức của bot

### 3. Cập nhật API key
```sql
UPDATE phuong_nhi_config 
SET config_value = 'YOUR_OPENAI_API_KEY_HERE' 
WHERE config_key = 'openai_api_key';
```

## 🔧 Code Deployment

### Cách 1: Sử dụng script tự động
```bash
./deploy_to_production.sh
```

### Cách 2: Deploy thủ công
```bash
# 1. Merge vào main branch
git checkout main
git pull origin main
git merge chatgpt-admin --no-ff -m "Merge Phương Nhi Chatbot"

# 2. Push lên production
git push origin main

# 3. Tạo tag version
git tag -a "v$(date +%Y%m%d_%H%M%S)" -m "Release Phương Nhi Chatbot"
git push origin --tags
```

## 📁 Files quan trọng cần deploy

### Backend Files:
- `includes/ajax/phuong_nhi.php` - AJAX handler chính
- `setup_chat_system.php` - Script setup (có thể xóa sau khi deploy)

### Frontend Files:
- `content/themes/default/templates/phuong_nhi_widget.tpl` - Chat widget
- `content/themes/default/templates/_footer.tpl` - Include widget

### Database Files:
- `setup_production_database.sql` - Script tạo bảng

## ⚙️ Cấu hình Production

### 1. File Permissions
```bash
chmod 644 includes/ajax/phuong_nhi.php
chmod 644 content/themes/default/templates/phuong_nhi_widget.tpl
chmod 644 content/themes/default/templates/_footer.tpl
```

### 2. PHP Settings
Đảm bảo server hỗ trợ:
- PHP 7.4+ với cURL extension
- MySQL 5.7+ hoặc MariaDB 10.3+
- JSON extension

### 3. Security
- Kiểm tra file `.htaccess` có block access vào thư mục `includes/`
- Đảm bảo API key được bảo mật
- Có thể thêm rate limiting cho API calls

## 🧪 Testing sau khi deploy

### 1. Test cơ bản
- Mở website và kiểm tra chat widget xuất hiện
- Click vào widget để mở chat
- Gửi tin nhắn test

### 2. Test tính năng
- Test xưng hô theo giới tính
- Test lưu lịch sử chat
- Test xóa lịch sử
- Test knowledge base (hỏi về sếp Vũ)

### 3. Test API
```bash
# Test welcome message
curl -X POST "https://yourdomain.com/includes/ajax/phuong_nhi.php" \
  -H "Content-Type: application/json" \
  -d '{"action":"generate_welcome","user_name":"Test","user_gender":"male"}'

# Test send message
curl -X POST "https://yourdomain.com/includes/ajax/phuong_nhi.php" \
  -H "Content-Type: application/json" \
  -d '{"action":"send_message","message":"Chào em","user_name":"Test","user_gender":"male","chat_history":[],"session_id":"test123"}'
```

## 🔍 Troubleshooting

### Lỗi thường gặp:

1. **Chat widget không hiển thị**
   - Kiểm tra file `_footer.tpl` có include widget
   - Kiểm tra console browser có lỗi JavaScript

2. **API trả về lỗi 500**
   - Kiểm tra file `phuong_nhi.php` có đúng path
   - Kiểm tra database connection
   - Kiểm tra API key OpenAI

3. **Không lưu được chat history**
   - Kiểm tra bảng database đã tạo chưa
   - Kiểm tra quyền ghi database

4. **GPT không trả lời**
   - Kiểm tra API key OpenAI
   - Kiểm tra internet connection
   - Kiểm tra quota OpenAI

## 📊 Monitoring

### 1. Log files
- PHP error log: `/var/log/php_errors.log`
- Web server log: `/var/log/apache2/error.log` hoặc `/var/log/nginx/error.log`

### 2. Database monitoring
```sql
-- Kiểm tra số lượng conversations
SELECT COUNT(*) FROM phuong_nhi_conversations;

-- Kiểm tra số lượng messages
SELECT COUNT(*) FROM phuong_nhi_messages;

-- Kiểm tra usage của knowledge
SELECT category, SUM(usage_count) as total_usage 
FROM phuong_nhi_knowledge 
GROUP BY category;
```

## 🎯 Performance Tips

1. **Database Indexing**
   - Đã tạo sẵn indexes cho các bảng
   - Có thể thêm index cho `created_at` nếu cần

2. **Caching**
   - Có thể cache knowledge base
   - Cache user gender để giảm API calls

3. **Rate Limiting**
   - Thêm rate limiting cho OpenAI API calls
   - Giới hạn số messages per user per minute

## 🔄 Rollback Plan

Nếu cần rollback:
```bash
# 1. Revert commit
git revert HEAD

# 2. Push rollback
git push origin main

# 3. Xóa bảng database (nếu cần)
mysql -u username -p database_name -e "DROP TABLE phuong_nhi_messages, phuong_nhi_conversations, phuong_nhi_knowledge, phuong_nhi_config;"
```

## 📞 Support

Nếu gặp vấn đề:
1. Kiểm tra log files
2. Test từng component riêng biệt
3. Liên hệ developer với thông tin lỗi chi tiết

---

**🎉 Chúc mừng! Phương Nhi Chatbot đã sẵn sàng phục vụ khách hàng!**
