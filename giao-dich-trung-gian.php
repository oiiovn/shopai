<?php

/**
 * giao-dich-trung-gian
 * Trang tin tức, tạo giao dịch, chi tiết giao dịch
 *
 * @package Sngine
 */

require('bootloader.php');

$view = isset($_GET['view']) ? $_GET['view'] : '';
$escrow_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
  if ($view === 'create') {
    user_access();
    require_once(ABSPATH . 'includes/escrow-init.php');
    escrow_ensure_tables($db);
    page_header(__("Tạo giao dịch trung gian") . ' | ' . __($system['system_title']));
    $smarty->assign('page', 'giao-dich-trung-gian');
    page_footer('giao-dich-trung-gian-create');
    exit;
  }

  if ($view === 'detail' && $escrow_id > 0) {
    user_access();
    require_once(ABSPATH . 'includes/escrow-init.php');
    escrow_ensure_tables($db);
    $tx = $db->query(sprintf("SELECT * FROM escrow_transactions WHERE id = %s", secure($escrow_id, 'int')));
    if (!$tx || $tx->num_rows === 0) {
      _error(404);
    }
    $escrow = $tx->fetch_assoc();
    $escrow['title'] = html_entity_decode((string)($escrow['title'] ?? ''), ENT_QUOTES, 'UTF-8');
    $my_id = (int)$user->_data['user_id'];
    if ((int)$escrow['seller_id'] !== $my_id && (int)$escrow['buyer_id'] !== $my_id) {
      _error(404);
    }
    $seller = $db->query(sprintf("SELECT user_id, user_name, user_firstname, user_lastname, user_gender, user_picture, user_verified FROM users WHERE user_id = %s", secure($escrow['seller_id'], 'int')));
    $buyer = $db->query(sprintf("SELECT user_id, user_name, user_firstname, user_lastname, user_gender, user_picture, user_verified FROM users WHERE user_id = %s", secure($escrow['buyer_id'], 'int')));
    $seller_row = $seller && $seller->num_rows ? $seller->fetch_assoc() : null;
    $buyer_row = $buyer && $buyer->num_rows ? $buyer->fetch_assoc() : null;
    $ln_s = $seller_row ? trim((string)($seller_row['user_lastname'] ?? '')) : '';
    $fn_s = $seller_row ? trim((string)($seller_row['user_firstname'] ?? '')) : '';
    $full_s = ($ln_s !== '' || $fn_s !== '') ? trim($ln_s . ' ' . $fn_s) : '';
    $escrow['seller_name'] = $seller_row ? ($full_s !== '' ? html_entity_decode($full_s, ENT_QUOTES, 'UTF-8') : $seller_row['user_name']) : '';
    $ln_b = $buyer_row ? trim((string)($buyer_row['user_lastname'] ?? '')) : '';
    $fn_b = $buyer_row ? trim((string)($buyer_row['user_firstname'] ?? '')) : '';
    $full_b = ($ln_b !== '' || $fn_b !== '') ? trim($ln_b . ' ' . $fn_b) : '';
    $escrow['buyer_name'] = $buyer_row ? ($full_b !== '' ? html_entity_decode($full_b, ENT_QUOTES, 'UTF-8') : $buyer_row['user_name']) : '';
    $escrow['seller_avatar'] = $seller_row ? get_picture($seller_row['user_picture'] ?? '', $seller_row['user_gender'] ?? '') : '';
    $escrow['buyer_avatar'] = $buyer_row ? get_picture($buyer_row['user_picture'] ?? '', $buyer_row['user_gender'] ?? '') : '';
    $escrow['seller_verified'] = !empty($seller_row['user_verified']);
    $escrow['buyer_verified'] = !empty($buyer_row['user_verified']);
    $fee = round($escrow['amount'] * (float)$escrow['fee_percent'] / 100, 0);
    $escrow['fee_amount'] = $fee;
    $fp = isset($escrow['fee_payer']) ? $escrow['fee_payer'] : 'buyer';
    if ($fp === 'buyer') {
      $escrow['total_buyer_pays'] = $escrow['amount'] + $fee;
      $escrow['seller_receives'] = $escrow['amount'];
    } elseif ($fp === 'seller') {
      $escrow['total_buyer_pays'] = $escrow['amount'];
      $escrow['seller_receives'] = $escrow['amount'] - $fee;
    } else {
      $half = round($fee / 2, 0);
      $escrow['total_buyer_pays'] = $escrow['amount'] + $half;
      $escrow['seller_receives'] = $escrow['amount'] - $half;
    }
    $escrow['is_seller'] = ((int)$escrow['seller_id'] === $my_id);
    $escrow['is_buyer'] = ((int)$escrow['buyer_id'] === $my_id);
    $msgs = $db->query(sprintf("SELECT m.*, u.user_name FROM escrow_messages m LEFT JOIN users u ON m.user_id = u.user_id WHERE m.transaction_id = %s ORDER BY m.id ASC", secure($escrow_id, 'int')));
    $messages = [];
    if ($msgs) {
      while ($r = $msgs->fetch_assoc()) {
        $r['message'] = html_entity_decode((string)($r['message'] ?? ''), ENT_QUOTES, 'UTF-8');
        if (isset($r['secret_content'])) {
          $r['secret_content'] = html_entity_decode((string)$r['secret_content'], ENT_QUOTES, 'UTF-8');
        }
        $messages[] = $r;
      }
    }
    $conds = $db->query(sprintf("SELECT * FROM escrow_conditions WHERE transaction_id = %s ORDER BY sort_order ASC", secure($escrow_id, 'int')));
    $conditions = [];
    if ($conds) {
      while ($r = $conds->fetch_assoc()) {
        $r['label'] = html_entity_decode((string)($r['label'] ?? ''), ENT_QUOTES, 'UTF-8');
        $conditions[] = $r;
      }
    }
    $secret_viewed = false;
    $sv = $db->query(sprintf("SELECT 1 FROM escrow_secret_views WHERE transaction_id = %s AND user_id = %s", secure($escrow_id, 'int'), secure($my_id, 'int')));
    if ($sv && $sv->num_rows > 0) {
      $secret_viewed = true;
    }
    $smarty->assign('page', 'giao-dich-trung-gian');
    $smarty->assign('escrow', $escrow);
    $smarty->assign('escrow_messages', $messages);
    $smarty->assign('escrow_conditions', $conditions);
    $smarty->assign('escrow_secret_viewed', $secret_viewed);
    $escrow['display_code'] = 'GDTG' . str_pad((string)$escrow_id, 6, '0', STR_PAD_LEFT);
    $smarty->assign('escrow', $escrow);
    page_header($escrow['display_code'] . ' : ' . ($escrow['title'] ?? '') . ' | ' . __($system['system_title']));
    page_footer('giao-dich-trung-gian-detail');
    exit;
  }

  if ($view === 'terms') {
    page_header(__("Điều khoản dịch vụ - Giao Dịch Trung Gian") . ' | ' . __($system['system_title']));
    $smarty->assign('page', 'giao-dich-trung-gian');
    page_footer('giao-dich-trung-gian-terms');
  } elseif ($view === 'fees') {
    page_header(__("Chính sách phí & thuế - Giao Dịch Trung Gian") . ' | ' . __($system['system_title']));
    $smarty->assign('page', 'giao-dich-trung-gian');
    page_footer('giao-dich-trung-gian-fees');
  } elseif ($view === 'privacy') {
    page_header(__("Chính sách bảo mật - Giao Dịch Trung Gian") . ' | ' . __($system['system_title']));
    $smarty->assign('page', 'giao-dich-trung-gian');
    page_footer('giao-dich-trung-gian-privacy');
  } elseif ($view === 'list') {
    user_access();
    require_once(ABSPATH . 'includes/escrow-init.php');
    escrow_ensure_tables($db);
    $my_id = (int)$user->_data['user_id'];
    $list = [];
    $q = $db->query(sprintf(
      "SELECT e.* FROM escrow_transactions e WHERE e.seller_id = %s OR e.buyer_id = %s ORDER BY e.id DESC",
      secure($my_id, 'int'),
      secure($my_id, 'int')
    ));
    if ($q) {
      while ($r = $q->fetch_assoc()) {
        $r['title'] = html_entity_decode((string)($r['title'] ?? ''), ENT_QUOTES, 'UTF-8');
        $r['display_code'] = 'GDTG' . str_pad((string)$r['id'], 6, '0', STR_PAD_LEFT);
        $r['is_seller'] = ((int)$r['seller_id'] === $my_id);
        $r['is_buyer'] = ((int)$r['buyer_id'] === $my_id);
        $list[] = $r;
      }
    }
    $smarty->assign('page', 'giao-dich-trung-gian');
    $smarty->assign('escrow_list', $list);
    page_header(__("Danh sách giao dịch trung gian") . ' | ' . __($system['system_title']));
    page_footer('giao-dich-trung-gian-list');
  } else {
    page_header(__("Giao Dịch Trung Gian") . ' | ' . __($system['system_title']));
    $smarty->assign('page', 'giao-dich-trung-gian');
    page_footer('giao-dich-trung-gian');
  }
} catch (Exception $e) {
  _error(__("Error"), $e->getMessage());
}
