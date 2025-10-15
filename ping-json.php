<?php
/**
 * PING JSON - Test JSON pipeline trên host
 * Dùng để xác nhận đường ống JSON sạch
 */

// Bịt rò rỉ
ob_start();
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '0');
error_reporting(E_ALL);

// Set error handler
set_error_handler(function($severity, $message, $file, $line) {
    if ($severity & (E_NOTICE | E_WARNING | E_DEPRECATED)) {
        error_log("PHP $severity: $message in $file:$line");
        return true;
    }
    return false;
});

// Shutdown function
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        ob_clean();
        echo json_encode([
            'success' => false,
            'error' => 'PHP_FATAL',
            'detail' => $error['message'] . ' in ' . $error['file'] . ':' . $error['line']
        ]);
    }
});

// Test JSON response
echo json_encode([
    'success' => true,
    'message' => 'JSON pipeline working',
    'timestamp' => date('Y-m-d H:i:s'),
    'php_version' => PHP_VERSION,
    'server' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'Unknown'
], JSON_UNESCAPED_UNICODE);
