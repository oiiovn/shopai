#!/bin/bash

# Setup Withdrawal Expire Cron Job
# Chạy mỗi 5 phút để expire và refund withdrawal requests

SCRIPT_DIR="/Applications/XAMPP/xamppfiles/htdocs/TCSN/Script"
CRON_COMMAND="*/5 * * * * /usr/bin/php $SCRIPT_DIR/cron-withdrawal-expire.php >> $SCRIPT_DIR/logs/withdrawal-expire.log 2>&1"

# Kiểm tra xem cron đã tồn tại chưa
if crontab -l 2>/dev/null | grep -q "cron-withdrawal-expire.php"; then
    echo "✅ Cron job withdrawal expire đã tồn tại"
    crontab -l | grep "cron-withdrawal-expire.php"
else
    # Thêm cron job mới
    (crontab -l 2>/dev/null; echo "$CRON_COMMAND") | crontab -
    echo "✅ Đã thêm cron job withdrawal expire"
    echo "Schedule: Mỗi 5 phút"
    echo "Command: $CRON_COMMAND"
fi

echo ""
echo "Để xem các cron jobs hiện tại:"
echo "  crontab -l"
echo ""
echo "Để test chạy thủ công:"
echo "  php $SCRIPT_DIR/cron-withdrawal-expire.php"
echo ""
echo "Để xem log:"
echo "  tail -f $SCRIPT_DIR/logs/withdrawal-expire.log"

