<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "TIME: ".date('c').PHP_EOL;
echo "SAPI: ".php_sapi_name().PHP_EOL;
echo "PHP: ".PHP_VERSION.PHP_EOL;
echo "memory_limit: ".ini_get('memory_limit').PHP_EOL;
echo "error_log: ".(ini_get('error_log') ?: '(empty)').PHP_EOL;
echo "open_basedir: ".(ini_get('open_basedir') ?: '(none)').PHP_EOL;

$exts = ['pdo_mysql','mysqli','mbstring','intl','gd','zip','curl'];
foreach ($exts as $e) {
  echo "ext:$e=". (extension_loaded($e)?'yes':'no') . PHP_EOL;
}

$idx = __DIR__.'/index.php';
echo "index.php: ".(is_file($idx)?'found':'NOT FOUND').PHP_EOL;

// thử nạp bootstrap/index (nếu app lỗi sẽ 500 ngay tại đây)
try {
  if (is_file(__DIR__.'/bootstrap.php')) {
    require __DIR__.'/bootstrap.php';
    echo "bootstrap.php: OK".PHP_EOL;
  }
} catch (Throwable $e) {
  echo "BOOTSTRAP ERROR: ".$e->getMessage().PHP_EOL;
  echo "IN: ".$e->getFile().":".$e->getLine().PHP_EOL;
}

echo "DONE";
