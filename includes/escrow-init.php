<?php
/**
 * escrow-init: tạo bảng giao dịch trung gian nếu chưa có
 */
if (!function_exists('escrow_ensure_tables')) {
  function escrow_ensure_tables($db) {
    $db->query("
      CREATE TABLE IF NOT EXISTS users_wallets_transactions (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED NOT NULL,
        type VARCHAR(50) NOT NULL,
        amount DECIMAL(15,2) NOT NULL DEFAULT 0,
        description VARCHAR(500) NULL,
        time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user (user_id),
        INDEX idx_type (type),
        INDEX idx_time (time)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
    $db->query("
      CREATE TABLE IF NOT EXISTS escrow_transactions (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        seller_id INT UNSIGNED NOT NULL,
        buyer_id INT UNSIGNED NOT NULL,
        title VARCHAR(500) NOT NULL,
        amount DECIMAL(15,2) NOT NULL,
        fee_percent DECIMAL(5,2) NOT NULL DEFAULT 5.00,
        fee_payer ENUM('buyer','seller','split') NOT NULL DEFAULT 'buyer',
        inspection_hours INT NOT NULL DEFAULT 24,
        status ENUM('pending_deposit','locked','delivering','completed','disputed','cancelled') NOT NULL DEFAULT 'pending_deposit',
        auto_release_at DATETIME NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_seller (seller_id),
        INDEX idx_buyer (buyer_id),
        INDEX idx_status (status)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
    @$db->query("ALTER TABLE escrow_transactions ADD COLUMN fee_payer ENUM('buyer','seller','split') NOT NULL DEFAULT 'buyer' AFTER fee_percent");
    @$db->query("ALTER TABLE escrow_transactions ADD COLUMN inspection_hours INT NOT NULL DEFAULT 24 AFTER fee_payer");
    $db->query("
      CREATE TABLE IF NOT EXISTS escrow_messages (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        transaction_id INT UNSIGNED NOT NULL,
        user_id INT UNSIGNED NOT NULL,
        message TEXT NULL,
        is_secret TINYINT(1) NOT NULL DEFAULT 0,
        secret_content TEXT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_tx (transaction_id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
    $db->query("
      CREATE TABLE IF NOT EXISTS escrow_conditions (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        transaction_id INT UNSIGNED NOT NULL,
        label VARCHAR(500) NOT NULL,
        is_checked TINYINT(1) NOT NULL DEFAULT 0,
        sort_order INT NOT NULL DEFAULT 0,
        INDEX idx_tx (transaction_id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
    $db->query("
      CREATE TABLE IF NOT EXISTS escrow_secret_views (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        transaction_id INT UNSIGNED NOT NULL,
        user_id INT UNSIGNED NOT NULL,
        viewed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY uq_tx_user (transaction_id, user_id),
        INDEX idx_tx (transaction_id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
    $db->query("
      CREATE TABLE IF NOT EXISTS escrow_disputes (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        transaction_id INT UNSIGNED NOT NULL,
        raised_by_user_id INT UNSIGNED NOT NULL,
        reason VARCHAR(255) NULL,
        description TEXT NULL,
        evidence_link VARCHAR(500) NULL,
        status ENUM('open','resolved') NOT NULL DEFAULT 'open',
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_tx (transaction_id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
  }
}
