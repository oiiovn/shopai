#!/bin/bash

# Setup Cron Job cho Shop-AI Recharge Checker
# Script này sẽ thiết lập cron job để chạy kiểm tra giao dịch mỗi phút

echo "=== Thiết lập Cron Job cho Shop-AI Recharge Checker ==="

# Đường dẫn tới script
SCRIPT_DIR="/Applications/XAMPP/xamppfiles/htdocs/TCSN/Script"
CHECKER_SCRIPT="$SCRIPT_DIR/cron-shop-ai-recharge-checker.php"
LOG_FILE="$SCRIPT_DIR/logs/cron-shop-ai-recharge.log"

# Kiểm tra file script có tồn tại không
if [ ! -f "$CHECKER_SCRIPT" ]; then
    echo "❌ Không tìm thấy file script: $CHECKER_SCRIPT"
    exit 1
fi

# Tạo thư mục logs nếu chưa có
mkdir -p "$SCRIPT_DIR/logs"

# Tạo backup của crontab hiện tại
echo "📋 Backup crontab hiện tại..."
crontab -l > "$SCRIPT_DIR/crontab_backup_$(date +%Y%m%d_%H%M%S).txt" 2>/dev/null || echo "Không có crontab hiện tại"

# Tạo cron job entry
CRON_ENTRY="* * * * * /usr/bin/php $CHECKER_SCRIPT >> $LOG_FILE 2>&1"

# Kiểm tra xem cron job đã tồn tại chưa
if crontab -l 2>/dev/null | grep -q "$CHECKER_SCRIPT"; then
    echo "⚠️  Cron job đã tồn tại. Cập nhật..."
    # Xóa cron job cũ và thêm mới
    (crontab -l 2>/dev/null | grep -v "$CHECKER_SCRIPT"; echo "$CRON_ENTRY") | crontab -
else
    echo "➕ Thêm cron job mới..."
    # Thêm cron job mới
    (crontab -l 2>/dev/null; echo "$CRON_ENTRY") | crontab -
fi

# Kiểm tra kết quả
if crontab -l | grep -q "$CHECKER_SCRIPT"; then
    echo "✅ Cron job đã được thiết lập thành công!"
    echo ""
    echo "📋 Cron job hiện tại:"
    crontab -l | grep "$CHECKER_SCRIPT"
    echo ""
    echo "📝 Log file: $LOG_FILE"
    echo "🔄 Script sẽ chạy mỗi phút để kiểm tra giao dịch Pay2S"
    echo ""
    echo "🛠️  Để xem log realtime:"
    echo "   tail -f $LOG_FILE"
    echo ""
    echo "🛑 Để dừng cron job:"
    echo "   crontab -e"
    echo "   (sau đó xóa dòng chứa $CHECKER_SCRIPT)"
else
    echo "❌ Không thể thiết lập cron job"
    exit 1
fi

# Kiểm tra cron service đang chạy
if pgrep cron > /dev/null; then
    echo "✅ Cron service đang chạy"
else
    echo "⚠️  Cron service không chạy. Khởi động cron service:"
    echo "   sudo service cron start"
fi

echo ""
echo "=== Hoàn thành thiết lập ==="
