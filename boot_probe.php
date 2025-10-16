<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);
require __DIR__.'/bootstrap.php';
header('Content-Type: text/plain; charset=utf-8');
echo "BOOT_OK\n";
