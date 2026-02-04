<?php
/**
 * ajax -> escrow-transaction
 * Tạo giao dịch, tin nhắn, xem thông tin bảo mật, xác nhận hoàn tất, khiếu nại
 */
require(__DIR__ . '/escrow-bootstrap.php');
if (function_exists('ob_get_length') && ob_get_length()) {
  ob_clean();
}
if (!$user->_logged_in) {
  return_json(['error' => true, 'message' => __('Vui lòng đăng nhập.')]);
}
global $db;
require(ABSPATH . 'includes/escrow-init.php');
$action = isset($_POST['action']) ? trim($_POST['action']) : (isset($_GET['action']) ? trim($_GET['action']) : '');
if ($action === '') {
  return_json(['error' => true, 'message' => __('Thiếu action.')]);
}

if ($action === 'search_buyer') {
  $query = isset($_GET['q']) ? trim($_GET['q']) : (isset($_POST['q']) ? trim($_POST['q']) : '');
  $list = [];
  if (strlen($query) >= 1) {
    $me = (int)$user->_data['user_id'];
    $q = $db->query(sprintf(
      "SELECT user_id, user_name, user_firstname, user_lastname, user_gender, user_picture, user_verified FROM users WHERE user_id != %s AND (user_name LIKE %s OR user_firstname LIKE %s OR user_lastname LIKE %s OR CONCAT(TRIM(user_firstname), ' ', TRIM(user_lastname)) LIKE %s) ORDER BY user_name ASC LIMIT 10",
      secure($me, 'int'),
      secure($query, 'search'),
      secure($query, 'search'),
      secure($query, 'search'),
      secure($query, 'search')
    ));
    if ($q) {
      while ($row = $q->fetch_assoc()) {
        $fn = html_entity_decode(trim($row['user_firstname'] ?? ''), ENT_QUOTES, 'UTF-8');
        $ln = html_entity_decode(trim($row['user_lastname'] ?? ''), ENT_QUOTES, 'UTF-8');
        $display = trim($fn . ' ' . $ln) ?: $row['user_name'];
        $list[] = [
          'user_name' => $row['user_name'],
          'display_name' => $display,
          'avatar' => get_picture($row['user_picture'] ?? '', $row['user_gender'] ?? ''),
          'user_verified' => !empty($row['user_verified']) ? 1 : 0
        ];
      }
    }
  }
  return_json(['list' => $list]);
}

function escrow_get_tx($db, $id, $user_id) {
  $q = $db->query(sprintf(
    "SELECT * FROM escrow_transactions WHERE id = %s AND (seller_id = %s OR buyer_id = %s)",
    secure($id, 'int'),
    secure($user_id, 'int'),
    secure($user_id, 'int')
  ));
  return $q && $q->num_rows ? $q->fetch_assoc() : null;
}

