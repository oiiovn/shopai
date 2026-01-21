<?php

/**
 * otp-rental
 * 
 * Trang thuê số điện thoại nhận OTP
 * 
 * @package Sngine
 * @author ShopAI Team
 */

// fetch bootloader
require('bootloader.php');

// require OTP class
require_once('includes/class-otp.php');

// Handle API requests
if (isset($_GET['action']) || (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false)) {
    handleOTPAPIRequest();
    exit;
}

// user access
user_access();

// Check if user is banned
if ($user->_is_banned) {
    _error(__('Your account has been banned'));
}

/**
 * Handle API requests
 */
function handleOTPAPIRequest() {
    global $user;
    
    header('Content-Type: application/json; charset=utf-8');
    
    // Check authentication for API
    if (!$user->_logged_in) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
        exit;
    }
    
    $user_id = $user->_data['user_id'];
    $action = $_GET['action'] ?? '';
    
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true) ?? [];
    
    // Merge GET params
    $input = array_merge($_GET, $_POST, $input);
    
    $otp = new OTPRental();
    
    switch ($action) {
        case 'get_services':
            $country = $input['country'] ?? 'vn';
            $services = $otp->getServices($country);
            echo json_encode(['success' => true, 'data' => $services]);
            break;
            
        case 'get_networks':
            $country = $input['country'] ?? 'vn';
            $networks = $otp->getNetworks($country);
            echo json_encode(['success' => true, 'data' => $networks]);
            break;
            
        case 'get_price':
            $service_id = intval($input['service_id'] ?? 0);
            $price = $otp->getServicePrice($service_id);
            echo json_encode(['success' => true, 'price' => $price]);
            break;
            
        case 'rent':
            $service_id = intval($input['service_id'] ?? 0);
            $network_id = !empty($input['network_id']) ? intval($input['network_id']) : null;
            $prefix = $input['prefix'] ?? null;
            $except_prefix = $input['except_prefix'] ?? null;
            
            if (!$service_id) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng chọn dịch vụ']);
                break;
            }
            
            $result = $otp->rentNumber($user_id, $service_id, $network_id, $prefix, $except_prefix);
            echo json_encode($result);
            break;
            
        case 'check_otp':
            $request_id = intval($input['request_id'] ?? 0);
            
            if (!$request_id) {
                echo json_encode(['success' => false, 'message' => 'Thiếu request_id']);
                break;
            }
            
            $result = $otp->checkOTP($request_id, $user_id);
            echo json_encode($result);
            break;
            
        case 'cancel':
            $request_id = intval($input['request_id'] ?? 0);
            
            if (!$request_id) {
                echo json_encode(['success' => false, 'message' => 'Thiếu request_id']);
                break;
            }
            
            $result = $otp->cancelRequest($request_id, $user_id);
            echo json_encode($result);
            break;
            
        case 'history':
            $limit = intval($input['limit'] ?? 20);
            $offset = intval($input['offset'] ?? 0);
            
            $history = $otp->getUserHistory($user_id, $limit, $offset);
            echo json_encode(['success' => true, 'data' => $history]);
            break;
            
        case 'get_balance':
            $balance = $user->_data['user_wallet_balance'] ?? 0;
            echo json_encode(['success' => true, 'balance' => floatval($balance)]);
            break;
            
        case 'get_pending_requests':
            // Lấy các request pending hoặc completed trong vòng 30 phút
            $pending = $otp->getPendingRequests($user_id);
            echo json_encode(['success' => true, 'data' => $pending]);
            break;
            
        case 'delete_expired':
            // Xóa các request hết hạn của user
            $deleted = $otp->deleteExpiredRequests($user_id);
            echo json_encode(['success' => true, 'deleted' => $deleted]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
    }
    
    exit;
}

// Initialize OTP class
$otp = new OTPRental();

// Get view - mặc định là 'rent'
$view = $_GET['view'] ?? 'rent';

// Redirect nếu không có view hoặc view = services
if (empty($_GET['view']) || $_GET['view'] === 'services') {
    header('Location: ' . $system['system_url'] . '/otp-rental?view=rent');
    exit;
}

// page header
page_header(__("Thuê số OTP"), __("Thuê số điện thoại nhận mã OTP"));

// Get data based on view
switch ($view) {
    case 'history':
        $smarty->assign('page', 'otp-rental');
        $smarty->assign('view', 'history');
        $smarty->assign('history', $otp->getUserHistory($user->_data['user_id']));
        break;
        
    case 'active':
        $request_id = intval($_GET['request_id'] ?? 0);
        $smarty->assign('page', 'otp-rental');
        $smarty->assign('view', 'active');
        $smarty->assign('request_id', $request_id);
        break;
        
    case 'rent':
    default:
        $service_id = intval($_GET['service_id'] ?? 0);
        $smarty->assign('page', 'otp-rental');
        $smarty->assign('view', 'rent');
        $smarty->assign('service_id', $service_id);
        $smarty->assign('services', $otp->getServices());
        $smarty->assign('networks', $otp->getNetworks());
        $smarty->assign('config', $otp->getConfig());
        break;
}

// page footer
page_footer('otp-rental');
