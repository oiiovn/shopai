<?php
ini_set('log_errors', '1');
ini_set('display_errors', '0');
ini_set('error_log', '/home/sho73359/domains/shop-ai.vn/public_html/error_log');
error_reporting(E_ALL);
error_log("[PREPEND] ==== New request: ".($_SERVER['REQUEST_URI'] ?? "/")." at ".date('c')." ====");

set_error_handler(function($no,$str,$file,$line){
  error_log("[PREPEND] PHP Error [$no] $str in $file:$line");
  return false;
});
set_exception_handler(function($e){
  error_log("[PREPEND] Uncaught ".get_class($e).": ".$e->getMessage()." in ".$e->getFile().":".$e->getLine());
});
register_shutdown_function(function(){
  $e = error_get_last();
  if ($e && in_array($e['type'], [E_ERROR,E_PARSE,E_CORE_ERROR,E_COMPILE_ERROR])){
    error_log("[PREPEND] FATAL {$e['type']}: {$e['message']} in {$e['file']}:{$e['line']}");
  }
});
