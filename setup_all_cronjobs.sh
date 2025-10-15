#!/bin/bash

# Setup script for ALL TCSN Cronjobs
# This script sets up all cronjobs for the TCSN project

echo "=========================================="
echo "🚀 SETUP TOÀN BỘ CRONJOB TCSN"
echo "=========================================="
echo ""

# Get the current directory (Script folder)
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
echo "📁 Script Directory: $SCRIPT_DIR"
echo ""

# Create logs directory if it doesn't exist
mkdir -p "$SCRIPT_DIR/logs"
echo "📂 Created logs directory: $SCRIPT_DIR/logs"
echo ""

# Function to add cron entry
add_cron_entry() {
    local cron_entry="$1"
    local description="$2"
    
    echo "➕ Adding: $description"
    echo "   Entry: $cron_entry"
    
    # Check if cron entry already exists
    if crontab -l 2>/dev/null | grep -q "$(echo "$cron_entry" | awk '{print $6}')"; then
        echo "   ⚠️  Entry already exists. Updating..."
        # Remove existing entry and add new one
        (crontab -l 2>/dev/null | grep -v "$(echo "$cron_entry" | awk '{print $6}')"; echo "$cron_entry") | crontab -
    else
        echo "   ✅ Adding new entry..."
        (crontab -l 2>/dev/null; echo "$cron_entry") | crontab -
    fi
    echo ""
}

echo "🔧 SETTING UP CRONJOBS..."
echo ""

# 1. Bank Transactions (every 5 minutes)
add_cron_entry "*/5 * * * * cd $SCRIPT_DIR && php cron-bank-transactions.php >> logs/cron-bank-transactions.log 2>&1" \
               "Bank Transactions (every 5 minutes)"

# 2. Pay2S Integration (every 5 minutes)  
add_cron_entry "*/5 * * * * cd $SCRIPT_DIR && php cron-pay2s-integration.php >> logs/cron-pay2s.log 2>&1" \
               "Pay2S Integration (every 5 minutes)"

# 3. Pay2S Real Only (every 5 minutes)
add_cron_entry "*/5 * * * * cd $SCRIPT_DIR && php cron-pay2s-real-only.php >> logs/cron-pay2s-real-only.log 2>&1" \
               "Pay2S Real Only (every 5 minutes)"

# 4. Shop-AI Recharge Checker (every 5 minutes)
add_cron_entry "*/5 * * * * cd $SCRIPT_DIR && php cron-shop-ai-recharge-checker.php >> logs/cron-shop-ai-recharge.log 2>&1" \
               "Shop-AI Recharge Checker (every 5 minutes)"

# 5. Shop-AI Rank Update (every 5 minutes) - NEW
add_cron_entry "*/5 * * * * cd $SCRIPT_DIR && php cron-shop-ai-rank-update.php >> logs/rank-update.log 2>&1" \
               "Shop-AI Rank Update (every 5 minutes) - NEW"

# 6. Bank Transactions V2 (every 10 minutes)
add_cron_entry "*/10 * * * * cd $SCRIPT_DIR && php cron-bank-transactions-v2.php >> logs/cron-bank-transactions.log 2>&1" \
               "Bank Transactions V2 (every 10 minutes)"

# 7. Pay2S Real (every 15 minutes)
add_cron_entry "*/15 * * * * cd $SCRIPT_DIR && php cron-pay2s-real.php >> logs/cron-pay2s-real.log 2>&1" \
               "Pay2S Real (every 15 minutes)"

echo "=========================================="
echo "✅ CRONJOB SETUP COMPLETED!"
echo "=========================================="
echo ""

echo "📊 SUMMARY:"
echo "• Total cronjobs installed: 7"
echo "• Bank Transactions: 2 cronjobs"
echo "• Pay2S Integration: 3 cronjobs"  
echo "• Shop-AI System: 2 cronjobs"
echo ""

echo "🔍 VERIFICATION:"
echo "To view current crontab: crontab -l"
echo ""

echo "📋 INDIVIDUAL CRONJOBS:"
echo "1. Bank Transactions (5 min) → logs/cron-bank-transactions.log"
echo "2. Pay2S Integration (5 min) → logs/cron-pay2s.log"
echo "3. Pay2S Real Only (5 min) → logs/cron-pay2s-real-only.log"
echo "4. Shop-AI Recharge (5 min) → logs/cron-shop-ai-recharge.log"
echo "5. Shop-AI Rank Update (5 min) → logs/rank-update.log ⭐"
echo "6. Bank Transactions V2 (10 min) → logs/cron-bank-transactions.log"
echo "7. Pay2S Real (15 min) → logs/cron-pay2s-real.log"
echo ""

echo "📝 LOG MONITORING:"
echo "• Monitor all logs: tail -f logs/*.log"
echo "• Monitor rank updates: tail -f logs/rank-update.log"
echo "• Monitor recharge: tail -f logs/cron-shop-ai-recharge.log"
echo "• Monitor bank transactions: tail -f logs/cron-bank-transactions.log"
echo ""

echo "🗑️  REMOVAL:"
echo "To remove all TCSN cronjobs: crontab -e (then delete lines with TCSN scripts)"
echo ""

echo "🎉 ALL CRONJOBS SETUP COMPLETED SUCCESSFULLY!"
