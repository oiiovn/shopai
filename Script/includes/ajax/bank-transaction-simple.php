<?php
/**
 * Bank Transaction AJAX Handler (Simple Version)
 * Xử lý AJAX cho tab giao dịch - bắt buộc đăng nhập
 */

require_once('../../bootloader.php');

header('Content-Type: application/json');

// Kết nối database trực tiếp
$host = '127.0.0.1';
$port = '3306';
$dbname = 'db_mxh';
$username = 'root';
$password = '';

try {
    $db = new mysqli($host, $username, $password, $dbname, $port);
    
    if ($db->connect_error) {
        throw new Exception("Kết nối thất bại: " . $db->connect_error);
    }
    
    // Get action
    $action = $_POST['action'] ?? '';
    
    if ($action === 'get_transactions') {
        getTransactions($db);
    } elseif ($action === 'get_balance') {
        getBalance($db);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

function getBalance($db) {
    try {
    $userId = $_POST['user_id'] ?? 1;
        
        $stmt = $db->prepare("SELECT balance FROM users WHERE user_id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            echo json_encode(['success' => true, 'balance' => $row['balance']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy user']);
        }
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi khi tải số dư: ' . $e->getMessage()]);
    }
}

function getTransactions($db) {
    try {
        // Get parameters
        $search = $_POST['search'] ?? '';
        $fromDate = $_POST['from_date'] ?? '';
        $toDate = $_POST['to_date'] ?? '';
        $page = intval($_POST['page'] ?? 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        // Get user_id from session
    $userId = $_POST['user_id'] ?? 1;
        
        // Build query
        $whereConditions = ['user_id = ?'];
        $params = [$userId];
        $paramTypes = 'i';
        
        if (!empty($search)) {
            $whereConditions[] = '(description LIKE ? OR reference LIKE ?)';
            $searchTerm = '%' . $search . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $paramTypes .= 'ss';
        }
        
        if (!empty($fromDate)) {
            $whereConditions[] = 'DATE(created_at) >= ?';
            $params[] = $fromDate;
            $paramTypes .= 's';
        }
        
        if (!empty($toDate)) {
            $whereConditions[] = 'DATE(created_at) <= ?';
            $params[] = $toDate;
            $paramTypes .= 's';
        }
        
        $whereClause = implode(' AND ', $whereConditions);
        
        // Get total count
        $countQuery = "SELECT COUNT(*) as total FROM balance_transactions WHERE $whereClause";
        $countStmt = $db->prepare($countQuery);
        $countStmt->bind_param($paramTypes, ...$params);
        $countStmt->execute();
        $totalRecords = $countStmt->get_result()->fetch_assoc()['total'];
        $totalPages = ceil($totalRecords / $limit);
        
        // Get transactions
        $query = "SELECT * FROM balance_transactions WHERE $whereClause ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $paramTypes .= 'ii';
        
        $stmt = $db->prepare($query);
        $stmt->bind_param($paramTypes, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $transactions[] = [
                'id' => $row['id'],
                'transaction_id' => $row['reference'],
                'type' => $row['transaction_type'] === 'deposit' ? 'credit' : 'debit',
                'amount' => $row['amount'],
                'balance_after' => $row['balance_after'],
                'description' => $row['description'],
                'status' => $row['status'],
                'created_at' => date('d/m/Y H:i', strtotime($row['created_at']))
            ];
        }
        
        // Response
        echo json_encode([
            'success' => true,
            'data' => [
                'transactions' => $transactions,
                'pagination' => [
                    'current_page' => $page,
                    'total_pages' => $totalPages,
                    'total_records' => $totalRecords,
                    'per_page' => $limit
                ]
            ]
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi khi tải dữ liệu giao dịch: ' . $e->getMessage()
        ]);
    }
}
?>
