<?php
/**
 * Bank Transaction AJAX Handler
 * Xử lý AJAX cho tab giao dịch
 */

// Include system files
require_once('../../bootloader.php');

// Check if user is logged in (tạm thời comment để test)
// if (!$user->_logged_in) {
//     http_response_code(401);
//     echo json_encode(['success' => false, 'message' => 'Unauthorized']);
//     exit;
// }

// Get action
$action = $_POST['action'] ?? '';

switch ($action) {
    case 'get_transactions':
        getTransactions();
        break;
    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

function getTransactions() {
    global $user, $db;
    
    try {
        // Get parameters
        $search = $_POST['search'] ?? '';
        $fromDate = $_POST['from_date'] ?? '';
        $toDate = $_POST['to_date'] ?? '';
        $page = intval($_POST['page'] ?? 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        // Build query
        $whereConditions = ['user_id = ?'];
        $params = [1]; // Sử dụng user_id = 1 để test
        $paramTypes = 'i';
        
        if (!empty($search)) {
            $whereConditions[] = '(description LIKE ? OR transaction_id LIKE ?)';
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
        error_log("Get Transactions Error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi khi tải dữ liệu giao dịch'
        ]);
    }
}
?>
