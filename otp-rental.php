<?php

/**
 * otp-rental
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootloader
require('bootloader.php');

// Check if user is logged in
if (!$user->_logged_in) {
    user_login();
}

// Handle view parameter
$view = $_GET['view'] ?? '';

// Set page variables
$page = 'otp-rental';
$title = 'Thuê OTP';

// Handle API requests first
if (isset($_GET['action']) || (isset($_POST['action']) && $_SERVER['REQUEST_METHOD'] === 'POST')) {
    handleAPIRequest();
    exit;
}

// Handle different views
if ($view == 'history') {
    handleHistoryPage();
} else {
    // Get services for template
    $services = [];
    try {
        $query = "SELECT service_id, viotp_id, name, price FROM otp_services WHERE is_active = 1 ORDER BY service_id";
        $result = $db->query($query);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $services[] = [
                    'id' => $row['viotp_id'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'original_price' => $row['price'] / 2
                ];
            }
        }
    } catch (Exception $e) {
        error_log('Database error: ' . $e->getMessage());
    }
    
    // Get recent rental history for main page
    $recent_rentals = [];
    try {
        // Check if otp_requests table exists
        $table_check = $db->query("SHOW TABLES LIKE 'otp_requests'");
        if ($table_check->num_rows > 0) {
            $history_query = "
                SELECT r.*, s.name as service_name 
                FROM otp_requests r 
                LEFT JOIN otp_services s ON r.service_id = s.service_id 
                WHERE r.user_id = ? 
                ORDER BY r.created_at DESC 
                LIMIT 7
            ";
            $history_stmt = $db->prepare($history_query);
            $history_stmt->bind_param("i", $user->_data['user_id']);
            $history_stmt->execute();
            $history_result = $history_stmt->get_result();
            
            while ($row = $history_result->fetch_assoc()) {
                $recent_rentals[] = $row;
            }
        }
    } catch (Exception $e) {
        error_log('Database error loading rental history: ' . $e->getMessage());
    }
    
    // Assign data to template
    $smarty->assign('services', $services);
    $smarty->assign('recent_rentals', $recent_rentals);
    $smarty->assign('view', 'rental');
    
    // Default rental page
    page_footer('otp-rental');
}

/**
 * Handle history page
 */
function handleHistoryPage() {
    global $user, $db, $page, $title, $smarty;
    
    // Get filter parameters
    $search = $_GET['search'] ?? '';
    $service = $_GET['service'] ?? '';
    $status = $_GET['status'] ?? '';
    $from_date = $_GET['from_date'] ?? '';
    $to_date = $_GET['to_date'] ?? '';
    $current_page = max(1, (int)($_GET['page'] ?? 1));
    $per_page = 20;
    
    // Build WHERE clause for otp_requests table
    $where_conditions = ["user_id = {$user->_data['user_id']}"];
    $params = [];
    $param_types = "i";
    
    if (!empty($search)) {
        $where_conditions[] = "(phone_number LIKE ? OR otp_code LIKE ?)";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $param_types .= "ss";
    }
    
    if (!empty($service)) {
        $where_conditions[] = "service_id = ?";
        $params[] = $service;
        $param_types .= "i";
    }
    
    if ($status !== '') {
        $where_conditions[] = "status = ?";
        $params[] = $status;
        $param_types .= "s";
    }
    
    if (!empty($from_date)) {
        $where_conditions[] = "created_at >= ?";
        $params[] = $from_date . ' 00:00:00';
        $param_types .= "s";
    }
    
    if (!empty($to_date)) {
        $where_conditions[] = "created_at <= ?";
        $params[] = $to_date . ' 23:59:59';
        $param_types .= "s";
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    // Get total count
    $count_query = "SELECT COUNT(*) as total FROM otp_requests WHERE {$where_clause}";
    $count_stmt = $db->prepare($count_query);
    if (!empty($params)) {
        $count_stmt->bind_param($param_types, ...$params);
    }
    $count_stmt->execute();
    $total_records = $count_stmt->get_result()->fetch_assoc()['total'];
    $total_pages = ceil($total_records / $per_page);
    
    // Get rentals with pagination
    $offset = ($current_page - 1) * $per_page;
    $rentals_query = "
        SELECT r.*, s.name as service_name 
        FROM otp_requests r 
        LEFT JOIN otp_services s ON r.service_id = s.service_id 
        WHERE {$where_clause} 
        ORDER BY r.created_at DESC 
        LIMIT {$per_page} OFFSET {$offset}
    ";
    
    $rentals_stmt = $db->prepare($rentals_query);
    if (!empty($params)) {
        $rentals_stmt->bind_param($param_types, ...$params);
    }
    $rentals_stmt->execute();
    $rentals_result = $rentals_stmt->get_result();
    
    $rentals = [];
    while ($row = $rentals_result->fetch_assoc()) {
        $rentals[] = $row;
    }
    
    // Get services for filter dropdown
    $services_query = "SELECT service_id, name FROM otp_services ORDER BY name";
    $services_result = $db->query($services_query);
    $services = [];
    while ($row = $services_result->fetch_assoc()) {
        $services[] = $row;
    }
    
    // Calculate pagination info
    $start_record = $offset + 1;
    $end_record = min($offset + $per_page, $total_records);
    
    // Prepare filter params for pagination links
    $filter_params = array_filter([
        'search' => $search,
        'service' => $service,
        'status' => $status,
        'from_date' => $from_date,
        'to_date' => $to_date
    ]);
    
    // Set template variables
    $smarty->assign('view', 'history');
    $smarty->assign('rentals', $rentals);
    $smarty->assign('services', $services);
    $smarty->assign('search', $search);
    $smarty->assign('selected_service', $service);
    $smarty->assign('selected_status', $status);
    $smarty->assign('from_date', $from_date);
    $smarty->assign('to_date', $to_date);
    $smarty->assign('current_page', $current_page);
    $smarty->assign('total_pages', $total_pages);
    $smarty->assign('total_records', $total_records);
    $smarty->assign('start_record', $start_record);
    $smarty->assign('end_record', $end_record);
    $smarty->assign('filter_params', $filter_params);
    
    // page footer
    page_footer('otp-rental-history');
}

/**
 * Get services from ViOTP API
 */
function getServicesFromAPI() {
    $api_token = '35fdc637de8e4beb8781b4a9d8e070ac';
    $api_url = 'https://api.viotp.com/service/getv2?token=' . $api_token . '&country=vn';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code == 200 && $response) {
        $data = json_decode($response, true);
        if ($data && $data['success'] && isset($data['data'])) {
            return $data['data'];
        }
    }
    
    return [];
}

