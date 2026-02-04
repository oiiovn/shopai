<?php
/**
 * Bootstrap cho ajax escrow: bắt mọi exception và fatal trước khi load bootstrap để trả JSON thay vì 500
 */
$escrow_ajax_sent = false;
set_exception_handler(function (Throwable $e) use (&$escrow_ajax_sent) {
  if ($escrow_ajax_sent) return;
  if (function_exists('ob_get_length') && ob_get_length()) @ob_clean();
  header('Content-Type: application/json; charset=utf-8');
  header('X-Escrow-Error: 1');
  echo json_encode([
    'error' => true,
    'message' => 'Lỗi: ' . $e->getMessage() . ' (file: ' . basename($e->getFile()) . ', dòng: ' . $e->getLine() . ')'
  ]);
  $escrow_ajax_sent = true;
  exit;
});
register_shutdown_function(function () use (&$escrow_ajax_sent) {
  if ($escrow_ajax_sent) return;
  $e = error_get_last();
  if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_RECOVERABLE_ERROR], true)) {
    if (function_exists('ob_get_length') && ob_get_length()) @ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    header('X-Escrow-Error: 1');
    echo json_encode([
      'error' => true,
      'message' => 'Fatal: ' . $e['message'] . ' (file: ' . basename($e['file']) . ', dòng: ' . $e['line'] . ')'
    ]);
  }
});
require(__DIR__ . '/../../bootstrap.php');
