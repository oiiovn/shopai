<?php
// Force hiển thị lỗi
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// In lỗi fatal (nếu có) khi script kết thúc
register_shutdown_function(function () {
  $e = error_get_last();
  if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "=== FATAL CAUGHT BY WRAPPER ===\n";
    echo "Type: {$e['type']}\nFile: {$e['file']}\nLine: {$e['line']}\nMessage: {$e['message']}\n";
  }
});

ob_start();
require __DIR__ . '/index.php';
$out = ob_get_clean();

// Nếu không có fatal, in dấu “OK” để biết index chạy qua được
header('Content-Type: text/plain; charset=utf-8');
echo "INDEX_OK\n";
