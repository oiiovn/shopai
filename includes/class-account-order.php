<?php

/**
 * Account Order Handler
 * 
 * Class để xử lý đơn hàng mua tài khoản
 * 
 * @package Sngine
 * @author ShopAI Team
 */

class AccountOrderHandler {
    
    private $db;
    
    public function __construct() {
        global $db;
        $this->db = $db;
    }
    
    /**
     * Tạo đơn hàng mua tài khoản
     * 
     * @param int $user_id
     * @param int $category_id
     * @param int $quantity
     * @return array
     */
    public function createOrder($user_id, $category_id, $quantity) {
        try {
            // Validate
            if ($quantity < 1 || $quantity > 100) {
                return ['success' => false, 'message' => 'Số lượng không hợp lệ (1-100)'];
            }
            
            // Get category info
            $catQuery = sprintf("SELECT * FROM account_categories WHERE category_id = %s AND is_active = '1'", secure($category_id, 'int'));
            $catResult = $this->db->query($catQuery);
            
            if (!$catResult || $catResult->num_rows == 0) {
                return ['success' => false, 'message' => 'Danh mục không tồn tại hoặc đã bị vô hiệu'];
            }
            
            $category = $catResult->fetch_assoc();
            
            // Get user balance
            $userQuery = sprintf("SELECT user_wallet_balance FROM users WHERE user_id = %s", secure($user_id, 'int'));
            $userResult = $this->db->query($userQuery);
            $user = $userResult->fetch_assoc();
            $balance = floatval($user['user_wallet_balance'] ?? 0);
            
            // Calculate total price
            $unit_price = floatval($category['category_price']);
            $total_price = $unit_price * $quantity;
            
            // Check balance
            if ($balance < $total_price) {
                return ['success' => false, 'message' => 'Số dư không đủ. Vui lòng nạp thêm ' . number_format($total_price - $balance, 0, ',', '.') . ' đ'];
            }
            
            // Start transaction - đếm và chọn trong cùng transaction để tránh race condition
            $this->db->query("START TRANSACTION");
            
            try {
                $qtyInt = intval($quantity);
                $accountsQuery = sprintf("SELECT AccMarketID FROM market_accounts WHERE category_id = %s AND Status = 'available' ORDER BY CreatedAt ASC LIMIT %d FOR UPDATE", 
                    secure($category_id, 'int'),
                    $qtyInt
                );
                $accountsResult = $this->db->query($accountsQuery);
                
                if (!$accountsResult) {
                    $this->db->query("ROLLBACK");
                    return ['success' => false, 'message' => 'Lỗi truy vấn: ' . $this->db->error];
                }
                if ($accountsResult->num_rows < $quantity) {
                    $this->db->query("ROLLBACK");
                    $countRow = $this->db->query(sprintf("SELECT COUNT(*) as c FROM market_accounts WHERE category_id = %s AND Status = 'available'", secure($category_id, 'int')));
                    $actualCount = $countRow && ($r = $countRow->fetch_assoc()) ? $r['c'] : 0;
                    return ['success' => false, 'message' => "Chỉ còn {$actualCount} tài khoản trong kho. Vui lòng chọn số lượng nhỏ hơn hoặc thử lại sau."];
                }
                
                $account_ids = [];
                while ($row = $accountsResult->fetch_assoc()) {
                    $account_ids[] = $row['AccMarketID'];
                }
                
                // Create order
                $orderQuery = sprintf("INSERT INTO account_orders 
                    (user_id, category_id, quantity, unit_price, total_price, status, created_at) 
                    VALUES (%s, %s, %s, %s, %s, 'pending', NOW())",
                    secure($user_id, 'int'),
                    secure($category_id, 'int'),
                    secure($quantity, 'int'),
                    secure($unit_price, 'float'),
                    secure($total_price, 'float')
                );
                
                if (!$this->db->query($orderQuery)) {
                    $this->db->query("ROLLBACK");
                    return ['success' => false, 'message' => 'Lỗi khi tạo đơn hàng: ' . $this->db->error];
                }
                
                $order_id = $this->db->insert_id;
                
                // Deduct balance
                $deductQuery = sprintf("UPDATE users SET user_wallet_balance = user_wallet_balance - %s WHERE user_id = %s", 
                    secure($total_price, 'float'),
                    secure($user_id, 'int')
                );
                
                if (!$this->db->query($deductQuery)) {
                    $this->db->query("ROLLBACK");
                    return ['success' => false, 'message' => 'Lỗi khi trừ tiền: ' . $this->db->error];
                }
                
                // Create order items and mark accounts as sold
                foreach ($account_ids as $account_id) {
                    // Insert order item
                    $itemQuery = sprintf("INSERT INTO account_order_items (order_id, account_id, price) VALUES (%s, %s, %s)",
                        secure($order_id, 'int'),
                        secure($account_id, 'int'),
                        secure($unit_price, 'float')
                    );
                    $this->db->query($itemQuery);
                    
                    // Mark account as sold
                    $updateQuery = sprintf("UPDATE market_accounts SET Status = 'sold', SoldTo = %s, SoldAt = NOW() WHERE AccMarketID = %s",
                        secure($user_id, 'int'),
                        secure($account_id, 'int')
                    );
                    $this->db->query($updateQuery);
                }
                
                // Update order status to paid
                $updateOrderQuery = sprintf("UPDATE account_orders SET status = 'paid', paid_at = NOW() WHERE order_id = %s", secure($order_id, 'int'));
                $this->db->query($updateOrderQuery);
                
                // Record transaction
                $transQuery = sprintf("INSERT INTO users_wallets_transactions (user_id, type, amount, description, time) VALUES (%s, 'send', %s, %s, NOW())",
                    secure($user_id, 'int'),
                    secure($total_price, 'float'),
                    secure("Mua {$quantity} tài khoản {$category['category_name']} - Đơn hàng #{$order_id}")
                );
                $this->db->query($transQuery);
                
                $this->db->query("COMMIT");
                
                return [
                    'success' => true,
                    'message' => 'Đặt hàng thành công!',
                    'order_id' => $order_id,
                    'redirect_url' => '/buy-account?view=order&order_id=' . $order_id
                ];
                
            } catch (Exception $e) {
                $this->db->query("ROLLBACK");
                return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
            }
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }
    
    /**
     * Hoàn thành đơn hàng (sau khi thanh toán)
     * 
     * @param int $order_id
     * @param int $user_id
     * @return bool
     */
    public function completeOrder($order_id, $user_id) {
        $query = sprintf("UPDATE account_orders SET status = 'completed', completed_at = NOW() WHERE order_id = %s AND user_id = %s AND status = 'paid'",
            secure($order_id, 'int'),
            secure($user_id, 'int')
        );
        
        return $this->db->query($query);
    }
    
    /**
     * Lấy thông tin đơn hàng
     * 
     * @param int $order_id
     * @param int $user_id
     * @return array|null
     */
    public function getOrder($order_id, $user_id) {
        $query = sprintf("SELECT o.*, c.category_name, c.category_image 
            FROM account_orders o 
            LEFT JOIN account_categories c ON o.category_id = c.category_id 
            WHERE o.order_id = %s AND o.user_id = %s",
            secure($order_id, 'int'),
            secure($user_id, 'int')
        );
        
        $result = $this->db->query($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
}
