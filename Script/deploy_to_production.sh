#!/bin/bash

# Script deploy Phương Nhi Chatbot lên production
# Sử dụng: ./deploy_to_production.sh

echo "🚀 Bắt đầu deploy Phương Nhi Chatbot lên production..."

# 1. Kiểm tra branch hiện tại
echo "📋 Kiểm tra branch hiện tại..."
CURRENT_BRANCH=$(git branch --show-current)
echo "Branch hiện tại: $CURRENT_BRANCH"

if [ "$CURRENT_BRANCH" != "chatgpt-admin" ]; then
    echo "⚠️  Cảnh báo: Bạn đang ở branch $CURRENT_BRANCH, không phải chatgpt-admin"
    read -p "Bạn có muốn tiếp tục? (y/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo "❌ Hủy deploy"
        exit 1
    fi
fi

# 2. Pull latest changes
echo "📥 Pull latest changes..."
git pull origin $CURRENT_BRANCH

# 3. Merge vào main branch
echo "🔄 Merge vào main branch..."
git checkout main
git pull origin main
git merge $CURRENT_BRANCH --no-ff -m "Merge Phương Nhi Chatbot feature from $CURRENT_BRANCH"

# 4. Push lên production
echo "📤 Push lên production..."
git push origin main

# 5. Tạo tag version
VERSION=$(date +"%Y%m%d_%H%M%S")
echo "🏷️  Tạo tag version: v$VERSION"
git tag -a "v$VERSION" -m "Release Phương Nhi Chatbot v$VERSION"
git push origin "v$VERSION"

# 6. Hướng dẫn setup database
echo ""
echo "✅ Deploy thành công!"
echo ""
echo "📋 Bước tiếp theo trên production server:"
echo "1. Chạy SQL script: mysql -u username -p database_name < setup_production_database.sql"
echo "2. Cập nhật API key OpenAI trong bảng phuong_nhi_config"
echo "3. Kiểm tra file permissions cho thư mục includes/ajax/"
echo "4. Test chat widget trên website"
echo ""
echo "🔗 Files quan trọng:"
echo "- includes/ajax/phuong_nhi.php"
echo "- content/themes/default/templates/phuong_nhi_widget.tpl"
echo "- content/themes/default/templates/_footer.tpl"
echo ""
echo "🎉 Phương Nhi Chatbot đã sẵn sàng trên production!"
