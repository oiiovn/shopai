<?php

/**
 * Cronjob tự động cập nhật rank Shop-AI cho users
 * Chạy mỗi 5 phút để kiểm tra và cập nhật rank dựa trên chi tiêu
 * 
 * @package Sngine
 * @author Zamblek
 */

// Set time limit for cronjob
set_time_limit(300); // 5 minutes max

// Include config
require_once 'includes/config.php';

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Rank update cronjob: Database connection failed - " . $e->getMessage());
    exit(1);
}

// Include RankSystem class
require_once 'includes/class-rank.php';

echo "=== Shop-AI Rank Update Cronjob Started ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n";

try {
    $rankSystem = new RankSystem();
    $updated_count = 0;
    $error_count = 0;
    
    // Get all users who have Shop-AI transactions (last 7 days)
    $stmt = $pdo->query("
        SELECT DISTINCT user_id 
        FROM users_wallets_transactions 
        WHERE type = 'withdraw' 
        AND description LIKE '%Check số Shopee%'
        AND time >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        ORDER BY user_id
    ");
    
    $user_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Found " . count($user_ids) . " users with recent Shop-AI transactions\n";
    
    foreach ($user_ids as $user_id) {
        try {
            // Get current rank data
            $current_rank_stmt = $pdo->prepare("
                SELECT sur.*, sr.rank_name, sr.check_price 
                FROM shop_ai_user_ranks sur 
                LEFT JOIN shop_ai_ranks sr ON sur.current_rank_id = sr.rank_id 
                WHERE sur.user_id = ?
            ");
            $current_rank_stmt->execute([$user_id]);
            $current_rank_data = $current_rank_stmt->fetch(PDO::FETCH_ASSOC);
            
            // Calculate current total spending (trừ đi hoàn tiền)
            $spending_stmt = $pdo->prepare("
                SELECT 
                    (SELECT COALESCE(SUM(amount), 0) FROM users_wallets_transactions 
                     WHERE user_id = ? AND type = 'withdraw' AND description LIKE '%Check số Shopee%') as total_spent,
                    (SELECT COALESCE(SUM(amount), 0) FROM users_wallets_transactions 
                     WHERE user_id = ? AND type = 'recharge' AND description LIKE '%Hoàn tiền check số thất bại%') as total_refunded
            ");
            $spending_stmt->execute([$user_id, $user_id]);
            $spending_result = $spending_stmt->fetch(PDO::FETCH_ASSOC);
            $total_spent = ($spending_result['total_spent'] ?? 0) - ($spending_result['total_refunded'] ?? 0);
            
            // Get what rank user should have based on spending
            $target_rank_stmt = $pdo->prepare("
                SELECT * FROM shop_ai_ranks 
                WHERE is_active = 1 AND min_spending <= ? 
                ORDER BY min_spending DESC 
                LIMIT 1
            ");
            $target_rank_stmt->execute([$total_spent]);
            $target_rank = $target_rank_stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$target_rank) {
                // Fallback to Bronze rank
                $target_rank_stmt = $pdo->prepare("
                    SELECT * FROM shop_ai_ranks 
                    WHERE is_active = 1 
                    ORDER BY rank_order ASC 
                    LIMIT 1
                ");
                $target_rank_stmt->execute();
                $target_rank = $target_rank_stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            // Check if rank needs updating
            $needs_update = false;
            if (!$current_rank_data) {
                $needs_update = true;
                echo "User $user_id: No rank data found, setting to " . $target_rank['rank_name'] . "\n";
            } elseif ($current_rank_data['current_rank_id'] != $target_rank['rank_id']) {
                $needs_update = true;
                echo "User $user_id: Rank upgrade from " . $current_rank_data['rank_name'] . " to " . $target_rank['rank_name'] . " (Spent: " . number_format($total_spent, 0, ',', '.') . " VNĐ)\n";
            } elseif ($current_rank_data['total_spending'] != $total_spent) {
                $needs_update = true;
                echo "User $user_id: Updating spending from " . number_format($current_rank_data['total_spending'], 0, ',', '.') . " to " . number_format($total_spent, 0, ',', '.') . " VNĐ\n";
            }
            
            if ($needs_update) {
                // Update or insert rank data
                if ($current_rank_data) {
                    // Update existing record
                    $update_stmt = $pdo->prepare("
                        UPDATE shop_ai_user_ranks 
                        SET current_rank_id = ?, total_spending = ?, last_updated = NOW() 
                        WHERE user_id = ?
                    ");
                    $update_stmt->execute([$target_rank['rank_id'], $total_spent, $user_id]);
                } else {
                    // Insert new record
                    $insert_stmt = $pdo->prepare("
                        INSERT INTO shop_ai_user_ranks 
                        (user_id, current_rank_id, total_spending, created_at, last_updated) 
                        VALUES (?, ?, ?, NOW(), NOW())
                    ");
                    $insert_stmt->execute([$user_id, $target_rank['rank_id'], $total_spent]);
                }
                
                $updated_count++;
            }
            
        } catch (Exception $e) {
            $error_count++;
            error_log("Rank update cronjob: Error updating user $user_id - " . $e->getMessage());
            echo "Error updating user $user_id: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n=== Rank Update Summary ===\n";
    echo "Users processed: " . count($user_ids) . "\n";
    echo "Users updated: $updated_count\n";
    echo "Errors: $error_count\n";
    echo "Completed at: " . date('Y-m-d H:i:s') . "\n";
    
} catch (Exception $e) {
    error_log("Rank update cronjob: Fatal error - " . $e->getMessage());
    echo "Fatal error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "=== Shop-AI Rank Update Cronjob Completed ===\n";
exit(0);
