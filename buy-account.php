<?php

/**
 * buy-account
 * 
 * Trang mua tài khoản
 * 
 * @package Sngine
 * @author ShopAI Team
 */

// fetch bootloader
require('bootloader.php');

// user access
user_access();

// Check if user is banned
if ($user->_is_banned) {
    _error(__('Your account has been banned'));
}

// Handle add category action (admin only)
if (isset($_POST['action']) && $_POST['action'] == 'add_category') {
    header('Content-Type: application/json; charset=utf-8');
    
    try {
        if (!$user->_is_admin) {
            echo json_encode(['success' => false, 'message' => 'Bạn không có quyền thực hiện thao tác này']);
            exit;
        }
        
        $category_name = trim($_POST['category_name'] ?? '');
        $category_slug = trim($_POST['category_slug'] ?? '');
        $category_price = floatval($_POST['category_price'] ?? 0);
        $category_description = trim($_POST['category_description'] ?? '');
        $category_image = null;
        
        // Xử lý upload ảnh
        if (!empty($_FILES['category_image']['name']) && $_FILES['category_image']['error'] == UPLOAD_ERR_OK) {
            $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['category_image']['tmp_name']);
            finfo_close($finfo);
            
            if (in_array($mime, $allowed) && $_FILES['category_image']['size'] <= 4 * 1024 * 1024) {
                $uploads_dir = rtrim($system['uploads_directory'] ?? 'content/uploads', '/');
                $upload_dir = rtrim(ABSPATH, '/') . '/' . $uploads_dir . '/category_images/';
                if (!is_dir($upload_dir)) @mkdir($upload_dir, 0755, true);
                $ext = pathinfo($_FILES['category_image']['name'], PATHINFO_EXTENSION) ?: 'jpg';
                $filename = 'cat_' . time() . '_' . uniqid() . '.' . strtolower($ext);
                if (move_uploaded_file($_FILES['category_image']['tmp_name'], $upload_dir . $filename)) {
                    $category_image = 'category_images/' . $filename;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Không thể lưu ảnh. Kiểm tra quyền ghi thư mục content/uploads/category_images/']);
                    exit;
                }
            } else {
                $msg = ($_FILES['category_image']['size'] > 4 * 1024 * 1024) ? 'Ảnh quá lớn (tối đa 4MB)' : 'Định dạng ảnh không hợp lệ (JPG, PNG, GIF, WebP)';
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
        }
        
        if (empty($category_name)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập tên danh mục']);
            exit;
        }
        
        // Auto-generate slug từ tên nếu để trống
        if (empty($category_slug)) {
            $category_slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', 
                str_replace(['à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă','ằ','ắ','ặ','ẳ','ẵ','è','é','ẹ','ẻ','ẽ','ê','ề','ế','ệ','ể','ễ','ì','í','ị','ỉ','ĩ','ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ','ờ','ớ','ợ','ở','ỡ','ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ','ỳ','ý','ỵ','ỷ','ỹ','đ'],
                ['a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','e','e','e','e','e','e','e','e','e','e','e','i','i','i','i','i','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','u','u','u','u','u','u','u','u','u','u','u','y','y','y','y','y','d'],
                strtolower($category_name)
            )));
            $category_slug = trim($category_slug, '-');
        }
        
        if (empty($category_slug)) {
            $category_slug = 'category-' . time();
        }
        
        // Kiểm tra slug trùng
        $check = $db->query(sprintf("SELECT category_id FROM account_categories WHERE category_slug = %s", secure($category_slug)));
        if ($check && $check->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Slug danh mục đã tồn tại. Vui lòng chọn slug khác.']);
            exit;
        }
        
        // Lưu tên/mô tả dạng text gốc (không htmlentities) để giữ đúng tiếng Việt
        $name_safe = "'" . $db->real_escape_string($category_name) . "'";
        $desc_safe = "'" . $db->real_escape_string($category_description) . "'";
        $insert = $db->query(sprintf(
            "INSERT INTO account_categories (category_name, category_slug, category_image, category_price, category_description, is_active, sort_order) VALUES (%s, %s, %s, %s, %s, '1', 999)",
            $name_safe,
            secure($category_slug),
            secure($category_image),
            secure($category_price, 'float'),
            $desc_safe
        ));
        
        if ($insert) {
            echo json_encode(['success' => true, 'message' => 'Đã tạo danh mục thành công!', 'reload' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi khi lưu danh mục: ' . $db->error]);
        }
        exit;
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        exit;
    }
}

