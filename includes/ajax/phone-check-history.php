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
        
        // Update user rank immediately after Shop-AI transaction
        try {
            require_once '../../includes/class-rank.php';
            $rankSystem = new RankSystem();
            $rankSystem->updateUserRank($user_id);
        } catch (Exception $e) {
            error_log("Rank update error for user $user_id: " . $e->getMessage());
        }
        
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
    $api_token = '1770dd4e380567afd3668f8a9be69c21c587e08da9c5b75b5269174291ec7076';
    
    // Try HTTPS endpoint
    $endpoints = [
        'https://checkso.pro/search_users_advanced'
    ];
    
    $data = [
        'api' => $api_token,
        'username' => $username,
        'phone' => $phone
    ];
    
    $last_error = '';
    
    // Try each endpoint
    foreach ($endpoints as $endpoint) {
        // Initialize cURL with proper settings
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90); // Shorter timeout to match PHP limits
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); // Connection timeout
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_ENCODING, ''); // Accept all encodings
        
        // Execute the request
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        $curl_errno = curl_errno($ch);
        curl_close($ch);
        
        // Log attempt
        error_log("CheckSo API attempt - Endpoint: $endpoint, HTTP: $http_code, Error: $curl_error");
        
        // If we got a response, try to parse it
        if ($response !== false && !empty($response)) {
            $result = json_decode($response, true);
            
            // If valid JSON and has status field, return result
            if ($result && isset($result['status'])) {
                return [
                    'success' => $result['status'] == 1,
                    'message' => $result['status'] == 1 ? 'Check thành công' : 'Không tìm thấy',
                    'data' => $result,
                    'endpoint_used' => $endpoint
                ];
            }
        }
        
        $last_error = !empty($curl_error) ? $curl_error : "HTTP $http_code - No valid response";
    }
    
    // All endpoints failed
    return [
        'success' => false,
        'message' => 'API checkso.pro không phản hồi. Vui lòng thử lại sau. (' . $last_error . ')',
        'data' => null
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
        
        // Step 3: Prevent duplicate checks (same user & username)
        $stmt = $pdo->prepare("
            SELECT id, status, phone, result_message, created_at 
            FROM phone_check_history 
            WHERE checker_user_id = ? AND checked_username = ? 
            ORDER BY created_at DESC 
            LIMIT 1
        ");
        $stmt->execute([$user_id, $username]);
        $existing_check = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existing_check) {
            if ($existing_check['status'] === 'pending') {
                echo json_encode([
                    'success' => false,
                    'message' => 'Username này đang được xử lý từ trước. Vui lòng đợi hoàn tất trước khi check lại.',
                    'duplicate' => true,
                    'duplicate_status' => 'pending',
                    'existing_record_id' => $existing_check['id']
                ]);
                exit();
            }
            
            $duplicate_message_parts = [
                'Username đã được check trước đó.',
                'Kết quả: ' . ($existing_check['result_message'] ?: $existing_check['status']),
                'Thời gian: ' . $existing_check['created_at']
            ];
            
            echo json_encode([
                'success' => false,
                'message' => implode(' ', $duplicate_message_parts),
                'duplicate' => true,
                'duplicate_status' => $existing_check['status'],
                'existing_record_id' => $existing_check['id']
            ]);
            exit();
        }
        
        // Step 4: Deduct money first
        $deduct_result = deductWalletBalance($user_id, $check_price, 'Check số Shopee: ' . $username);
        if (!$deduct_result['success']) {
            echo json_encode($deduct_result);
            exit();
        }
        $deduct_transaction_id = $deduct_result['transaction_id'] ?? null;
        
        // Extend script time limit to align with API timeout
        if (function_exists('set_time_limit')) {
            @set_time_limit(320);
        }
        
        // Step 4: Save pending record
        $stmt = $pdo->prepare("INSERT INTO phone_check_history (checker_user_id, checked_username, checked_user_id, phone, status, result_message, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id, $username, null, null, 'pending', 'Đang chờ API response...']);
        $pending_id = $pdo->lastInsertId();
        $check_completed = false;
        
        // Register shutdown guard to auto-refund if script terminates unexpectedly
        register_shutdown_function(function() use (&$check_completed, $pending_id, $user_id, $username, $check_price, $deduct_transaction_id) {
            global $pdo;
            
            if ($check_completed || !$pending_id) {
                return;
            }
            
            try {
                $stmt = $pdo->prepare("SELECT status FROM phone_check_history WHERE id = ?");
                $stmt->execute([$pending_id]);
                $history = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$history || $history['status'] !== 'pending') {
                    return;
                }
                
                $refund_message = 'Hoàn tiền check số thất bại (timeout): ' . $username;
                $refund_result = refundWalletBalance($user_id, $check_price, $refund_message);
                
                if ($refund_result['success']) {
                    $stmt = $pdo->prepare("UPDATE phone_check_history SET status = ?, result_message = ?, updated_at = NOW() WHERE id = ?");
                    $stmt->execute(['not_found', 'API không phản hồi kịp thời (đã hoàn tiền tự động)', $pending_id]);
                    
                    if ($deduct_transaction_id) {
                        $stmt = $pdo->prepare("
                            INSERT INTO wallet_transactions (user_id, node_type, node_id, amount, type, date) 
                            VALUES (?, 'shop_ai_refund', ?, ?, 'in', NOW())
                        ");
                        $stmt->execute([$user_id, $deduct_transaction_id, $check_price]);
                    }
                }
            } catch (Exception $e) {
                error_log('Pending check auto-refund error: ' . $e->getMessage());
            }
        });

        // Step 5: Call checkso.pro API and wait for real response
        $api_result = callChecksoAPI($username, '99');
        
        // Step 6: Process API result
        if ($api_result['success'] && isset($api_result['data']['records']) && count($api_result['data']['records']) > 0) {
            // Success - found phone number (keep the deducted money)
            $phone_data = $api_result['data']['records'][0];
            $phone_number = $phone_data['result'];
            
            $stmt = $pdo->prepare("UPDATE phone_check_history SET phone = ?, status = ?, result_message = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$phone_number, 'success', 'Check thành công: ' . $phone_number, $pending_id]);
            
            // CHỈ CỘNG VÀO TOTAL_SPENDING KHI CHECK THÀNH CÔNG
            $stmt = $pdo->prepare("
                INSERT INTO shop_ai_user_ranks (user_id, current_rank_id, total_spending, created_at, last_updated) 
                VALUES (?, 1, ?, NOW(), NOW())
                ON DUPLICATE KEY UPDATE 
                total_spending = total_spending + ?, 
                last_updated = NOW()
            ");
            $stmt->execute([$user_id, $check_price, $check_price]);
            
            // Update rank if needed
            try {
                require_once '../../includes/class-rank.php';
                $rankSystem = new RankSystem();
                $rankSystem->updateUserRank($user_id);
            } catch (Exception $e) {
                error_log("Rank update error for user $user_id: " . $e->getMessage());
            }
            
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
            
            $check_completed = true;
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
            
            $check_completed = true;
        }
        break;

    case 'check_phone_multi':
        $user_id = intval($input['user_id'] ?? 0);
        $usernames_raw = $input['usernames'] ?? [];
        $usernames = [];
        foreach ((array)$usernames_raw as $u) {
            $u = trim(is_string($u) ? $u : '');
            if (strlen($u) >= 3) {
                $usernames[] = strtolower($u);
            }
        }
        $usernames = array_values(array_unique($usernames));
        if (!$user_id || count($usernames) === 0) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin hoặc danh sách username rỗng']);
            exit();
        }
        $check_price = getUserCheckPrice($user_id);
        $current_balance = checkUserBalance($user_id);
        $required_total = count($usernames) * $check_price;
        if ($required_total > $current_balance) {
            echo json_encode([
                'success' => false,
                'message' => 'Số dư không đủ để check ' . count($usernames) . ' username.',
                'required_amount' => $required_total,
                'current_balance' => $current_balance
            ]);
            exit();
        }
        echo json_encode([
            'success' => true,
            'message' => 'Đang xử lý ' . count($usernames) . ' username ở nền. Bạn có thể đóng hoặc load lại trang, kết quả sẽ lưu vào lịch sử.',
            'total' => count($usernames)
        ]);
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } else {
            if (ob_get_level()) ob_end_flush();
            flush();
        }
        ignore_user_abort(true);
        if (function_exists('set_time_limit')) @set_time_limit(0);
        foreach ($usernames as $username) {
            $current_balance = checkUserBalance($user_id);
            if ($current_balance < $check_price) {
                break;
            }
            $stmt = $pdo->prepare("SELECT id, status FROM phone_check_history WHERE checker_user_id = ? AND checked_username = ? ORDER BY created_at DESC LIMIT 1");
            $stmt->execute([$user_id, $username]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($existing && $existing['status'] === 'pending') {
                continue;
            }
            if ($existing && $existing['status'] !== 'pending') {
                continue;
            }
            $deduct_result = deductWalletBalance($user_id, $check_price, 'Check số Shopee: ' . $username);
            if (!$deduct_result['success']) {
                break;
            }
            $stmt = $pdo->prepare("INSERT INTO phone_check_history (checker_user_id, checked_username, checked_user_id, phone, status, result_message, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$user_id, $username, null, null, 'pending', 'Đang chờ API...']);
            $pending_id = $pdo->lastInsertId();
            $api_result = callChecksoAPI($username, '99');
            if ($api_result['success'] && isset($api_result['data']['records']) && count($api_result['data']['records']) > 0) {
                $phone_number = $api_result['data']['records'][0]['result'];
                $stmt = $pdo->prepare("UPDATE phone_check_history SET phone = ?, status = ?, result_message = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$phone_number, 'success', 'Check thành công: ' . $phone_number, $pending_id]);
                $stmt = $pdo->prepare("INSERT INTO shop_ai_user_ranks (user_id, current_rank_id, total_spending, created_at, last_updated) VALUES (?, 1, ?, NOW(), NOW()) ON DUPLICATE KEY UPDATE total_spending = total_spending + ?, last_updated = NOW()");
                $stmt->execute([$user_id, $check_price, $check_price]);
                try {
                    require_once __DIR__ . '/../../includes/class-rank.php';
                    $rankSystem = new RankSystem();
                    $rankSystem->updateUserRank($user_id);
                } catch (Exception $e) {}
            } else {
                $error_message = $api_result['message'] ?? 'Không tìm thấy số điện thoại';
                refundWalletBalance($user_id, $check_price, 'Hoàn tiền check số thất bại: ' . $username);
                $stmt = $pdo->prepare("UPDATE phone_check_history SET status = ?, result_message = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute(['not_found', $error_message . ' (Đã hoàn tiền)', $pending_id]);
            }
            sleep(1);
        }
        exit();

    case 'process_pending':
        $user_id = intval($input['user_id'] ?? 0);
        $minutes_threshold = intval($input['minutes_threshold'] ?? 10);
        $process_all = !empty($input['process_all']);
        
        if ($minutes_threshold < 0) {
            $minutes_threshold = 0;
        }
        
        if (!$process_all && !$user_id) {
            echo json_encode(['success' => false, 'message' => 'Thiếu user_id']);
            exit();
        }
        
        try {
            $conditions = ["status = 'pending'"];
            $params = [];
            
            if (!$process_all) {
                $conditions[] = "checker_user_id = ?";
                $params[] = $user_id;
            }
            
            if ($minutes_threshold > 0) {
                $conditions[] = "created_at <= (NOW() - INTERVAL {$minutes_threshold} MINUTE)";
            }
            
            $where_clause = implode(' AND ', $conditions);
            $stmt = $pdo->prepare("SELECT * FROM phone_check_history WHERE {$where_clause} ORDER BY created_at ASC");
            $stmt->execute($params);
            $pending_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!$pending_records) {
                echo json_encode([
                    'success' => true,
                    'processed' => 0,
                    'skipped' => 0,
                    'message' => 'Không còn bản ghi pending cần xử lý'
                ]);
                exit();
            }
            
            $processed = 0;
            $skipped = 0;
            $errors = [];
            
            foreach ($pending_records as $record) {
                $history_id = $record['id'];
                $username = $record['checked_username'];
                $checker_user_id = intval($record['checker_user_id']);
                
                try {
                    $tx_stmt = $pdo->prepare("
                        SELECT id, amount, description 
                        FROM users_wallets_transactions 
                        WHERE user_id = ? AND type = 'withdraw' AND description LIKE ? 
                        ORDER BY time DESC 
                        LIMIT 1
                    ");
                    $tx_stmt->execute([$checker_user_id, 'Check số Shopee: ' . $username . '%']);
                    $transaction = $tx_stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if (!$transaction) {
                        $skipped++;
                        $errors[] = "Không tìm thấy giao dịch trừ tiền cho {$username} (user {$checker_user_id})";
                        continue;
                    }
                    
                    $amount = floatval($transaction['amount']);
                    if ($amount <= 0) {
                        $skipped++;
                        $errors[] = "Số tiền không hợp lệ cho {$username} (user {$checker_user_id})";
                        continue;
                    }
                    
                    $refund_message = 'Hoàn tiền check số thất bại (xử lý thủ công): ' . $username;
                    $refund_result = refundWalletBalance($checker_user_id, $amount, $refund_message);
                    
                    if (!$refund_result['success']) {
                        $skipped++;
                        $errors[] = "Không thể hoàn tiền cho {$username} (user {$checker_user_id}): " . ($refund_result['message'] ?? 'lỗi không xác định');
                        continue;
                    }
                    
                    $stmt = $pdo->prepare("UPDATE phone_check_history SET status = ?, result_message = ?, updated_at = NOW() WHERE id = ?");
                    $stmt->execute(['not_found', 'API không phản hồi (đã hoàn tiền thủ công)', $history_id]);
                    
                    $wallet_stmt = $pdo->prepare("
                        INSERT INTO wallet_transactions (user_id, node_type, node_id, amount, type, date) 
                        VALUES (?, 'shop_ai_manual_refund', ?, ?, 'in', NOW())
                    ");
                    $wallet_stmt->execute([$checker_user_id, $history_id, $amount]);
                    
                    $processed++;
                } catch (Exception $inner) {
                    $skipped++;
                    $errors[] = "Lỗi xử lý {$username} (user {$checker_user_id}): " . $inner->getMessage();
                }
            }
            
            echo json_encode([
                'success' => true,
                'processed' => $processed,
                'skipped' => $skipped,
                'errors' => $errors,
                'message' => $process_all
                    ? "Đã xử lý {$processed} bản ghi pending trên toàn hệ thống."
                    : "Đã xử lý {$processed} bản ghi pending."
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Không thể xử lý pending: ' . $e->getMessage()]);
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
        
    case 'delete_all_notfound_error':
        $user_id = intval($input['user_id'] ?? 0);
        if (!$user_id) {
            echo json_encode(['success' => false, 'message' => 'Thiếu user_id']);
            exit();
        }
        try {
            $stmt = $pdo->prepare("DELETE FROM phone_check_history WHERE checker_user_id = ? AND status IN ('not_found', 'error')");
            $stmt->execute([$user_id]);
            $deleted = $stmt->rowCount();
            // Ghi nhận 1 lần xoá vào system_options (admin xem tại my-system/number-check)
            $opt_name = 'phone_check_history_delete_count';
            $stmt = $pdo->prepare("SELECT option_value FROM system_options WHERE option_name = ?");
            $stmt->execute([$opt_name]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $new_count = $row ? (intval($row['option_value']) + 1) : 1;
            $stmt = $pdo->prepare("INSERT INTO system_options (option_name, option_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE option_value = ?");
            $stmt->execute([$opt_name, (string)$new_count, (string)$new_count]);
            echo json_encode([
                'success' => true,
                'message' => 'Đã xoá ' . $deleted . ' bản ghi trạng thái Không tìm thấy / Lỗi.',
                'deleted' => $deleted
            ]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }
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
