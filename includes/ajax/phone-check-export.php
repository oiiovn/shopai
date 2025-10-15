<?php
// phone-check-export.php - Export phone check history to Excel

// Include config
require_once '../config.php';

// Only allow GET requests for export
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo 'Method not allowed';
    exit();
}

// Get parameters
$user_id = intval($_GET['user_id'] ?? 1);
$search = $_GET['search'] ?? '';
$status_filter = $_GET['status_filter'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Database connection failed';
    exit();
}

// Get all data with filters (no limit for export)
function getPhoneCheckHistoryForExport($checker_user_id, $status_filter = '', $search = '', $date_from = '', $date_to = '') {
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
        
        if (!empty($date_from)) {
            $where_conditions[] = "DATE(created_at) >= ?";
            $params[] = $date_from;
        }
        
        if (!empty($date_to)) {
            $where_conditions[] = "DATE(created_at) <= ?";
            $params[] = $date_to;
        }
        
        $where_clause = implode(" AND ", $where_conditions);
        
        $sql = "SELECT * FROM phone_check_history WHERE $where_clause ORDER BY created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Get data
$data = getPhoneCheckHistoryForExport($user_id, $status_filter, $search, $date_from, $date_to);

// Create filename
$filename = 'lich_su_check_' . date('Y-m-d_H-i-s') . '.csv';

// Set headers for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');

// Create CSV content
$output = fopen('php://output', 'w');

// Add BOM for UTF-8
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// CSV Headers
fputcsv($output, [
    'STT',
    'Thời gian',
    'Username',
    'Trạng thái',
    'Số điện thoại',
    'Ghi chú',
    'Ngày tạo',
    'Ngày cập nhật'
], ';');

// CSV Data
if (count($data) > 0) {
    foreach ($data as $index => $item) {
        $status_text = '';
        switch ($item['status']) {
            case 'pending':
                $status_text = 'Đang check...';
                break;
            case 'success':
                $status_text = 'Thành công';
                break;
            case 'not_found':
                $status_text = 'Không tìm thấy';
                break;
            case 'error':
                $status_text = 'Lỗi';
                break;
        }
        
        fputcsv($output, [
            $index + 1,
            date('H:i:s d/m/Y', strtotime($item['created_at'])),
            $item['checked_username'],
            $status_text,
            $item['phone'] ?? '',
            $item['result_message'],
            date('d/m/Y H:i:s', strtotime($item['created_at'])),
            date('d/m/Y H:i:s', strtotime($item['updated_at']))
        ], ';');
    }
} else {
    fputcsv($output, [
        '',
        '',
        'Không có dữ liệu',
        '',
        '',
        '',
        '',
        ''
    ], ';');
}

fclose($output);
exit();
?>