// Handle edit category action (admin only)
if (isset($_POST['action']) && $_POST['action'] == 'edit_category') {
    header('Content-Type: application/json; charset=utf-8');
    
    try {
        if (!$user->_is_admin) {
            echo json_encode(['success' => false, 'message' => 'Bạn không có quyền thực hiện thao tác này']);
            exit;
        }
        
        $category_id = intval($_POST['category_id'] ?? 0);
        $category_name = trim($_POST['category_name'] ?? '');
        $category_slug = trim($_POST['category_slug'] ?? '');
        $category_price = floatval($_POST['category_price'] ?? 0);
        $category_description = trim($_POST['category_description'] ?? '');
        
        if (!$category_id || empty($category_name)) {
            echo json_encode(['success' => false, 'message' => 'Thông tin không hợp lệ']);
            exit;
        }
        
        // Kiểm tra danh mục tồn tại
        $get = $db->query(sprintf("SELECT * FROM account_categories WHERE category_id = %s", secure($category_id, 'int')));
        if (!$get || $get->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Danh mục không tồn tại']);
            exit;
        }
        
        // Auto-generate slug nếu để trống
        if (empty($category_slug)) {
            $category_slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', 
                str_replace(['à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă','ằ','ắ','ặ','ẳ','ẵ','è','é','ẹ','ẻ','ẽ','ê','ề','ế','ệ','ể','ễ','ì','í','ị','ỉ','ĩ','ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ','ờ','ớ','ợ','ở','ỡ','ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ','ỳ','ý','ỵ','ỷ','ỹ','đ'],
                ['a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','e','e','e','e','e','e','e','e','e','e','e','i','i','i','i','i','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','u','u','u','u','u','u','u','u','u','u','u','y','y','y','y','y','d'],
                strtolower($category_name)
            )));
            $category_slug = trim($category_slug, '-');
        }
        if (empty($category_slug)) $category_slug = 'category-' . $category_id;
        
        // Kiểm tra slug trùng (trừ chính nó)
        $check = $db->query(sprintf("SELECT category_id FROM account_categories WHERE category_slug = %s AND category_id != %s", secure($category_slug), secure($category_id, 'int')));
        if ($check && $check->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Slug danh mục đã tồn tại']);
            exit;
        }
        
        $category_image = null;
        if (!empty($_FILES['category_image']['name']) && $_FILES['category_image']['error'] == UPLOAD_ERR_OK) {
            $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['category_image']['tmp_name']);
            finfo_close($finfo);
            if (in_array($mime, $allowed) && $_FILES['category_image']['size'] <= 4 * 1024 * 1024) {
                $uploads_dir = rtrim($system['uploads_directory'] ?? 'content/uploads', '/');
                $upload_dir = rtrim(ABSPATH, '/') . '/' . $uploads_dir . '/category_images/';
                if (!is_dir($upload_dir)) @mkdir($upload_dir, 0755, true);
                $ext = pathinfo($_FILES['category_image']['name'], PATHINFO_EXTENSION) ?: 'jpg';
                $filename = 'cat_' . time() . '_' . uniqid() . '.' . strtolower($ext);
                if (move_uploaded_file($_FILES['category_image']['tmp_name'], $upload_dir . $filename)) {
                    $category_image = 'category_images/' . $filename;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Không thể lưu ảnh. Kiểm tra quyền ghi thư mục content/uploads/category_images/']);
                    exit;
                }
            } else {
                $err = $_FILES['category_image']['error'] ?? 0;
                $msg = ($err == UPLOAD_ERR_INI_SIZE || $_FILES['category_image']['size'] > 4 * 1024 * 1024) ? 'Ảnh quá lớn (tối đa 4MB)' : 'Định dạng ảnh không hợp lệ (JPG, PNG, GIF, WebP)';
                echo json_encode(['success' => false, 'message' => $msg]);
                exit;
            }
        }
        
        // Lưu tên/mô tả dạng text gốc (không htmlentities) để giữ đúng tiếng Việt
        $name_safe = "'" . $db->real_escape_string($category_name) . "'";
        $desc_safe = "'" . $db->real_escape_string($category_description) . "'";
        if ($category_image) {
            $update = $db->query(sprintf(
                "UPDATE account_categories SET category_name = %s, category_slug = %s, category_image = %s, category_price = %s, category_description = %s WHERE category_id = %s",
                $name_safe, secure($category_slug), secure($category_image), secure($category_price, 'float'), $desc_safe, secure($category_id, 'int')
            ));
        } else {
            $update = $db->query(sprintf(
                "UPDATE account_categories SET category_name = %s, category_slug = %s, category_price = %s, category_description = %s WHERE category_id = %s",
                $name_safe, secure($category_slug), secure($category_price, 'float'), $desc_safe, secure($category_id, 'int')
            ));
        }
        
        if ($update) {
            echo json_encode(['success' => true, 'message' => 'Đã cập nhật danh mục!', 'reload' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật: ' . $db->error]);
        }
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        exit;
    }
}

