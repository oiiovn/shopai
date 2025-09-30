<?php

/**
 * Script để migrate từ hệ thống tính lại sang hệ thống cộng dồn
 * Chuyển đổi dữ liệu từ users_wallets_transactions sang shop_ai_user_ranks
 */

require_once 'bootloader.php';

echo "=== MIGRATE TO CUMULATIVE RANK SYSTEM ===\n\n";

// Function để tính tổng chi tiêu thực tế từ users_wallets_transactions
function calculateRealSpending($user_id) {
    global $db;
    
    $stmt = $db->prepare("
        SELECT 
            (SELECT COALESCE(SUM(amount), 0) FROM users_wallets_transactions 
             WHERE user_id = ? AND type = 'withdraw' AND description LIKE '%Check số Shopee%') as total_spent,
            (SELECT COALESCE(SUM(amount), 0) FROM users_wallets_transactions 
             WHERE user_id = ? AND type = 'recharge' AND description LIKE '%Hoàn tiền check số thất bại%') as total_refunded
    ");
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    return ($result['total_spent'] ?? 0) - ($result['total_refunded'] ?? 0);
}

// Function để xác định rank dựa trên chi tiêu
function getRankBySpending($total_spending) {
    global $db;
    
    $stmt = $db->prepare("
        SELECT * FROM shop_ai_ranks 
        WHERE is_active = 1 AND min_spending <= ? 
        ORDER BY min_spending DESC 
        LIMIT 1
    ");
    $stmt->bind_param("i", $total_spending);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        // Fallback to Bronze rank
        $stmt = $db->prepare("
            SELECT * FROM shop_ai_ranks 
            WHERE is_active = 1 
            ORDER BY rank_order ASC 
            LIMIT 1
        ");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}

echo "🔍 Tìm user có chi tiêu Shop-AI...\n\n";

// Tìm tất cả user có giao dịch Shop-AI
$users_query = $db->query("
    SELECT DISTINCT user_id
    FROM users_wallets_transactions 
    WHERE (description LIKE '%Check số Shopee%' OR description LIKE '%Hoàn tiền check số thất bại%')
    ORDER BY user_id
");

$users_to_migrate = [];
$total_users = $users_query->num_rows;

echo "📊 Tìm thấy $total_users users có giao dịch Shop-AI\n\n";

if ($total_users > 0) {
    echo "📋 DANH SÁCH USER CẦN MIGRATE:\n";
    echo str_repeat("-", 100) . "\n";
    printf("%-8s %-15s %-15s %-15s %-15s %-15s\n", "User ID", "Username", "Current DB", "Real Spending", "Rank", "Check Price");
    echo str_repeat("-", 100) . "\n";
    
    while ($user_row = $users_query->fetch_assoc()) {
        $user_id = $user_row['user_id'];
        
        // Lấy thông tin user
        $user_info = $db->query("SELECT user_name FROM users WHERE user_id = $user_id")->fetch_assoc();
        $username = $user_info['user_name'] ?? 'Unknown';
        
        // Lấy chi tiêu hiện tại trong DB
        $current_db_spending = 0;
        $current_rank_check = $db->query("SELECT total_spending FROM shop_ai_user_ranks WHERE user_id = $user_id");
        if ($current_rank_check->num_rows > 0) {
            $current_db_spending = $current_rank_check->fetch_assoc()['total_spending'];
        }
        
        // Tính chi tiêu thực tế
        $real_spending = calculateRealSpending($user_id);
        
        // Xác định rank
        $rank = getRankBySpending($real_spending);
        $rank_name = $rank['rank_name'] . " " . $rank['rank_emoji'];
        $check_price = number_format($rank['check_price'], 0, ',', '.');
        
        printf("%-8s %-15s %-15s %-15s %-15s %-15s\n",
               $user_id,
               substr($username, 0, 14),
               number_format($current_db_spending, 0, ',', '.') . " VNĐ",
               number_format($real_spending, 0, ',', '.') . " VNĐ",
               $rank_name,
               $check_price . " VNĐ"
        );
        
        // Chỉ migrate nếu có sự khác biệt
        if ($current_db_spending != $real_spending) {
            $users_to_migrate[] = [
                'user_id' => $user_id,
                'username' => $username,
                'current_db_spending' => $current_db_spending,
                'real_spending' => $real_spending,
                'rank' => $rank
            ];
        }
    }
    
    echo str_repeat("-", 100) . "\n\n";
    
    if (!empty($users_to_migrate)) {
        echo "🎯 USER CẦN MIGRATE (" . count($users_to_migrate) . " users):\n";
        foreach ($users_to_migrate as $user) {
            $diff = $user['real_spending'] - $user['current_db_spending'];
            echo "- User {$user['user_id']} ({$user['username']}): " . 
                 number_format($user['current_db_spending'], 0, ',', '.') . " → " . 
                 number_format($user['real_spending'], 0, ',', '.') . 
                 " (Δ" . number_format($diff, 0, ',', '.') . " VNĐ)\n";
        }
        
        echo "\n❓ Bạn có muốn migrate những user này không? (y/n): ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        $confirm = trim($line);
        fclose($handle);
        
        if (strtolower($confirm) === 'y' || strtolower($confirm) === 'yes') {
            echo "\n🚀 BẮT ĐẦU MIGRATE...\n\n";
            
            $success_count = 0;
            $error_count = 0;
            
            foreach ($users_to_migrate as $user) {
                echo "📝 Processing User {$user['user_id']} ({$user['username']})...\n";
                
                try {
                    $db->begin_transaction();
                    
                    // Update hoặc insert vào shop_ai_user_ranks
                    $check_existing = $db->query("SELECT * FROM shop_ai_user_ranks WHERE user_id = {$user['user_id']}");
                    
                    if ($check_existing->num_rows > 0) {
                        // Update existing
                        $update_stmt = $db->prepare("
                            UPDATE shop_ai_user_ranks 
                            SET current_rank_id = ?, total_spending = ?, last_updated = NOW() 
                            WHERE user_id = ?
                        ");
                        $update_stmt->bind_param("iii", 
                            $user['rank']['rank_id'], 
                            $user['real_spending'], 
                            $user['user_id']
                        );
                        $update_stmt->execute();
                        echo "   🔄 Updated existing record\n";
                    } else {
                        // Insert new
                        $insert_stmt = $db->prepare("
                            INSERT INTO shop_ai_user_ranks 
                            (user_id, current_rank_id, total_spending, created_at, last_updated) 
                            VALUES (?, ?, ?, NOW(), NOW())
                        ");
                        $insert_stmt->bind_param("iii", 
                            $user['user_id'],
                            $user['rank']['rank_id'], 
                            $user['real_spending']
                        );
                        $insert_stmt->execute();
                        echo "   ➕ Created new record\n";
                    }
                    
                    $db->commit();
                    echo "   ✅ Success: {$user['rank']['rank_name']} {$user['rank']['rank_emoji']} (" . 
                         number_format($user['real_spending'], 0, ',', '.') . " VNĐ)\n";
                    $success_count++;
                    
                } catch (Exception $e) {
                    $db->rollback();
                    echo "   ❌ Error: " . $e->getMessage() . "\n";
                    $error_count++;
                }
                echo "\n";
            }
            
            echo "=== MIGRATION COMPLETED ===\n";
            echo "✅ Success: $success_count users\n";
            echo "❌ Errors: $error_count users\n";
            
        } else {
            echo "❌ Migration cancelled by user.\n";
        }
    } else {
        echo "✅ Tất cả user đã có dữ liệu chính xác.\n";
    }
    
} else {
    echo "❌ Không tìm thấy user nào có giao dịch Shop-AI.\n";
}

echo "\n🎉 HỆ THỐNG MỚI:\n";
echo "- ✅ Lấy total_spending từ shop_ai_user_ranks (cộng dồn)\n";
echo "- ✅ Mỗi giao dịch mới sẽ cộng/trừ vào total_spending\n";
echo "- ✅ Không cần tính lại từ đầu\n";
echo "- ✅ Nhanh hơn và chính xác hơn\n";

echo "\n=== END ===\n";
?>
