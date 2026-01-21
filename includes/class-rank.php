<?php

require_once 'config.php';

/**
 * Rank System Class cho Shop-AI
 * 
 * @package Sngine
 * @author Zamblek
 */

class RankSystem {
    private $pdo;
    
    public function __construct() {
        $this->pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    /**
     * Lấy tất cả ranks theo thứ tự
     */
    public function getAllRanks() {
        try {
            $stmt = $this->pdo->query("
                SELECT * FROM shop_ai_ranks 
                WHERE is_active = 1 
                ORDER BY rank_order ASC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting ranks: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Lấy rank của user dựa trên tổng chi tiêu
     */
    public function getUserRank($user_id) {
        try {
            // Lấy tổng chi tiêu từ bảng shop_ai_user_ranks (đã được cộng dồn)
            $stmt = $this->pdo->prepare("
                SELECT total_spending as total_spent
                FROM shop_ai_user_ranks 
                WHERE user_id = ?
            ");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_spent = $result['total_spent'] ?? 0;
            
            // Tìm rank phù hợp
            $stmt = $this->pdo->prepare("
                SELECT * FROM shop_ai_ranks 
                WHERE is_active = 1 AND min_spending <= ? 
                ORDER BY min_spending DESC 
                LIMIT 1
            ");
            $stmt->execute([$total_spent]);
            $rank = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($rank) {
                $rank['user_total_spent'] = $total_spent;
                $rank['next_rank'] = $this->getNextRank($total_spent);
                return $rank;
            }
            
            // Fallback to Bronze rank
            return $this->getDefaultRank();
            
        } catch (PDOException $e) {
            error_log("Error getting user rank: " . $e->getMessage());
            return $this->getDefaultRank();
        }
    }
    
    /**
     * Lấy rank tiếp theo
     */
    public function getNextRank($current_spending) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM shop_ai_ranks 
                WHERE is_active = 1 AND min_spending > ? 
                ORDER BY min_spending ASC 
                LIMIT 1
            ");
            $stmt->execute([$current_spending]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
    
    /**
     * Lấy rank mặc định (Bronze)
     */
    public function getDefaultRank() {
        try {
            $stmt = $this->pdo->query("
                SELECT * FROM shop_ai_ranks 
                WHERE is_active = 1 
                ORDER BY rank_order ASC 
                LIMIT 1
            ");
            $rank = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rank) {
                $rank['user_total_spent'] = 0;
                $rank['next_rank'] = $this->getNextRank(0);
            }
            return $rank;
        } catch (PDOException $e) {
            return [
                'rank_name' => 'Bronze',
                'rank_emoji' => '🥉',
                'check_price' => 30000,
                'min_spending' => 0,
                'user_total_spent' => 0,
                'next_rank' => null
            ];
        }
    }
    
    /**
     * Cập nhật rank của user (cộng dồn từ giao dịch mới nhất)
     */
    public function updateUserRank($user_id) {
        try {
            // Lấy giao dịch mới nhất (ưu tiên withdraw)
            $stmt = $this->pdo->prepare("
                SELECT amount, type, description
                FROM users_wallets_transactions 
                WHERE user_id = ? 
                AND (description LIKE '%Check số Shopee%' OR description LIKE '%Hoàn tiền check số thất bại%')
                ORDER BY transaction_id DESC 
                LIMIT 1
            ");
            $stmt->execute([$user_id]);
            $latest_transaction = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$latest_transaction) {
                error_log("No recent Shop-AI transaction found for user $user_id");
                return false;
            }
            
            // Kiểm tra user đã có record trong shop_ai_user_ranks chưa
            $stmt = $this->pdo->prepare("SELECT * FROM shop_ai_user_ranks WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existing) {
                // SỬ DỤNG total_spending hiện có (đã được cập nhật bởi shop-ai.php)
                $new_spending = $existing['total_spending'];
                
                // KHÔNG cần cộng/trừ gì thêm vì shop-ai.php đã xử lý rồi
                error_log("User $user_id: Sử dụng total_spending hiện có: {$new_spending} VNĐ");
                
                // Tìm rank phù hợp với tổng chi tiêu mới
                $rank_stmt = $this->pdo->prepare("
                    SELECT * FROM shop_ai_ranks 
                    WHERE is_active = 1 AND min_spending <= ? 
                    ORDER BY min_spending DESC 
                    LIMIT 1
                ");
                $rank_stmt->execute([$new_spending]);
                $new_rank = $rank_stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$new_rank) {
                    // Fallback to Bronze rank
                    $rank_stmt = $this->pdo->prepare("
                        SELECT * FROM shop_ai_ranks 
                        WHERE is_active = 1 
                        ORDER BY rank_order ASC 
                        LIMIT 1
                    ");
                    $rank_stmt->execute();
                    $new_rank = $rank_stmt->fetch(PDO::FETCH_ASSOC);
                }
                
                // CHỈ CẬP NHẬT KHI RANK CAO HƠN
                if ($new_rank['rank_id'] > $existing['current_rank_id']) {
                    // Update existing record với rank mới
                    $update_stmt = $this->pdo->prepare("
                        UPDATE shop_ai_user_ranks 
                        SET current_rank_id = ?, total_spending = ?, last_updated = NOW() 
                        WHERE user_id = ?
                    ");
                    $update_stmt->execute([
                        $new_rank['rank_id'],
                        $new_spending,
                        $user_id
                    ]);
                    
                    error_log("User $user_id upgraded to rank {$new_rank['rank_name']} (ID: {$new_rank['rank_id']})");
                } else {
                    // CHỈ CẬP NHẬT TOTAL_SPENDING, KHÔNG ĐỔI RANK
                    $update_stmt = $this->pdo->prepare("
                        UPDATE shop_ai_user_ranks 
                        SET total_spending = ?, last_updated = NOW() 
                        WHERE user_id = ?
                    ");
                    $update_stmt->execute([
                        $new_spending,
                        $user_id
                    ]);
                    
                    error_log("User $user_id: Updated spending to {$new_spending} VNĐ (rank unchanged)");
                }
                
            } else {
                // Insert new record với chi tiêu từ giao dịch đầu tiên
                $initial_spending = 0;
                if ($latest_transaction['type'] == 'withdraw' && strpos($latest_transaction['description'], 'Check số Shopee') !== false) {
                    $initial_spending = $latest_transaction['amount'];
                }
                
                // Tìm rank phù hợp
                $rank_stmt = $this->pdo->prepare("
                    SELECT * FROM shop_ai_ranks 
                    WHERE is_active = 1 AND min_spending <= ? 
                    ORDER BY min_spending DESC 
                    LIMIT 1
                ");
                $rank_stmt->execute([$initial_spending]);
                $new_rank = $rank_stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$new_rank) {
                    // Fallback to Bronze rank
                    $rank_stmt = $this->pdo->prepare("
                        SELECT * FROM shop_ai_ranks 
                        WHERE is_active = 1 
                        ORDER BY rank_order ASC 
                        LIMIT 1
                    ");
                    $rank_stmt->execute();
                    $new_rank = $rank_stmt->fetch(PDO::FETCH_ASSOC);
                }
                
                // Insert new record
                $insert_stmt = $this->pdo->prepare("
                    INSERT INTO shop_ai_user_ranks 
                    (user_id, current_rank_id, total_spending, created_at, last_updated) 
                    VALUES (?, ?, ?, NOW(), NOW())
                ");
                $insert_stmt->execute([
                    $user_id,
                    $new_rank['rank_id'],
                    $initial_spending
                ]);
                
                error_log("User $user_id created with rank {$new_rank['rank_name']} (ID: {$new_rank['rank_id']})");
            }
            
            return true;
        } catch (PDOException $e) {
            error_log("Error updating user rank: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy progress đến rank tiếp theo
     */
    public function getRankProgress($user_id) {
        $current_rank = $this->getUserRank($user_id);
        $next_rank = $current_rank['next_rank'];
        
        if (!$next_rank) {
            return [
                'current' => $current_rank,
                'next' => null,
                'progress_percent' => 100,
                'remaining_amount' => 0
            ];
        }
        
        $current_spent = $current_rank['user_total_spent'];
        $current_min = $current_rank['min_spending'];
        $next_min = $next_rank['min_spending'];
        
        $progress = ($current_spent - $current_min) / ($next_min - $current_min) * 100;
        $remaining = $next_min - $current_spent;
        
        return [
            'current' => $current_rank,
            'next' => $next_rank,
            'progress_percent' => min(100, max(0, $progress)),
            'remaining_amount' => max(0, $remaining)
        ];
    }
}
