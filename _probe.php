<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

/* Ghi mọi exception/error vào error_log */
set_exception_handler(function($e){
  error_log("[PROBE] Uncaught Exception: ".get_class($e).": ".$e->getMessage()." in ".$e->getFile().":".$e->getLine());
  foreach ($e->getTrace() as $i=>$t){
    $f = ($t['file']??'?').':'.($t['line']??'?');
    $fn = ($t['class']??'').($t['type']??'').($t['function']??'');
    error_log("[PROBE]  #$i $f  $fn");
  }
  http_response_code(500);
  echo "PROBE-EX"; // tránh lộ chi tiết ra trình duyệt
});

set_error_handler(function($no,$str,$file,$line){
  error_log("[PROBE] PHP Error [$no] $str in $file:$line");
  return false; // để vẫn cho PHP xử lý tiếp (và có thể fatal)
});

try {
  require __DIR__.'/index.php';
  echo "PROBE-OK";
} catch (Throwable $e) {
  error_log("[PROBE] Throwable: ".get_class($e).": ".$e->getMessage()." in ".$e->getFile().":".$e->getLine());
  http_response_code(500);
  echo "PROBE-THROW";
}
