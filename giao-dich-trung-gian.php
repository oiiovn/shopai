<?php

/**
 * giao-dich-trung-gian
 * Trang tin tức về tính năng Giao Dịch Trung Gian – user đọc & gửi phản hồi (quan tâm / góp ý)
 *
 * @package Sngine
 */

require('bootloader.php');

// Cho phép cả khách đọc trang; chỉ đăng nhập mới gửi được phản hồi (xử lý trong template + ajax)

try {
  page_header(__("Giao Dịch Trung Gian") . ' | ' . __($system['system_title']));
  $smarty->assign('page', 'giao-dich-trung-gian');
  page_footer('giao-dich-trung-gian');
} catch (Exception $e) {
  _error(__("Error"), $e->getMessage());
}