// Handle delete category action (admin only)
if (isset($_POST['action']) && $_POST['action'] == 'delete_category') {
    header('Content-Type: application/json; charset=utf-8');
    
    try {
        if (!$user->_is_admin) {
            echo json_encode(['success' => false, 'message' => 'Bạn không có quyền thực hiện thao tác này']);
            exit;
        }
        
        $category_id = intval($_POST['category_id'] ?? 0);
        if (!$category_id) {
            echo json_encode(['success' => false, 'message' => 'ID danh mục không hợp lệ']);
            exit;
        }
        
        // Kiểm tra bảng account_orders tồn tại và có đơn hàng không
        $checkOrders = $db->query("SHOW TABLES LIKE 'account_orders'");
        if ($checkOrders && $checkOrders->num_rows > 0) {
            $orders = $db->query(sprintf("SELECT COUNT(*) as c FROM account_orders WHERE category_id = %s", secure($category_id, 'int')));
            if ($orders) {
                $row = $orders->fetch_assoc();
                if ($row && isset($row['c']) && intval($row['c']) > 0) {
                    echo json_encode(['success' => false, 'message' => 'Không thể xóa danh mục đã có đơn hàng. Hãy ẩn danh mục thay vì xóa.']);
                    exit;
                }
            }
        }
        
        // Set category_id = NULL cho market_accounts (nếu có cột)
        $checkCol = $db->query("SHOW COLUMNS FROM market_accounts LIKE 'category_id'");
        if ($checkCol && $checkCol->num_rows > 0) {
            $db->query(sprintf("UPDATE market_accounts SET category_id = NULL WHERE category_id = %s", secure($category_id, 'int')));
        }
        
        $del = $db->query(sprintf("DELETE FROM account_categories WHERE category_id = %s", secure($category_id, 'int')));
        
        if ($del) {
            echo json_encode(['success' => true, 'message' => 'Đã xóa danh mục!', 'reload' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa: ' . ($db->error ?: 'Không xác định')]);
        }
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        exit;
    }
}

// API get category detail (for edit form)
if (isset($_GET['action']) && $_GET['action'] == 'get_category' && isset($_GET['id'])) {
    header('Content-Type: application/json; charset=utf-8');
    if (!$user->_is_admin) {
        echo json_encode(['success' => false]);
        exit;
    }
    $id = intval($_GET['id']);
    $r = $db->query(sprintf("SELECT * FROM account_categories WHERE category_id = %s", secure($id, 'int')));
    if ($r && $r->num_rows > 0) {
        echo json_encode(['success' => true, 'category' => $r->fetch_assoc()]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

// Handle import Excel action (admin only)
if (isset($_POST['action']) && $_POST['action'] == 'import_excel') {
    header('Content-Type: application/json; charset=utf-8');
    
    try {
        // Check admin permission
        if (!$user->_is_admin) {
            echo json_encode(['success' => false, 'message' => 'Bạn không có quyền thực hiện thao tác này']);
            exit;
        }
        
        require_once('includes/import-accounts.php');
        $importer = new AccountImporter();
        $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : null;
        $result = $importer->importFromFile($_FILES['excel_file'] ?? null, $category_id);
        
        echo json_encode($result);
        exit;
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false, 
            'message' => 'Lỗi hệ thống: ' . $e->getMessage() . ' (File: ' . $e->getFile() . ', Line: ' . $e->getLine() . ')'
        ]);
        exit;
    }
}

// Handle buy account action
if (isset($_POST['action']) && $_POST['action'] == 'buy_accounts') {
    header('Content-Type: application/json; charset=utf-8');
    
    try {
        $category_id = intval($_POST['category_id'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 1);
        
        if (!$category_id || $quantity < 1) {
            echo json_encode(['success' => false, 'message' => 'Thông tin không hợp lệ']);
            exit;
        }
        
        require_once('includes/class-account-order.php');
        $orderHandler = new AccountOrderHandler();
        $result = $orderHandler->createOrder($user->_data['user_id'], $category_id, $quantity);
        
        if (!empty($result['redirect_url'])) {
            $result['redirect_url'] = rtrim($system['system_url'], '/') . $result['redirect_url'];
        }
        
        echo json_encode($result);
        exit;
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false, 
            'message' => 'Lỗi: ' . $e->getMessage()
        ]);
        exit;
    }
}

// Handle payment callback
if (isset($_GET['action']) && $_GET['action'] == 'payment_callback') {
    $order_id = intval($_GET['order_id'] ?? 0);
    $status = $_GET['status'] ?? '';
    
    if ($order_id && $status == 'success') {
        require_once('includes/class-account-order.php');
        $orderHandler = new AccountOrderHandler();
        $orderHandler->completeOrder($order_id, $user->_data['user_id']);
        
        header('Location: ' . $system['system_url'] . '/buy-account?view=order&order_id=' . $order_id);
        exit;
    }
}

// Get view - mặc định là 'list'
$view = $_GET['view'] ?? 'list';

// page header
page_header(__("Mua Tài Khoản"), __("Mua tài khoản các dịch vụ"));

// Get data based on view
switch ($view) {
    case 'history':
        // Redirect sang Tài khoản đã mua
        header('Location: ' . $system['system_url'] . '/buy-account?view=my-accounts' . (isset($_GET['page']) ? '&page=' . intval($_GET['page']) : ''));
        exit;
        
    case 'details':
        $account_id = intval($_GET['account_id'] ?? 0);
        
        if (!$account_id) {
            _error(404);
        }
        
        $query = sprintf("SELECT * FROM market_accounts WHERE AccMarketID = %s", secure($account_id, 'int'));
        $result = $db->query($query) or _error('SQL_ERROR');
        
        if ($result->num_rows == 0) {
            _error(404);
        }
        
        $account = $result->fetch_assoc();
        
        // Chỉ chủ sở hữu hoặc admin mới xem được tài khoản đã bán
        if ($account['Status'] == 'sold') {
            $owner_id = intval($account['SoldTo'] ?? 0);
            if (!$user->_is_admin && $owner_id != $user->_data['user_id']) {
                _error(403);
            }
        }
        
        $smarty->assign('page', 'buy-account');
        $smarty->assign('view', 'details');
        $smarty->assign('account', $account);
        $smarty->assign('is_admin', $user->_is_admin);
        break;
        
    case 'my-accounts':
        // Bảng danh sách đơn hàng đã mua - nhấn Chi tiết mở danh sách tài khoản đầy đủ
        $page = intval($_GET['page'] ?? 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $checkTable = $db->query("SHOW TABLES LIKE 'account_orders'");
        if (!$checkTable || $checkTable->num_rows == 0) {
            $orders = [];
            $total = 0;
            $totalPages = 0;
        } else {
            $ordersQuery = sprintf("SELECT o.*, c.category_name, c.category_image 
                FROM account_orders o 
                LEFT JOIN account_categories c ON o.category_id = c.category_id 
                WHERE o.user_id = %s AND o.status IN ('paid','completed') 
                ORDER BY o.created_at DESC 
                LIMIT %d OFFSET %d", 
                secure($user->_data['user_id'], 'int'),
                $limit,
                $offset
            );
            $ordersResult = $db->query($ordersQuery);
            $orders = [];
            $uploadsBase = rtrim($system['system_url'], '/') . '/' . trim($system['uploads_directory'] ?? 'content/uploads', '/');
            if ($ordersResult) {
                while ($row = $ordersResult->fetch_assoc()) {
                    $itemsCountQuery = sprintf("SELECT COUNT(*) as count FROM account_order_items WHERE order_id = %s", secure($row['order_id'], 'int'));
                    $itemsCountResult = $db->query($itemsCountQuery);
                    $row['items_count'] = $itemsCountResult ? $itemsCountResult->fetch_assoc()['count'] : 0;
                    $row['category_image_url'] = '';
                    if (!empty($row['category_image'])) {
                        $relPath = ltrim($row['category_image'], '/');
                        $fullPath = ABSPATH . trim($system['uploads_directory'] ?? 'content/uploads', '/') . '/' . $relPath;
                        if (file_exists($fullPath) && is_readable($fullPath)) {
                            $row['category_image_url'] = $uploadsBase . '/' . $relPath;
                        }
                    }
                    $row['is_shopee'] = (stripos($row['category_name'] ?? '', 'shopee') !== false);
                    $orders[] = $row;
                }
            }
            $totalQuery = sprintf("SELECT COUNT(*) as total FROM account_orders WHERE user_id = %s AND status IN ('paid','completed')", secure($user->_data['user_id'], 'int'));
            $totalResult = $db->query($totalQuery);
            $total = $totalResult ? intval($totalResult->fetch_assoc()['total']) : 0;
            $totalPages = ceil($total / $limit);
        }
        
        $smarty->assign('page', 'buy-account');
        $smarty->assign('view', 'my-accounts');
        $smarty->assign('orders', $orders);
        $smarty->assign('current_page', $page);
        $smarty->assign('total_pages', $totalPages);
        $smarty->assign('total_orders', $total);
        $smarty->assign('has_orders', count($orders) > 0);
        break;
        
    case 'category':
        // Hiển thị danh sách tài khoản trong một danh mục
        $category_id = intval($_GET['category_id'] ?? 0);
        $page = intval($_GET['page'] ?? 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        if (!$category_id) {
            _error(404);
        }
        
        // Kiểm tra bảng account_categories
        $checkTable = $db->query("SHOW TABLES LIKE 'account_categories'");
        if (!$checkTable || $checkTable->num_rows == 0) {
            _error(404);
        }
        
        // Get category info
        $catQuery = sprintf("SELECT * FROM account_categories WHERE category_id = %s AND is_active = '1'", secure($category_id, 'int'));
        $catResult = $db->query($catQuery);
        
        if (!$catResult || $catResult->num_rows == 0) {
            _error(404);
        }
        
        $category = $catResult->fetch_assoc();
        
        // Get available accounts count
        $countQuery = sprintf("SELECT COUNT(*) as total FROM market_accounts WHERE category_id = %s AND Status = 'available'", secure($category_id, 'int'));
        $countResult = $db->query($countQuery);
        $total = $countResult ? intval($countResult->fetch_assoc()['total']) : 0;
        
        // Get accounts - dùng int trực tiếp cho LIMIT/OFFSET (tránh lỗi MySQL với chuỗi)
        $limitInt = intval($limit);
        $offsetInt = intval($offset);
        $query = sprintf("SELECT * FROM market_accounts WHERE category_id = %s AND Status = 'available' ORDER BY CreatedAt DESC LIMIT %d OFFSET %d", 
            secure($category_id, 'int'), 
            $limitInt, 
            $offsetInt
        );
        $result = $db->query($query);
        
        $accounts = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $accounts[] = $row;
            }
        }
        
        $totalPages = ceil($total / $limit);
        
        // Lấy tất cả danh mục cho modal import
        $catListResult = $db->query("SELECT category_id, category_name FROM account_categories WHERE is_active = '1' ORDER BY sort_order, category_name");
        $categories = [];
        if ($catListResult) {
            while ($r = $catListResult->fetch_assoc()) $categories[] = $r;
        }
        
        $smarty->assign('page', 'buy-account');
        $smarty->assign('view', 'category');
        $smarty->assign('category', $category);
        $smarty->assign('categories', $categories);
        $smarty->assign('has_categories', count($categories) > 0);
        $smarty->assign('accounts', $accounts);
        $smarty->assign('current_page', $page);
        $smarty->assign('total_pages', $totalPages);
        $smarty->assign('total_accounts', $total);
        $smarty->assign('has_accounts', count($accounts) > 0);
        break;
        
    case 'order':
        // Hiển thị chi tiết đơn hàng sau khi thanh toán
        $order_id = intval($_GET['order_id'] ?? 0);
        
        if (!$order_id) {
            _error(404);
        }
        
        // Kiểm tra bảng account_orders
        $checkTable = $db->query("SHOW TABLES LIKE 'account_orders'");
        if (!$checkTable || $checkTable->num_rows == 0) {
            _error(404);
        }
        
        // Get order info
        $orderQuery = sprintf("SELECT o.*, c.category_name, c.category_image 
            FROM account_orders o 
            LEFT JOIN account_categories c ON o.category_id = c.category_id 
            WHERE o.order_id = %s AND o.user_id = %s", 
            secure($order_id, 'int'), 
            secure($user->_data['user_id'], 'int')
        );
        $orderResult = $db->query($orderQuery);
        
        if (!$orderResult || $orderResult->num_rows == 0) {
            _error(404);
        }
        
        $order = $orderResult->fetch_assoc();
        
        // Get order items (accounts) - đầy đủ các trường
        $itemsQuery = sprintf("SELECT i.*, a.UserName, a.Pass, a.EmailPass, a.DocHomThu, a.AccType, a.Cookie, a.CookieEditor, a.Info 
            FROM account_order_items i 
            INNER JOIN market_accounts a ON i.account_id = a.AccMarketID 
            WHERE i.order_id = %s 
            ORDER BY i.item_id ASC", 
            secure($order_id, 'int')
        );
        $itemsResult = $db->query($itemsQuery);
        
        $order_items = [];
        if ($itemsResult) {
            while ($row = $itemsResult->fetch_assoc()) {
                $order_items[] = $row;
            }
        }
        
        $smarty->assign('page', 'buy-account');
        $smarty->assign('view', 'order');
        $smarty->assign('order', $order);
        $smarty->assign('order_items', $order_items);
        break;
        
    case 'list':
    default:
        // Kiểm tra xem bảng account_categories có tồn tại không
        $checkTable = $db->query("SHOW TABLES LIKE 'account_categories'");
        
        if ($checkTable && $checkTable->num_rows > 0) {
            // Hiển thị danh sách các danh mục
            $categoriesQuery = "SELECT c.*, 
                COUNT(a.AccMarketID) as available_count 
                FROM account_categories c 
                LEFT JOIN market_accounts a ON c.category_id = a.category_id AND a.Status = 'available' 
                WHERE c.is_active = '1' 
                GROUP BY c.category_id 
                ORDER BY c.sort_order ASC, c.category_name ASC";
            $categoriesResult = $db->query($categoriesQuery);
            
            $categories = [];
            if ($categoriesResult) {
                while ($row = $categoriesResult->fetch_assoc()) {
                    $row['category_image_url'] = '';
                    if (!empty($row['category_image'])) {
                        $uploadsBase = rtrim($system['system_url'], '/') . '/' . trim($system['uploads_directory'] ?? 'content/uploads', '/');
                        $relPath = ltrim($row['category_image'], '/');
                        $fullPath = ABSPATH . trim($system['uploads_directory'] ?? 'content/uploads', '/') . '/' . $relPath;
                        if (file_exists($fullPath) && is_readable($fullPath)) {
                            $row['category_image_url'] = $uploadsBase . '/' . $relPath;
                        }
                    }
                    $row['is_shopee'] = (stripos($row['category_name'] ?? '', 'shopee') !== false);
                    $desc = trim($row['category_description'] ?? '');
                    $row['description_lines'] = $desc ? array_values(array_filter(array_map('trim', preg_split('/[\r\n;]+/', $desc)))) : [];
                    $categories[] = $row;
                }
            }
        } else {
            // Bảng chưa được tạo
            $categories = [];
        }
        
        $smarty->assign('page', 'buy-account');
        $smarty->assign('view', 'list');
        $smarty->assign('is_admin', $user->_is_admin);
        $smarty->assign('categories', $categories);
        $smarty->assign('has_categories', count($categories) > 0);
        break;
}

// page footer
page_footer('buy-account');
