#!/bin/bash

# ========================================
# SETUP CRON JOB: Google Maps Timeout Handler
# ========================================
# Chạy mỗi 5 phút để xử lý timeout và failed verification

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PHP_BIN="/Applications/XAMPP/xamppfiles/bin/php"
CRON_SCRIPT="$SCRIPT_DIR/cron-google-maps-timeout-handler.php"

echo "=========================================="
echo "Setting up Google Maps Timeout Handler Cron Job"
echo "=========================================="
echo ""
echo "Script location: $CRON_SCRIPT"
echo "PHP binary: $PHP_BIN"
echo ""

# Kiểm tra file cron script tồn tại
if [ ! -f "$CRON_SCRIPT" ]; then
    echo "❌ Error: Cron script not found at $CRON_SCRIPT"
    exit 1
fi

# Kiểm tra PHP binary
if [ ! -f "$PHP_BIN" ]; then
    echo "❌ Error: PHP binary not found at $PHP_BIN"
    exit 1
fi

# Tạo cron job entry
CRON_JOB="*/5 * * * * $PHP_BIN $CRON_SCRIPT >> $SCRIPT_DIR/logs/google_maps_timeout_handler.log 2>&1"

echo "Cron job to be added:"
echo "$CRON_JOB"
echo ""

# Backup crontab hiện tại
echo "Backing up current crontab..."
crontab -l > "$SCRIPT_DIR/crontab_backup_$(date +%Y%m%d_%H%M%S).txt" 2>/dev/null || true

# Kiểm tra xem cron job đã tồn tại chưa
if crontab -l 2>/dev/null | grep -F "cron-google-maps-timeout-handler.php" > /dev/null; then
    echo "⚠️  Cron job already exists. Removing old entry..."
    crontab -l 2>/dev/null | grep -v "cron-google-maps-timeout-handler.php" | crontab -
fi

# Thêm cron job mới
echo "Adding new cron job..."
(crontab -l 2>/dev/null; echo "$CRON_JOB") | crontab -

if [ $? -eq 0 ]; then
    echo "✅ Cron job added successfully!"
    echo ""
    echo "Current crontab:"
    crontab -l | grep "cron-google-maps-timeout-handler.php"
else
    echo "❌ Failed to add cron job"
    exit 1
fi

# Tạo thư mục logs nếu chưa có
mkdir -p "$SCRIPT_DIR/logs"

echo ""
echo "=========================================="
echo "Setup completed!"
echo "=========================================="
echo ""
echo "Cron job will run every 5 minutes"
echo "Log file: $SCRIPT_DIR/logs/google_maps_timeout_handler.log"
echo ""
echo "To verify: crontab -l | grep google-maps-timeout"
echo "To remove: crontab -e (then delete the line)"
echo ""