/**
 * Handle API requests
 */
function handleAPIRequest() {
    global $user, $db;
    
    // Set JSON header
    header('Content-Type: application/json');
    
    // Debug: Log the request
    error_log('API Request - Method: ' . $_SERVER['REQUEST_METHOD']);
    error_log('API Request - POST data: ' . print_r($_POST, true));
    error_log('API Request - GET data: ' . print_r($_GET, true));
    
    $action = $_POST['action'] ?? $_GET['action'] ?? '';
    
    error_log('API Request - Action: ' . $action);
    
    switch ($action) {
        case 'get_services':
            handleGetServices();
            break;
            
        case 'get_networks':
            handleGetNetworks();
            break;
            
        case 'rent_otp':
            handleRentOTP();
            break;
            
        case 'check_otp':
            handleCheckOTP();
            break;
        case 'get_rental_history':
            handleGetRentalHistory();
            break;
        case 'get_rental_statistics':
            handleGetRentalStatistics();
            break;
            
        default:
            echo json_encode(['error' => 'Invalid action', 'received_action' => $action]);
            break;
    }
}

/**
 * Get available services
 */
function handleGetServices() {
    global $db;
    
    error_log('handleGetServices called');
    
    $country = $_POST['country'] ?? 'vn';
    
    error_log('Country: ' . $country);
    
    // Get services from database
    $services = [];
    
    try {
        $query = "SELECT service_id, viotp_id, name, price FROM otp_services WHERE is_active = 1 ORDER BY service_id";
        $result = $db->query($query);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $services[] = [
                    'id' => $row['viotp_id'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'original_price' => $row['price'] / 2 // Calculate original price
                ];
            }
        }
        
        error_log('Database services count: ' . count($services));
        
    } catch (Exception $e) {
        error_log('Database error: ' . $e->getMessage());
        
        // Fallback to mock data if database fails
        $services = [
            ['id' => 1, 'name' => 'Facebook', 'price' => 1600, 'original_price' => 800],
            ['id' => 2, 'name' => 'Shopee', 'price' => 1200, 'original_price' => 600],
            ['id' => 3, 'name' => 'Momo', 'price' => 700, 'original_price' => 350],
            ['id' => 4, 'name' => 'Zalo', 'price' => 1000, 'original_price' => 500],
            ['id' => 5, 'name' => 'TikTok', 'price' => 800, 'original_price' => 400]
        ];
    }
    
    echo json_encode(['success' => true, 'data' => $services]);
}

