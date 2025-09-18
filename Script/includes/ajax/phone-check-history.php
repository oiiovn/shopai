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

// Functions for payment handling
function checkUserBalance($user_id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT user_wallet_balance FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? floatval($result['user_wallet_balance']) : 0;
    } catch (PDOException $e) {
        return 0;
    }
}

function getUserCheckPrice($user_id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            SELECT sr.check_price 
            FROM shop_ai_user_ranks sur 
            LEFT JOIN shop_ai_ranks sr ON sur.current_rank_id = sr.rank_id 
            WHERE sur.user_id = ?
        ");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Default price if no rank found
        return $result ? floatval($result['check_price']) : 30000;
    } catch (PDOException $e) {
        return 30000; // Default price
    }
}

function deductWalletBalance($user_id, $amount, $description) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Check current balance
        $stmt = $pdo->prepare("SELECT user_wallet_balance FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $current_balance = $stmt->fetch(PDO::FETCH_ASSOC)['user_wallet_balance'];
        
        if ($current_balance < $amount) {
            $pdo->rollBack();
            return [
                'success' => false,
                'message' => 'Số dư không đủ. Cần: ' . number_format($amount, 0, ',', '.') . ' VNĐ, Hiện có: ' . number_format($current_balance, 0, ',', '.') . ' VNĐ'
            ];
        }
        
        // Deduct balance
        $stmt = $pdo->prepare("UPDATE users SET user_wallet_balance = user_wallet_balance - ? WHERE user_id = ?");
        $stmt->execute([$amount, $user_id]);
        
        // Create transaction record in users_wallets_transactions (same as shop-ai)
        $stmt = $pdo->prepare("
            INSERT INTO users_wallets_transactions (user_id, amount, type, time, description) 
            VALUES (?, ?, 'withdraw', NOW(), ?)
        ");
        $stmt->execute([$user_id, $amount, $description]);
        
        $pdo->commit();
        
        return [
            'success' => true,
            'message' => 'Đã trừ ' . number_format($amount, 0, ',', '.') . ' VNĐ',
            'transaction_id' => $pdo->lastInsertId(),
            'new_balance' => $current_balance - $amount
        ];
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        return [
            'success' => false,
            'message' => 'Lỗi khi trừ tiền: ' . $e->getMessage()
        ];
    }
}

function refundWalletBalance($user_id, $amount, $description) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Add balance back
        $stmt = $pdo->prepare("UPDATE users SET user_wallet_balance = user_wallet_balance + ? WHERE user_id = ?");
        $stmt->execute([$amount, $user_id]);
        
        // Create refund transaction record in users_wallets_transactions (same as shop-ai)
        $stmt = $pdo->prepare("
            INSERT INTO users_wallets_transactions (user_id, amount, type, time, description) 
            VALUES (?, ?, 'recharge', NOW(), ?)
        ");
        $stmt->execute([$user_id, $amount, $description]);
        
        $pdo->commit();
        
        return [
            'success' => true,
            'message' => 'Đã hoàn ' . number_format($amount, 0, ',', '.') . ' VNĐ',
            'transaction_id' => $pdo->lastInsertId()
        ];
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        return [
            'success' => false,
            'message' => 'Lỗi khi hoàn tiền: ' . $e->getMessage()
        ];
    }
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


// Function to call checkso.pro API with real response waiting
function callChecksoAPI($username, $phone = '99') {
    $api_token = '8d3b77d956264a950f28224928c7390941eedd0180f87de4a487edbaf80b3841';
    $endpoint = 'http://checkso.pro/search_users_advanced';
    
    $data = [
        'api' => $api_token,
        'username' => $username,
        'phone' => $phone
    ];
    
    // Initialize cURL with proper settings for real API waiting
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($data)),
        'User-Agent: Shop-AI/1.0'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300); // 5 minutes timeout - wait as long as needed
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); // Connection timeout
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    // Execute the request and wait for real response
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);
    
    // Handle cURL errors
    if ($response === false || !empty($curl_error)) {
        return [
            'success' => false,
            'message' => 'Lỗi kết nối API: ' . $curl_error,
            'data' => null
        ];
    }
    
    // Handle HTTP errors
    if ($http_code !== 200) {
        return [
            'success' => false,
            'message' => 'API trả về lỗi HTTP: ' . $http_code,
            'data' => null
        ];
    }
    
    // Parse JSON response
    $result = json_decode($response, true);
    
    if (!$result || !isset($result['status'])) {
        return [
            'success' => false,
            'message' => 'Phản hồi API không hợp lệ',
            'data' => null
        ];
    }
    
    // Return real API response
    return [
        'success' => $result['status'] == 1,
        'message' => $result['status'] == 1 ? 'Check thành công' : 'Không tìm thấy thông tin',
        'data' => $result
    ];
}

