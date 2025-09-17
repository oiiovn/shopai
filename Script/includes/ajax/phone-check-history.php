<?php
// phone-check-history.php - API endpoint for phone check history with pagination

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include config
require_once '../config.php';

// Set JSON header
header('Content-Type: application/json');

// Handle CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? '';

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Functions
function getPhoneCheckHistory($checker_user_id, $limit = 5, $offset = 0, $status_filter = '', $search = '') {
    global $pdo;
    
    try {
        $where_conditions = ["checker_user_id = ?"];
        $params = [$checker_user_id];
        
        if (!empty($status_filter)) {
            $where_conditions[] = "status = ?";
            $params[] = $status_filter;
        }
        
        if (!empty($search)) {
            $where_conditions[] = "checked_username LIKE ?";
            $params[] = "%$search%";
        }
        
        $where_clause = implode(" AND ", $where_conditions);
        
        $sql = "SELECT * FROM phone_check_history WHERE $where_clause ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function getPhoneCheckHistoryCount($checker_user_id, $status_filter = '', $search = '') {
    global $pdo;
    
    try {
        $where_conditions = ["checker_user_id = ?"];
        $params = [$checker_user_id];
        
        if (!empty($status_filter)) {
            $where_conditions[] = "status = ?";
            $params[] = $status_filter;
        }
        
        if (!empty($search)) {
            $where_conditions[] = "checked_username LIKE ?";
            $params[] = "%$search%";
        }
        
        $where_clause = implode(" AND ", $where_conditions);
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM phone_check_history WHERE $where_clause");
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    } catch (PDOException $e) {
        return 0;
    }
}

function savePhoneCheckHistory($checker_user_id, $checked_username, $checked_user_id, $phone, $status, $result_message) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("INSERT INTO phone_check_history (checker_user_id, checked_username, checked_user_id, phone, status, result_message, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$checker_user_id, $checked_username, $checked_user_id, $phone, $status, $result_message]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

function updatePhoneCheckHistory($id, $phone, $status, $result_message) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("UPDATE phone_check_history SET phone = ?, status = ?, result_message = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$phone, $status, $result_message, $id]);
    } catch (PDOException $e) {
        return false;
    }
}

function simulatePhoneCheck($username) {
    $random = rand(1, 100);
    
    if ($random <= 60) {
        $phone = generateFakePhone();
        return [
            'success' => true,
            'phone' => $phone,
            'status' => 'success',
            'message' => 'Đã tìm thấy số điện thoại'
        ];
    } elseif ($random <= 90) {
        return [
            'success' => false,
            'phone' => null,
            'status' => 'not_found',
            'message' => 'Không tìm thấy số'
        ];
    } else {
        return [
            'success' => false,
            'phone' => null,
            'status' => 'error',
            'message' => 'Rate limited / API error'
        ];
    }
}

function generateFakePhone() {
    $prefixes = ['032', '033', '034', '035', '036', '037', '038', '039', 
                '056', '058', '059', '070', '076', '077', '078', '079',
                '081', '082', '083', '084', '085', '086', '087', '088', '089',
                '090', '091', '092', '093', '094', '095', '096', '097', '098', '099'];
    $prefix = $prefixes[array_rand($prefixes)];
    $number = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
    return $prefix . $number;
}

// Handle different actions
switch ($action) {
    case 'get_history':
        $user_id = $input['user_id'] ?? 1;
        $page = intval($input['page'] ?? 1);
        $limit = intval($input['limit'] ?? 5);
        $status_filter = $input['status_filter'] ?? '';
        $search = $input['search'] ?? '';
        
        $offset = ($page - 1) * $limit;
        
        $history = getPhoneCheckHistory($user_id, $limit, $offset, $status_filter, $search);
        $total = getPhoneCheckHistoryCount($user_id, $status_filter, $search);
        $total_pages = ceil($total / $limit);
        
        echo json_encode([
            'success' => true,
            'data' => $history,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_items' => $total,
                'items_per_page' => $limit
            ]
        ]);
        break;
        
    case 'check_phone':
        $user_id = $input['user_id'] ?? 1;
        $username = $input['username'] ?? '';
        
        if (empty($username)) {
            echo json_encode(['success' => false, 'message' => 'Username is required']);
            break;
        }
        
        // Chỉ lưu trạng thái "pending" - admin sẽ cập nhật sau
        $pending_id = savePhoneCheckHistory($user_id, $username, null, null, 'pending', 'Đang check...');
        
        if ($pending_id) {
            echo json_encode([
                'success' => true,
                'message' => 'Check request saved successfully',
                'data' => [
                    'id' => $pending_id,
                    'username' => $username,
                    'status' => 'pending',
                    'message' => 'Đang check...'
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save check request']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
?>