try {
  escrow_ensure_tables($db);

  if ($action === 'create') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $amount = isset($_POST['amount']) ? floatval(str_replace([',', ' '], ['', ''], $_POST['amount'])) : 0;
    $buyer_username = isset($_POST['buyer_username']) ? trim($_POST['buyer_username']) : '';
    $conditions_text = isset($_POST['conditions']) ? trim($_POST['conditions']) : '';
    $fee_payer = isset($_POST['fee_payer']) && in_array($_POST['fee_payer'], ['buyer', 'seller', 'split'], true) ? $_POST['fee_payer'] : 'buyer';
    $inspection_hours = isset($_POST['inspection_hours']) ? (int)$_POST['inspection_hours'] : 24;
    if (!in_array($inspection_hours, [12, 24, 48], true)) {
      $inspection_hours = 24;
    }

    if ($title === '' || $amount < 1000) {
      return_json(['error' => true, 'message' => __('Tiêu đề và giá trị đơn hàng (tối thiểu 1.000đ) là bắt buộc.')]);
    }
    if ($buyer_username === '') {
      return_json(['error' => true, 'message' => __('Vui lòng nhập username người mua.')]);
    }
    $get_buyer = $db->query(sprintf("SELECT user_id FROM users WHERE user_name = %s", secure($buyer_username)));
    if (!$get_buyer || $get_buyer->num_rows === 0) {
      return_json(['error' => true, 'message' => __('Không tìm thấy người dùng với username này.')]);
    }
    $buyer = $get_buyer->fetch_assoc();
    $buyer_id = (int)$buyer['user_id'];
    $seller_id = (int)$user->_data['user_id'];
    if ($buyer_id === $seller_id) {
      return_json(['error' => true, 'message' => __('Người mua không được trùng với người bán.')]);
    }

    $fee_percent = 5.00;
    $db->query(sprintf(
      "INSERT INTO escrow_transactions (seller_id, buyer_id, title, amount, fee_percent, fee_payer, inspection_hours, status) VALUES (%s, %s, %s, %s, %s, %s, %s, 'pending_deposit')",
      secure($seller_id, 'int'),
      secure($buyer_id, 'int'),
      secure($title, 'string'),
      secure($amount, 'float'),
      secure($fee_percent, 'float'),
      secure($fee_payer, 'string'),
      secure($inspection_hours, 'int')
    ));
    $tx_id = $db->insert_id;
    $lines = array_filter(array_map('trim', explode("\n", $conditions_text)));
    $sort = 0;
    foreach ($lines as $line) {
      if ($line === '') continue;
      $label_sql = "'" . $db->real_escape_string($line) . "'";
      $db->query(sprintf(
        "INSERT INTO escrow_conditions (transaction_id, label, sort_order) VALUES (%s, %s, %s)",
        secure($tx_id, 'int'),
        $label_sql,
        secure($sort++, 'int')
      ));
    }
    return_json(['success' => true, 'transaction_id' => (int)$tx_id, 'message' => __('Tạo giao dịch thành công.')]);
  }

  $tx_id = isset($_POST['transaction_id']) ? (int)$_POST['transaction_id'] : 0;
  $tx = $tx_id ? escrow_get_tx($db, $tx_id, $user->_data['user_id']) : null;
  if (!$tx) {
    return_json(['error' => true, 'message' => __('Giao dịch không tồn tại hoặc bạn không có quyền.')]);
  }

  if ($action === 'send_message') {
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $is_secret = !empty($_POST['is_secret']);
    $secret_content = $is_secret && isset($_POST['secret_content']) ? trim($_POST['secret_content']) : '';
    if ($message === '' && !$is_secret) {
      return_json(['error' => true, 'message' => __('Nội dung tin nhắn không được để trống.')]);
    }
    if ($is_secret && $secret_content === '') {
      return_json(['error' => true, 'message' => __('Nội dung bảo mật không được để trống.')]);
    }
    $db->query(sprintf(
      "INSERT INTO escrow_messages (transaction_id, user_id, message, is_secret, secret_content) VALUES (%s, %s, %s, %s, %s)",
      secure($tx_id, 'int'),
      secure($user->_data['user_id'], 'int'),
      secure($message, 'string'),
      secure($is_secret ? 1 : 0, 'int'),
      secure($secret_content, 'string')
    ));
    return_json(['success' => true, 'message' => __('Đã gửi.')]);
  }

  if ($action === 'reveal_secret') {
    $msg_id = isset($_POST['message_id']) ? (int)$_POST['message_id'] : 0;
    $msg_q = $db->query(sprintf("SELECT id, transaction_id, user_id, is_secret, secret_content FROM escrow_messages WHERE id = %s AND transaction_id = %s AND is_secret = 1", secure($msg_id, 'int'), secure($tx_id, 'int')));
    if (!$msg_q || $msg_q->num_rows === 0) {
      return_json(['error' => true, 'message' => __('Tin nhắn không hợp lệ.')]);
    }
    $msg_row = $msg_q->fetch_assoc();
    $buyer_id = (int)$tx['buyer_id'];
    if ((int)$user->_data['user_id'] !== $buyer_id) {
      return_json(['error' => true, 'message' => __('Chỉ người mua được xem thông tin bảo mật.')]);
    }
    $db->query(sprintf(
      "INSERT IGNORE INTO escrow_secret_views (transaction_id, user_id) VALUES (%s, %s)",
      secure($tx_id, 'int'),
      secure($user->_data['user_id'], 'int')
    ));
    $content = html_entity_decode((string)($msg_row['secret_content'] ?? ''), ENT_QUOTES, 'UTF-8');
    return_json(['success' => true, 'secret_content' => $content]);
  }

  if ($action === 'pay_from_balance') {
    if ((int)$user->_data['user_id'] !== (int)$tx['buyer_id']) {
      return_json(['error' => true, 'message' => __('Chỉ người mua có thể thanh toán.')]);
    }
    if ($tx['status'] !== 'pending_deposit') {
      return_json(['error' => true, 'message' => __('Trạng thái giao dịch không phù hợp.')]);
    }
    $amount = floatval($tx['amount']);
    $fee_percent = (float)($tx['fee_percent'] ?? 5);
    $fee = round($amount * $fee_percent / 100, 0);
    $fp = isset($tx['fee_payer']) ? $tx['fee_payer'] : 'buyer';
    if ($fp === 'buyer') {
      $total_pay = $amount + $fee;
    } elseif ($fp === 'seller') {
      $total_pay = $amount;
    } else {
      $total_pay = $amount + round($fee / 2, 0);
    }
    $total_pay = floatval($total_pay);
    $buyer_id = (int)$tx['buyer_id'];
    $bal = $db->query(sprintf("SELECT user_wallet_balance FROM users WHERE user_id = %s", secure($buyer_id, 'int')));
    if (!$bal || $bal->num_rows === 0) {
      return_json(['error' => true, 'message' => __('Không lấy được số dư.')]);
    }
    $row = $bal->fetch_assoc();
    $current = floatval($row['user_wallet_balance'] ?? 0);
    if ($current < $total_pay) {
      global $system;
      $recharge_url = (isset($system['system_url']) ? $system['system_url'] : '') . '/finance/recharge';
      $msg = __('Số dư không đủ. Cần ') . number_format($total_pay, 0, ',', '.') . ' đ. Số dư hiện tại: ' . number_format($current, 0, ',', '.') . ' đ. ' . __('Vui lòng') . ' <a href="' . $recharge_url . '">' . __('nạp thêm') . '</a>.';
      return_json(['error' => true, 'message' => $msg]);
    }
    $desc = 'Giao dịch trung gian #' . $tx_id . ' - Thanh toán';
    if (!$db->query("START TRANSACTION")) {
      return_json(['error' => true, 'message' => __('Lỗi bắt đầu giao dịch DB.') . ($db->error ? ' ' . $db->error : '')]);
    }
    $uq = $db->query(sprintf("UPDATE users SET user_wallet_balance = user_wallet_balance - %s WHERE user_id = %s", secure($total_pay, 'float'), secure($buyer_id, 'int')));
    if (!$uq) {
      $db->query("ROLLBACK");
      return_json(['error' => true, 'message' => __('Lỗi trừ số dư.') . ($db->error ? ' ' . $db->error : '')]);
    }
    $transQuery = sprintf("INSERT INTO users_wallets_transactions (user_id, type, amount, description, time) VALUES (%s, 'send', %s, %s, NOW())", secure($buyer_id, 'int'), secure($total_pay, 'float'), secure($desc, 'string'));
    if (!$db->query($transQuery)) {
      $db->query("ROLLBACK");
      return_json(['error' => true, 'message' => __('Lỗi ghi giao dịch ví.') . ($db->error ? ' ' . $db->error : '')]);
    }
    $eq = $db->query(sprintf("UPDATE escrow_transactions SET status = 'locked' WHERE id = %s", secure($tx_id, 'int')));
    if (!$eq) {
      $db->query("ROLLBACK");
      return_json(['error' => true, 'message' => __('Lỗi cập nhật trạng thái.') . ($db->error ? ' ' . $db->error : '')]);
    }
    $db->query("COMMIT");
    return_json(['success' => true, 'message' => __('Đã thanh toán từ số dư. Tiền đã được khóa.')]);
  }

  if ($action === 'set_deposit_done') {
    if ((int)$user->_data['user_id'] !== (int)$tx['buyer_id']) {
      return_json(['error' => true, 'message' => __('Chỉ người mua có thể xác nhận đã nạp tiền.')]);
    }
    if ($tx['status'] !== 'pending_deposit') {
      return_json(['error' => true, 'message' => __('Trạng thái giao dịch không phù hợp.')]);
    }
    $db->query(sprintf("UPDATE escrow_transactions SET status = 'locked' WHERE id = %s", secure($tx_id, 'int')));
    return_json(['success' => true, 'message' => __('Đã xác nhận tiền đã nạp.')]);
  }

  if ($action === 'set_delivering') {
    if ((int)$user->_data['user_id'] !== (int)$tx['seller_id']) {
      return_json(['error' => true, 'message' => __('Chỉ người bán có thể chuyển trạng thái đang giao.')]);
    }
    if ($tx['status'] !== 'locked') {
      return_json(['error' => true, 'message' => __('Trạng thái giao dịch không phù hợp.')]);
    }
    $db->query(sprintf("UPDATE escrow_transactions SET status = 'delivering' WHERE id = %s", secure($tx_id, 'int')));
    return_json(['success' => true, 'message' => __('Đã chuyển sang đang giao hàng.')]);
  }

  if ($action === 'confirm_complete') {
    $buyer_id = (int)$tx['buyer_id'];
    $seller_id = (int)$tx['seller_id'];
    if ((int)$user->_data['user_id'] !== $buyer_id) {
      return_json(['error' => true, 'message' => __('Chỉ người mua có thể xác nhận hoàn tất.')]);
    }
    if ($tx['status'] !== 'delivering' && $tx['status'] !== 'locked') {
      return_json(['error' => true, 'message' => __('Trạng thái giao dịch không phù hợp.')]);
    }
    $chk = $db->query(sprintf("SELECT COUNT(*) as total, SUM(is_checked) as checked FROM escrow_conditions WHERE transaction_id = %s", secure($tx_id, 'int')));
    if ($chk && $row = $chk->fetch_assoc()) {
      $total = (int)$row['total'];
      $checked = (int)$row['checked'];
      if ($total > 0 && $checked !== $total) {
        return_json(['error' => true, 'message' => __('Bạn phải tích đủ tất cả điều kiện hoàn tất trước khi xác nhận.')]);
      }
    }
    $amount = floatval($tx['amount']);
    $fee_percent = floatval($tx['fee_percent'] ?? 5);
    $fee = round($amount * $fee_percent / 100, 0);
    $fp = isset($tx['fee_payer']) ? $tx['fee_payer'] : 'buyer';
    if ($fp === 'buyer') {
      $seller_receives = $amount;
    } elseif ($fp === 'seller') {
      $seller_receives = $amount - $fee;
    } else {
      $seller_receives = $amount - round($fee / 2, 0);
    }
    $seller_receives = abs(floatval($seller_receives));
    $display_code = 'GDTG' . str_pad((string)$tx_id, 6, '0', STR_PAD_LEFT);
    $desc = sprintf('Nhận tiền từ giao dịch trung gian %s', $display_code);

    $db->query("START TRANSACTION");
    $uq = $db->query(sprintf("UPDATE users SET user_wallet_balance = user_wallet_balance + %s WHERE user_id = %s", secure($seller_receives, 'float'), secure($seller_id, 'int')));
    if (!$uq) {
      $db->query("ROLLBACK");
      return_json(['error' => true, 'message' => __('Không thể cập nhật số dư người bán.') . ' ' . $db->error]);
    }
    $ins = $db->query(sprintf(
      "INSERT INTO users_wallets_transactions (user_id, type, amount, description, time) VALUES (%s, 'receive', %s, %s, NOW())",
      secure($seller_id, 'int'),
      secure($seller_receives, 'float'),
      secure($desc, 'string')
    ));
    if (!$ins) {
      $db->query("ROLLBACK");
      return_json(['error' => true, 'message' => __('Không thể ghi lịch sử giao dịch.') . ' ' . $db->error]);
    }
    $eq = $db->query(sprintf("UPDATE escrow_transactions SET status = 'completed' WHERE id = %s", secure($tx_id, 'int')));
    if (!$eq) {
      $db->query("ROLLBACK");
      return_json(['error' => true, 'message' => __('Không thể cập nhật trạng thái giao dịch.') . ' ' . $db->error]);
    }
    $db->query("COMMIT");
    return_json(['success' => true, 'message' => __('Giao dịch đã hoàn tất. Số tiền thực nhận đã được cộng vào ví người bán.')]);
  }

  if ($action === 'open_dispute') {
    if ($tx['status'] === 'completed' || $tx['status'] === 'cancelled') {
      return_json(['error' => true, 'message' => __('Không thể khiếu nại giao dịch này.')]);
    }
    $reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $db->query(sprintf(
      "INSERT INTO escrow_disputes (transaction_id, raised_by_user_id, reason, description, status) VALUES (%s, %s, %s, %s, 'open')",
      secure($tx_id, 'int'),
      secure($user->_data['user_id'], 'int'),
      secure($reason, 'string'),
      secure($description, 'string')
    ));
    $db->query(sprintf("UPDATE escrow_transactions SET status = 'disputed' WHERE id = %s", secure($tx_id, 'int')));
    return_json(['success' => true, 'message' => __('Hệ thống đã ghi nhận khiếu nại. Admin sẽ xử lý.')]);
  }

  if ($action === 'toggle_condition') {
    $cond_id = isset($_POST['condition_id']) ? (int)$_POST['condition_id'] : 0;
    $c = $db->query(sprintf("SELECT id, is_checked FROM escrow_conditions WHERE id = %s AND transaction_id = %s", secure($cond_id, 'int'), secure($tx_id, 'int')));
    if (!$c || $c->num_rows === 0) {
      return_json(['error' => true, 'message' => __('Điều kiện không tồn tại.')]);
    }
    $row = $c->fetch_assoc();
    if ($row['is_checked']) {
      return_json(['error' => true, 'message' => __('Đã tích không thể bỏ tích.')]);
    }
    $db->query(sprintf("UPDATE escrow_conditions SET is_checked = 1 WHERE id = %s", secure($cond_id, 'int')));
    return_json(['success' => true, 'is_checked' => 1]);
  }

  return_json(['error' => true, 'message' => __('Action không hợp lệ.')]);
} catch (Throwable $e) {
  if (isset($db) && $db) {
    @$db->query("ROLLBACK");
  }
  return_json(['error' => true, 'message' => 'Lỗi: ' . $e->getMessage() . ' (dòng ' . $e->getLine() . ')']);
}
