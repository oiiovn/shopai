<?php

/**
 * my-system
 * Trang quản lý hệ thống riêng
 * 
 * @package Sngine
 * @author Custom
 */

// fetch bootloader
require('bootloader.php');

// user access
user_access();

// check admin access
if (!$user->_is_admin) {
  _error(403);
}

try {

  // page header
  page_header(__("Quản Lý Hệ Thống") . ' | ' . __($system['system_title']));

  // Khởi tạo biến mặc định
  $view = isset($_GET['view']) ? $_GET['view'] : '';
  
  // get view content
  switch ($view) {
    case '':
      // Trang chủ của hệ thống quản lý
      $smarty->assign('page_description', 'Trang quản lý hệ thống của bạn');
      break;

    case 'transactions':
      // Quản lý giao dịch
      $smarty->assign('page_description', 'Quản lý giao dịch hệ thống');
      
      // Check if this is an AJAX request
      $is_ajax = isset($_GET['ajax']) && $_GET['ajax'] == '1';
      
      // Get pagination parameters
      $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $limit = 10; // 10 transactions per page
      $offset = ($page - 1) * $limit;
      
      // Get and sanitize filter parameters
      $transaction_type = isset($_GET['type']) ? trim($_GET['type']) : '';
      $time_range = isset($_GET['time_range']) ? trim($_GET['time_range']) : '';
      $search_user = isset($_GET['search_user']) ? trim($_GET['search_user']) : '';
      $search_amount = isset($_GET['search_amount']) ? trim($_GET['search_amount']) : '';
      
      // Validate transaction type
      $valid_types = ['', 'recharge', 'withdraw'];
      if (!in_array($transaction_type, $valid_types)) {
        $transaction_type = '';
      }
      
      // Validate time range
      $valid_time_ranges = ['', 'today', 'yesterday', 'week', 'month', 'quarter', 'year'];
      if (!in_array($time_range, $valid_time_ranges)) {
        $time_range = '';
      }
      
      // Validate search amount (must be numeric)
      if ($search_amount && !is_numeric($search_amount)) {
        $search_amount = '';
      }
      
      // Build WHERE conditions (for prepared statements)
      $where_conditions = [];
      $where_conditions_safe = []; // For non-prepared fallback
      $params = [];
      $param_types = '';
      
      if ($transaction_type) {
        $where_conditions[] = "uwt.type = ?";
        $where_conditions_safe[] = "uwt.type = '" . $db->real_escape_string($transaction_type) . "'";
        $params[] = $transaction_type;
        $param_types .= 's';
      }
      
      if ($time_range) {
        $time_condition = "";
        switch ($time_range) {
          case 'today':
            $time_condition = "DATE(uwt.time) = CURDATE()";
            break;
          case 'yesterday':
            $time_condition = "DATE(uwt.time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
            break;
          case 'week':
            $time_condition = "uwt.time >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
            break;
          case 'month':
            $time_condition = "uwt.time >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            break;
          case 'quarter':
            $time_condition = "uwt.time >= DATE_SUB(NOW(), INTERVAL 90 DAY)";
            break;
          case 'year':
            $time_condition = "uwt.time >= DATE_SUB(NOW(), INTERVAL 365 DAY)";
            break;
        }
        if ($time_condition) {
          $where_conditions[] = $time_condition;
          $where_conditions_safe[] = $time_condition;
        }
      }
      
      if ($search_user) {
        // Search by user ID (exact match) or name (partial match)
        if (is_numeric($search_user)) {
          $where_conditions[] = "uwt.user_id = ?";
          $where_conditions_safe[] = "uwt.user_id = " . (int)$search_user;
          $params[] = (int)$search_user;
          $param_types .= 'i';
        } else {
          // Also search in HTML entity decoded names for better matching
          $where_conditions[] = "(u.user_name LIKE ? OR u.user_firstname LIKE ? OR u.user_lastname LIKE ? OR CONCAT(u.user_firstname, ' ', u.user_lastname) LIKE ? OR REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(CONCAT(u.user_firstname, ' ', u.user_lastname), '&agrave;', 'à'), '&egrave;', 'è'), '&igrave;', 'ì'), '&ograve;', 'ò'), '&ugrave;', 'ù') LIKE ?)";
          $search_pattern = "%$search_user%";
          $search_pattern_safe = "%" . $db->real_escape_string($search_user) . "%";
          $where_conditions_safe[] = "(u.user_name LIKE '$search_pattern_safe' OR u.user_firstname LIKE '$search_pattern_safe' OR u.user_lastname LIKE '$search_pattern_safe' OR CONCAT(u.user_firstname, ' ', u.user_lastname) LIKE '$search_pattern_safe' OR REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(CONCAT(u.user_firstname, ' ', u.user_lastname), '&agrave;', 'à'), '&egrave;', 'è'), '&igrave;', 'ì'), '&ograve;', 'ò'), '&ugrave;', 'ù') LIKE '$search_pattern_safe')";
          $params[] = $search_pattern;
          $params[] = $search_pattern;
          $params[] = $search_pattern;
          $params[] = $search_pattern;
          $params[] = $search_pattern;
          $param_types .= 'sssss';
        }
      }
      
      if ($search_amount) {
        $where_conditions[] = "uwt.amount = ?";
        $where_conditions_safe[] = "uwt.amount = " . (float)$search_amount;
        $params[] = (float)$search_amount;
        $param_types .= 'd';
      }
      
      $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
      $where_clause_safe = !empty($where_conditions_safe) ? "WHERE " . implode(" AND ", $where_conditions_safe) : "";
      
      // Get total count for pagination
      $count_query = "SELECT COUNT(*) as total 
                      FROM users_wallets_transactions uwt 
                      LEFT JOIN users u ON uwt.user_id = u.user_id 
                      $where_clause";
      
      try {
        if (!empty($params)) {
          $stmt = $db->prepare($count_query);
          if ($stmt) {
            $stmt->bind_param($param_types, ...$params);
            $stmt->execute();
            // Use bind_result instead of get_result for compatibility
            $stmt->bind_result($total_transactions);
            $stmt->fetch();
            $stmt->close();
          } else {
            throw new Exception("Failed to prepare count query");
          }
        } else {
          $total_result = $db->query($count_query);
          $total_transactions = $total_result->fetch_assoc()['total'];
        }
        
        $total_pages = ceil($total_transactions / $limit);
        
        // Validate page number
        if ($page > $total_pages && $total_pages > 0) {
          $page = $total_pages;
          $offset = ($page - 1) * $limit;
        }
        
        // Get transactions with pagination
        // Check if mysqlnd is available for get_result()
        $use_prepared = method_exists('mysqli_stmt', 'get_result');
        
        if ($use_prepared && !empty($params)) {
          // Use prepared statements with get_result (requires mysqlnd)
          $transactions_query = "SELECT uwt.*, u.user_name, u.user_firstname, u.user_lastname, u.user_gender, u.user_picture 
                                 FROM users_wallets_transactions uwt 
                                 LEFT JOIN users u ON uwt.user_id = u.user_id 
                                 $where_clause 
                                 ORDER BY uwt.time DESC 
                                 LIMIT ? OFFSET ?";
          $param_types .= 'ii';
          $params[] = $limit;
          $params[] = $offset;
          
          $stmt = $db->prepare($transactions_query);
          if ($stmt) {
            $stmt->bind_param($param_types, ...$params);
            $stmt->execute();
            $transactions_result = $stmt->get_result();
            $stmt->close();
          } else {
            throw new Exception("Failed to prepare transactions query");
          }
        } else {
          // Fallback to regular query with escaped values
          $transactions_query = "SELECT uwt.*, u.user_name, u.user_firstname, u.user_lastname, u.user_gender, u.user_picture 
                                 FROM users_wallets_transactions uwt 
                                 LEFT JOIN users u ON uwt.user_id = u.user_id 
                                 $where_clause_safe 
                                 ORDER BY uwt.time DESC 
                                 LIMIT $limit OFFSET $offset";
          $transactions_result = $db->query($transactions_query);
        }
        
      } catch (Exception $e) {
        // Fallback to basic query if prepared statement fails
        error_log("Transaction query error: " . $e->getMessage());
        $transactions_result = $db->query("SELECT uwt.*, u.user_name, u.user_firstname, u.user_lastname, u.user_gender, u.user_picture 
                                           FROM users_wallets_transactions uwt 
                                           LEFT JOIN users u ON uwt.user_id = u.user_id 
                                           ORDER BY uwt.time DESC 
                                           LIMIT $limit OFFSET $offset");
        $total_transactions = $db->query("SELECT COUNT(*) as total FROM users_wallets_transactions")->fetch_assoc()['total'];
        $total_pages = ceil($total_transactions / $limit);
      }
      
      $transactions = [];
      while ($transaction = $transactions_result->fetch_assoc()) {
        // Format user picture - always use get_picture() to handle empty/null cases
        $transaction['user_picture'] = get_picture($transaction['user_picture'], $transaction['user_gender']);
        
        // Format amount
        $transaction['formatted_amount'] = number_format($transaction['amount']) . ' VNĐ';
        
        // Format time
        $transaction['formatted_time'] = date('d/m/Y H:i:s', strtotime($transaction['time']));
        
        // Get user display name and decode HTML entities
        $transaction['user_display_name'] = html_entity_decode($transaction['user_firstname'] . ' ' . $transaction['user_lastname'], ENT_QUOTES, 'UTF-8');
        if (empty(trim($transaction['user_display_name']))) {
          $transaction['user_display_name'] = html_entity_decode($transaction['user_name'], ENT_QUOTES, 'UTF-8');
        }
        
        $transactions[] = $transaction;
      }
      
      // Assign variables to template
      $smarty->assign('transactions', $transactions);
      $smarty->assign('current_page', $page);
      $smarty->assign('total_pages', $total_pages);
      $smarty->assign('total_transactions', $total_transactions);
      $smarty->assign('has_transactions', count($transactions) > 0);
      
      // Pass filter values back to template
      $smarty->assign('current_type', $transaction_type);
      $smarty->assign('current_time_range', $time_range);
      $smarty->assign('current_search_user', $search_user);
      $smarty->assign('current_search_amount', $search_amount);
      
      // Debug information (only for admins)
      if ($user->_is_admin && isset($_GET['debug'])) {
        $smarty->assign('debug_info', [
          'total_transactions' => $total_transactions,
          'current_page' => $page,
          'total_pages' => $total_pages,
          'where_clause' => $where_clause,
          'params' => $params,
          'param_types' => $param_types
        ]);
      }
      
      // If AJAX request, only return the table content
      if ($is_ajax) {
        // Set content type for AJAX response
        header('Content-Type: text/html; charset=utf-8');
        
        // Output only the table content without full page structure
        echo '<div class="card-body">';
        
        if (count($transactions) > 0) {
          // Transaction Table
          echo '<div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
              <thead class="bg-light">
                <tr>
                  <th style="width: 80px;">ID</th>
                  <th style="width: 150px;">User</th>
                  <th style="width: 100px;">Loại</th>
                  <th style="width: 120px;">Số Tiền</th>
                  <th style="width: 200px;">Mô Tả</th>
                  <th style="width: 150px;">Thời Gian</th>
                  <th style="width: 100px;">Thao Tác</th>
                </tr>
              </thead>
              <tbody>';
          
          foreach ($transactions as $transaction) {
            echo '<tr>
              <td class="text-center">
                <strong>#' . $transaction['transaction_id'] . '</strong>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <img src="' . $transaction['user_picture'] . '" 
                       class="rounded-circle mr10" width="30" height="30">
                  <div>
                    <div class="font-weight-bold">' . $transaction['user_display_name'] . '</div>
                    <small class="text-muted">ID: ' . $transaction['user_id'] . '</small>
                  </div>
                </div>
              </td>
              <td class="text-center">';
            
            if ($transaction['type'] == "recharge") {
              echo '<span style="background-color: #198754; color: white; font-size: 11px; padding: 8px 15px; border-radius: 20px; font-weight: 600; display: inline-block; min-width: 80px; text-align: center;">
                <i class="fa fa-arrow-up mr5"></i>NẠP TIỀN
              </span>';
            } elseif ($transaction['type'] == "withdraw") {
              echo '<span style="background-color: #dc3545; color: white; font-size: 11px; padding: 8px 15px; border-radius: 20px; font-weight: 600; display: inline-block; min-width: 80px; text-align: center;">
                <i class="fa fa-arrow-down mr5"></i>RÚT TIỀN
              </span>';
            } else {
              echo '<span style="background-color: #6c757d; color: white; font-size: 11px; padding: 8px 15px; border-radius: 20px; font-weight: 600; display: inline-block; min-width: 80px; text-align: center;">
                <i class="fa fa-question mr5"></i>KHÁC
              </span>';
            }
            
            echo '</td>
              <td class="text-right">
                <span class="font-weight-bold ' . ($transaction['type'] == 'recharge' ? 'text-success' : ($transaction['type'] == 'withdraw' ? 'text-danger' : 'text-secondary')) . '">
                  ' . $transaction['formatted_amount'] . '
                </span>
              </td>
              <td>
                <span class="text-muted">' . htmlspecialchars($transaction['description'] ?: '-') . '</span>
              </td>
              <td class="text-center">
                <small>' . $transaction['formatted_time'] . '</small>
              </td>
              <td class="text-center">
                <button class="btn btn-sm btn-outline-primary" onclick="viewTransactionDetails(' . $transaction['transaction_id'] . ')">
                  <i class="fa fa-eye"></i>
                </button>
              </td>
            </tr>';
          }
          
          echo '</tbody>
            </table>
          </div>';
          
          // Pagination
          if ($total_pages > 1) {
            echo '<div class="text-center mt20">
              <nav>
                <ul class="pagination justify-content-center">';
            
            // Previous Page
            if ($page > 1) {
              echo '<li class="page-item">
                <a class="page-link" href="javascript:void(0)" onclick="loadPage(' . ($page-1) . ')">
                  <i class="fa fa-chevron-left mr5"></i>Trước
                </a>
              </li>';
            } else {
              echo '<li class="page-item disabled">
                <span class="page-link">
                  <i class="fa fa-chevron-left mr5"></i>Trước
                </span>
              </li>';
            }
            
            // Page Numbers
            for ($i = max(1, $page-2); $i <= min($total_pages, $page+2); $i++) {
              $activeClass = $i == $page ? 'active' : '';
              echo '<li class="page-item ' . $activeClass . '">
                <a class="page-link" href="javascript:void(0)" onclick="loadPage(' . $i . ')">
                  ' . $i . '
                </a>
              </li>';
            }
            
            // Next Page
            if ($page < $total_pages) {
              echo '<li class="page-item">
                <a class="page-link" href="javascript:void(0)" onclick="loadPage(' . ($page+1) . ')">
                  Sau<i class="fa fa-chevron-right ml5"></i>
                </a>
              </li>';
            } else {
              echo '<li class="page-item disabled">
                <span class="page-link">
                  Sau<i class="fa fa-chevron-right ml5"></i>
                </span>
              </li>';
            }
            
            echo '</ul>
              </nav>
            </div>';
          }
        } else {
          // No Transactions Message
          echo '<div class="text-center text-muted" style="padding: 60px 20px;">
            <i class="fa fa-exchange-alt fa-5x mb20" style="opacity: 0.3;"></i>
            <h4 class="mb10">Chưa có giao dịch nào</h4>
            <p class="text-muted">Không tìm thấy giao dịch phù hợp với bộ lọc</p>
          </div>';
        }
        
        echo '</div>';
        exit;
      }
      
      break;

    case 'number-check':
      // Quản lý check số
      $smarty->assign('page_description', 'Quản lý kiểm tra số điện thoại');
      break;

    case 'google-maps':
      // Quản lý chiến dịch Google Maps
      $smarty->assign('page_description', 'Quản lý chiến dịch Google Maps Reviews');
      break;

    default:
      _error(404);
      break;
  }
  
  /* assign variables */
  $smarty->assign('view', $view);

  // get ads campaigns
  $ads_campaigns = $user->ads_campaigns();
  /* assign variables */
  $smarty->assign('ads_campaigns', $ads_campaigns);

} catch (Exception $e) {
  _error(__("Error"), $e->getMessage());
}

// page footer
page_footer('my-system');

