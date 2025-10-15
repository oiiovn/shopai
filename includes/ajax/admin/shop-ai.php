<?php
/**
 * AJAX Handler for Shop-AI Admin
 */

// fetch bootloader
require('../../../bootloader.php');

// check admin permission
if (!$user->_is_admin) {
    _error(403);
}

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'check_withdrawal_updates':
        // Get current pending withdrawals count
        $get_pending = $db->query("
            SELECT COUNT(*) as count 
            FROM qr_code_mapping 
            WHERE transaction_type = 'withdrawal' 
            AND status = 'active' 
            AND expires_at > NOW()
        ");
        
        $pending_count = 0;
        if ($get_pending) {
            $result = $get_pending->fetch_assoc();
            $pending_count = intval($result['count']);
        }
        
        echo json_encode([
            'success' => true,
            'pending_count' => $pending_count
        ]);
        break;
        
    case 'get_withdrawal_details':
        $qr_code = $_POST['qr_code'] ?? '';
        
        if (empty($qr_code)) {
            echo json_encode(['success' => false, 'error' => 'Missing QR code']);
            break;
        }
        
        $get_withdrawal = $db->query(sprintf("
            SELECT * FROM qr_code_mapping 
            WHERE qr_code = '%s' AND transaction_type = 'withdrawal'
            LIMIT 1
        ", $db->real_escape_string($qr_code)));
        
        if ($get_withdrawal && $get_withdrawal->num_rows > 0) {
            $withdrawal = $get_withdrawal->fetch_assoc();
            echo json_encode([
                'success' => true,
                'data' => $withdrawal
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Withdrawal not found']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        break;
}