/**
 * Get available networks
 */
function handleGetNetworks() {
    $country = $_POST['country'] ?? 'vn';
    
    // Mock data for now
    $networks = [
        ['id' => 1, 'name' => 'MOBIFONE'],
        ['id' => 2, 'name' => 'VINAPHONE'],
        ['id' => 3, 'name' => 'VIETTEL'],
        ['id' => 4, 'name' => 'VIETNAMOBILE'],
        ['id' => 5, 'name' => 'ITELECOM']
    ];
    
    echo json_encode(['success' => true, 'data' => $networks]);
}

/**
 * Rent OTP service
 */
function handleRentOTP() {
    global $user, $db;
    
    error_log('handleRentOTP called');
    
    $service_id = $_POST['service_id'] ?? '';
    $network = $_POST['network'] ?? '';
    $prefix = $_POST['prefix'] ?? '';
    $except_prefix = $_POST['except_prefix'] ?? '';
    $old_number = $_POST['old_number'] ?? '';
    
    error_log('Service ID: ' . $service_id);
    
    if (!$service_id) {
        echo json_encode(['error' => 'Service ID is required']);
        return;
    }
    
    // Get service price from database
    $service_query = "SELECT service_id, name, price FROM otp_services WHERE viotp_id = ?";
    $service_stmt = $db->prepare($service_query);
    $service_stmt->bind_param("i", $service_id);
    $service_stmt->execute();
    $service_result = $service_stmt->get_result();
    $service_data = $service_result->fetch_assoc();
    
    if (!$service_data) {
        error_log('Service not found for viotp_id: ' . $service_id);
        echo json_encode(['error' => 'Dịch vụ không tồn tại. Vui lòng chọn dịch vụ khác.']);
        return;
    }
    
    error_log('Service found: ' . json_encode($service_data));
    
    $service_price = $service_data['price'];
    $user_balance = $user->_data['user_wallet_balance'] ?? 0;
    
    // Check if user has enough balance
    if ($user_balance < $service_price) {
        echo json_encode([
            'error' => 'Số dư không đủ',
            'required' => $service_price,
            'current' => $user_balance,
            'shortage' => $service_price - $user_balance
        ]);
        return;
    }
    
    // Call ViOTP API to rent number
    $api_token = '35fdc637de8e4beb8781b4a9d8e070ac';
    $api_url = 'https://api.viotp.com/request/getv2?token=' . $api_token . '&serviceId=' . $service_id;
    
    error_log('Calling ViOTP API: ' . $api_url);
    
    // Add optional parameters
    if ($network) {
        $api_url .= '&network=' . urlencode($network);
    }
    if ($prefix) {
        $api_url .= '&prefix=' . urlencode($prefix);
    }
    if ($except_prefix) {
        $api_url .= '&exceptPrefix=' . urlencode($except_prefix);
    }
    if ($old_number) {
        $api_url .= '&number=' . urlencode($old_number);
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    error_log('API Response Code: ' . $http_code);
    error_log('API Response: ' . $response);
    
    if ($http_code == 200 && $response) {
        $data = json_decode($response, true);
        
        error_log('API Response: ' . $response);
        error_log('Decoded data: ' . json_encode($data));
        
        if ($data && isset($data['success']) && $data['success']) {
            error_log('API Success - saving to database and deducting balance');
            
            // Simple approach without complex transaction
            try {
                $user_id = $user->_data['user_id'];
                
                // 1. Save rental record to database first (using simple query)
                $viotp_request_id = $db->real_escape_string($data['data']['request_id']);
                $service_name = $db->real_escape_string($service_data['name']);
                $phone_number = $db->real_escape_string($data['data']['phone_number']);
                $re_phone_number = $db->real_escape_string($data['data']['re_phone_number'] ?? '');
                $country_iso = $db->real_escape_string($data['data']['countryISO']);
                $country_code = $db->real_escape_string($data['data']['countryCode']);
                
                $insert_sql = "INSERT INTO otp_requests (user_id, viotp_request_id, service_id, service_name, phone_number, re_phone_number, country_iso, country_code, status, price, created_at) VALUES (
                    {$user_id},
                    '{$viotp_request_id}',
                    {$service_data['service_id']},
                    '{$service_name}',
                    '{$phone_number}',
                    '{$re_phone_number}',
                    '{$country_iso}',
                    '{$country_code}',
                    'pending',
                    {$service_price},
                    NOW()
                )";
                
                error_log('Insert SQL: ' . $insert_sql);
                
                if (!$db->query($insert_sql)) {
                    throw new Exception('Không thể lưu yêu cầu thuê OTP: ' . $db->error);
                }
                
                // 2. Update user balance (using simple query)
                $new_balance = $user_balance - $service_price;
                $update_balance_sql = "UPDATE users SET user_wallet_balance = {$new_balance} WHERE user_id = {$user_id}";
                
                error_log('Update balance SQL: ' . $update_balance_sql);
                
                if (!$db->query($update_balance_sql)) {
                    throw new Exception('Không thể cập nhật số dư: ' . $db->error);
                }
                
                // 3. Add wallet transaction record (using users_wallets_transactions table)
                $transaction_sql = "INSERT INTO users_wallets_transactions (user_id, type, amount, description, time) VALUES (?, 'otp_rental', ?, ?, NOW())";
                $transaction_stmt = $db->prepare($transaction_sql);
                $description = "Thuê OTP - " . $service_data['name'];
                $transaction_stmt->bind_param("ids", $user_id, $service_price, $description);
                
                error_log('Wallet transaction SQL: ' . $transaction_sql);
                
                if (!$transaction_stmt->execute()) {
                    error_log('Warning: Could not save wallet transaction: ' . $db->error);
                }
                
                // Update user balance in session
                $user->_data['user_wallet_balance'] = $new_balance;
                
                error_log('Rental completed successfully - Request ID: ' . $data['data']['request_id']);
                
            } catch (Exception $e) {
                error_log('Rental failed: ' . $e->getMessage());
                echo json_encode([
                    'success' => false,
                    'error' => 'Có lỗi xảy ra khi xử lý giao dịch: ' . $e->getMessage()
                ]);
                return;
            }
            
            $response_data = [
                'success' => true,
                'data' => [
                    'phone_number' => $data['data']['phone_number'],
                    'request_id' => $data['data']['request_id'],
                    'message' => 'Thuê số thành công!'
                ]
            ];
            error_log('Sending response: ' . json_encode($response_data));
            echo json_encode($response_data);
        } else {
            $error_message = 'Có lỗi xảy ra khi thuê số';
            
            if ($data && isset($data['message'])) {
                $error_message = $data['message'];
            } elseif ($data && isset($data['error'])) {
                $error_message = $data['error'];
            } elseif (!$data) {
                $error_message = 'API trả về dữ liệu không hợp lệ';
            }
            
            error_log('API Error: ' . $error_message);
            error_log('Full response: ' . $response);
            
            echo json_encode([
                'success' => false,
                'error' => $error_message
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Không thể kết nối đến dịch vụ ViOTP'
        ]);
    }
}

/**
 * Get rental history
 */
function handleGetRentalHistory() {
    global $user, $db;
    
    error_log('handleGetRentalHistory called');
    
    $user_id = $user->_data['user_id'] ?? 1;
    $limit = $_POST['limit'] ?? 10;
    $offset = $_POST['offset'] ?? 0;
    $status = $_POST['status'] ?? '';
    $service = $_POST['service'] ?? '';
    $date = $_POST['date'] ?? '';
    
    error_log('User ID: ' . $user_id . ', Limit: ' . $limit);
    
    try {
        // Check if table exists first
        $table_check = $db->query("SHOW TABLES LIKE 'otp_requests'");
        if ($table_check->num_rows == 0) {
            error_log('Table otp_requests does not exist');
            echo json_encode(['success' => true, 'data' => []]);
            return;
        }
        
        // Build WHERE clause with filters
        $where_conditions = ["r.user_id = ?"];
        $params = [$user_id];
        $param_types = "i";
        
        if ($status) {
            $where_conditions[] = "r.status = ?";
            $params[] = $status;
            $param_types .= "s";
        }
        
        if ($service) {
            // Get service name from service_id
            $service_query = "SELECT name FROM otp_services WHERE service_id = ?";
            $service_stmt = $db->prepare($service_query);
            $service_stmt->bind_param("i", $service);
            $service_stmt->execute();
            $service_result = $service_stmt->get_result();
            $service_data = $service_result->fetch_assoc();
            
            if ($service_data) {
                $where_conditions[] = "r.service_name = ?";
                $params[] = $service_data['name'];
                $param_types .= "s";
            }
        }
        
        if ($date) {
            $where_conditions[] = "DATE(r.created_at) = ?";
            $params[] = $date;
            $param_types .= "s";
        }
        
        $where_clause = implode(" AND ", $where_conditions);
        
        $query = "SELECT r.*, s.name as service_name, s.price as service_price 
                  FROM otp_requests r 
                  LEFT JOIN otp_services s ON r.service_id = s.service_id 
                  WHERE $where_clause
                  ORDER BY r.created_at DESC 
                  LIMIT ? OFFSET ?";
        
        $params[] = $limit;
        $params[] = $offset;
        $param_types .= "ii";
        
        $stmt = $db->prepare($query);
        $stmt->bind_param($param_types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $rentals = [];
        while ($row = $result->fetch_assoc()) {
            $rentals[] = [
                'id' => $row['id'],
                'service_name' => $row['service_name'] ?? 'Unknown',
                'phone_number' => $row['phone_number'],
                'request_id' => $row['request_id'],
                'status' => $row['status'],
                'created_at' => $row['created_at'],
                'price' => $row['service_price'] ?? 0,
                'otp_code' => $row['otp_code'] ?? null
            ];
        }
        
        error_log('Found ' . count($rentals) . ' rental records');
        echo json_encode(['success' => true, 'data' => $rentals]);
    } catch (Exception $e) {
        error_log('Database error getting rental history: ' . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Không thể lấy lịch sử thuê: ' . $e->getMessage()]);
    }
}

/**
 * Get rental statistics
 */
function handleGetRentalStatistics() {
    global $user, $db;
    
    $user_id = $user->_data['user_id'] ?? 1;
    
    try {
        // Check if table exists first
        $table_check = $db->query("SHOW TABLES LIKE 'otp_requests'");
        if ($table_check->num_rows == 0) {
            echo json_encode(['success' => true, 'data' => [
                'total' => 0,
                'completed' => 0,
                'pending' => 0,
                'expired' => 0
            ]]);
            return;
        }
        
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'expired' THEN 1 ELSE 0 END) as expired
                  FROM otp_requests 
                  WHERE user_id = ?";
        
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        echo json_encode(['success' => true, 'data' => [
            'total' => (int)$row['total'],
            'completed' => (int)$row['completed'],
            'pending' => (int)$row['pending'],
            'expired' => (int)$row['expired']
        ]]);
    } catch (Exception $e) {
        error_log('Database error getting rental statistics: ' . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Không thể lấy thống kê thuê']);
    }
}

/**
 * Check OTP status
 */
function handleCheckOTP() {
    global $db;
    
    $request_id = $_POST['request_id'] ?? '';
    
    if (!$request_id) {
        echo json_encode(['error' => 'Request ID is required']);
        return;
    }
    
    // Call ViOTP API to check OTP status
    $api_token = '35fdc637de8e4beb8781b4a9d8e070ac';
    $api_url = 'https://api.viotp.com/session/getv2?requestId=' . $request_id . '&token=' . $api_token;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code == 200 && $response) {
        $data = json_decode($response, true);
        
        if ($data && $data['success']) {
            // Update database with OTP code if received
            if ($data['data']['Status'] == 1 && $data['data']['Code']) {
                try {
                    // Update OTP request with completed status and OTP code
                    $update_sql = "UPDATE otp_requests SET status = 'completed', otp_code = ?, completed_at = NOW() WHERE viotp_request_id = ?";
                    $update_stmt = $db->prepare($update_sql);
                    $update_stmt->bind_param("ss", $data['data']['Code'], $request_id);
                    
                    if ($update_stmt->execute()) {
                        error_log('OTP code updated successfully: ' . $data['data']['Code']);
                    } else {
                        error_log('Failed to update OTP code: ' . $db->error);
                    }
                } catch (Exception $e) {
                    error_log('Database error updating OTP: ' . $e->getMessage());
                }
            } elseif ($data['data']['Status'] == 2) {
                // Mark as expired
                try {
                    $update_sql = "UPDATE otp_requests SET status = 'expired' WHERE viotp_request_id = ?";
                    $update_stmt = $db->prepare($update_sql);
                    $update_stmt->bind_param("s", $request_id);
                    
                    if ($update_stmt->execute()) {
                        error_log('OTP request marked as expired: ' . $request_id);
                    } else {
                        error_log('Failed to mark OTP as expired: ' . $db->error);
                    }
                } catch (Exception $e) {
                    error_log('Database error updating OTP status: ' . $e->getMessage());
                }
            }
            
            echo json_encode([
                'success' => true,
                'data' => [
                    'status' => $data['data']['Status'] == 1 ? 'completed' : ($data['data']['Status'] == 2 ? 'expired' : 'pending'),
                    'code' => $data['data']['Code'] ?? '',
                    'message' => $data['message']
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => $data['message'] ?? 'Có lỗi xảy ra khi kiểm tra OTP'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Không thể kết nối đến dịch vụ ViOTP'
        ]);
    }
}
?>