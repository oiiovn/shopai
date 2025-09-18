<?php

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
            // Lấy tổng chi tiêu của user
            $stmt = $this->pdo->prepare("
                SELECT COALESCE(SUM(amount), 0) as total_spent 
                FROM users_wallets_transactions 
                WHERE user_id = ? AND type = 'spent'
            ");
            $stmt->execute([$user_id]);
            $total_spent = $stmt->fetch()['total_spent'] ?? 0;
            
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
     * Cập nhật rank của user
     */
    public function updateUserRank($user_id) {
        try {
            $current_rank = $this->getUserRank($user_id);
            
            // Kiểm tra xem đã có record trong shop_ai_user_ranks chưa
            $stmt = $this->pdo->prepare("
                SELECT * FROM shop_ai_user_ranks WHERE user_id = ?
            ");
            $stmt->execute([$user_id]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existing) {
                // Update existing record
                $stmt = $this->pdo->prepare("
                    UPDATE shop_ai_user_ranks 
                    SET rank_id = ?, total_spent = ?, updated_at = NOW() 
                    WHERE user_id = ?
                ");
                $stmt->execute([
                    $current_rank['rank_id'],
                    $current_rank['user_total_spent'],
                    $user_id
                ]);
            } else {
                // Insert new record
                $stmt = $this->pdo->prepare("
                    INSERT INTO shop_ai_user_ranks 
                    (user_id, rank_id, total_spent, created_at, updated_at) 
                    VALUES (?, ?, ?, NOW(), NOW())
                ");
                $stmt->execute([
                    $user_id,
                    $current_rank['rank_id'],
                    $current_rank['user_total_spent']
                ]);
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