// Handle different actions
switch ($action) {
    case 'check_phone_api':
        $user_id = intval($input['user_id'] ?? 0);
        $username = trim($input['username'] ?? '');
        
        if (!$user_id || !$username) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin']);
            exit();
        }
        
        // Step 1: Get user's check price based on rank
        $check_price = getUserCheckPrice($user_id);
        
        // Step 2: Check user balance
        $current_balance = checkUserBalance($user_id);
        if ($current_balance < $check_price) {
            echo json_encode([
                'success' => false, 
                'message' => 'Số dư không đủ! Cần: ' . number_format($check_price, 0, ',', '.') . ' VNĐ, Hiện có: ' . number_format($current_balance, 0, ',', '.') . ' VNĐ',
                'required_amount' => $check_price,
                'current_balance' => $current_balance
            ]);
            exit();
        }
        
        // Step 3: Deduct money first
        $deduct_result = deductWalletBalance($user_id, $check_price, 'Check số Shopee: ' . $username);
        if (!$deduct_result['success']) {
            echo json_encode($deduct_result);
            exit();
        }
        
        // Step 4: Save pending record
        $stmt = $pdo->prepare("INSERT INTO phone_check_history (checker_user_id, checked_username, checked_user_id, phone, status, result_message, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id, $username, null, null, 'pending', 'Đang chờ API response...']);
        $pending_id = $pdo->lastInsertId();
        
        // Step 5: Call checkso.pro API and wait for real response
        $api_result = callChecksoAPI($username, '99');
        
        // Step 6: Process API result
        if ($api_result['success'] && isset($api_result['data']['records']) && count($api_result['data']['records']) > 0) {
            // Success - found phone number (keep the deducted money)
            $phone_data = $api_result['data']['records'][0];
            $phone_number = $phone_data['result'];
            
            $stmt = $pdo->prepare("UPDATE phone_check_history SET phone = ?, status = ?, result_message = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$phone_number, 'success', 'Check thành công: ' . $phone_number, $pending_id]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Check thành công!',
                'phone' => $phone_number,
                'username' => $username,
                'api_balance' => $api_result['data']['new_balance'] ?? 'N/A',
                'record_id' => $pending_id,
                'status' => 'success',
                'check_price' => $check_price,
                'new_balance' => $deduct_result['new_balance']
            ]);
        } else {
            // Not found or API error - REFUND the money
            $error_message = $api_result['message'] ?? 'Không tìm thấy số điện thoại';
            
            // Refund the money
            $refund_result = refundWalletBalance($user_id, $check_price, 'Hoàn tiền check số thất bại: ' . $username);
            
            $stmt = $pdo->prepare("UPDATE phone_check_history SET status = ?, result_message = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute(['not_found', $error_message . ' (Đã hoàn tiền)', $pending_id]);
            
            echo json_encode([
                'success' => false,
                'message' => $error_message . ' - Đã hoàn tiền',
                'username' => $username,
                'api_balance' => $api_result['data']['new_balance'] ?? 'N/A',
                'record_id' => $pending_id,
                'status' => 'not_found',
                'refund_amount' => $check_price,
                'refund_success' => $refund_result['success']
            ]);
        }
        break;
        
    case 'get_check_info':
        $user_id = intval($input['user_id'] ?? 0);
        
        if (!$user_id) {
            echo json_encode(['success' => false, 'message' => 'Thiếu user_id']);
            exit();
        }
        
        // Get user's current balance and check price
        $current_balance = checkUserBalance($user_id);
        $check_price = getUserCheckPrice($user_id);
        
        echo json_encode([
            'success' => true,
            'current_balance' => $current_balance,
            'check_price' => $check_price,
            'can_check' => $current_balance >= $check_price,
            'formatted_balance' => number_format($current_balance, 0, ',', '.') . ' VNĐ',
            'formatted_price' => number_format($check_price, 0, ',', '.') . ' VNĐ'
        ]);
        break;
        
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
        
        // Redirect to check_phone_api for real API call
        echo json_encode(['success' => false, 'message' => 'Use check_phone_api action instead']);
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
?>
