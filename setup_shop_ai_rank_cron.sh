#!/bin/bash

# Setup script for Shop-AI rank update cronjob
# This script adds the rank update cronjob to crontab

echo "Setting up Shop-AI Rank Update Cronjob..."

# Get the current directory (Script folder)
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
CRON_FILE="$SCRIPT_DIR/cron-shop-ai-rank-update.php"

# Check if the cron file exists
if [ ! -f "$CRON_FILE" ]; then
    echo "Error: cron-shop-ai-rank-update.php not found in $SCRIPT_DIR"
    exit 1
fi

echo "Cron file found: $CRON_FILE"

# Create cron entry (runs every 5 minutes)
CRON_ENTRY="*/5 * * * * cd $SCRIPT_DIR && php cron-shop-ai-rank-update.php >> logs/rank-update.log 2>&1"

echo "Adding cron entry: $CRON_ENTRY"

# Check if cron entry already exists
if crontab -l 2>/dev/null | grep -q "cron-shop-ai-rank-update.php"; then
    echo "Cron entry already exists. Updating..."
    # Remove existing entry and add new one
    (crontab -l 2>/dev/null | grep -v "cron-shop-ai-rank-update.php"; echo "$CRON_ENTRY") | crontab -
else
    echo "Adding new cron entry..."
    (crontab -l 2>/dev/null; echo "$CRON_ENTRY") | crontab -
fi

# Create logs directory if it doesn't exist
mkdir -p "$SCRIPT_DIR/logs"

echo "Cronjob setup completed!"
echo ""
echo "The rank update cronjob will run every 5 minutes."
echo "Logs will be written to: $SCRIPT_DIR/logs/rank-update.log"
echo ""
echo "To view current crontab: crontab -l"
echo "To view logs: tail -f $SCRIPT_DIR/logs/rank-update.log"
echo ""
echo "To remove the cronjob: crontab -e (then delete the line with cron-shop-ai-rank-update.php)"
