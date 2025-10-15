<?php
/**
 * debug-host-complete
 * Debug file để kiểm tra host
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>=== DEBUG HOST COMPLETE ===</h2>";
echo "<p><strong>Time:</strong> " . date('Y-m-d H:i:s') . "</p>";

// Check PHP version
echo "<h3>PHP Information:</h3>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Current Directory:</strong> " . getcwd() . "</p>";

// Check file existence
echo "<h3>File Existence Check:</h3>";
$files = [
    'my-system.php',
    '.htaccess', 
    'content/themes/default/templates/my-system.tpl',
    'content/themes/default/templates/my-system-transactions.tpl',
    'content/themes/default/templates/_header.tpl',
    'content/themes/default/templates/_head.tpl',
    'content/themes/default/templates/_footer.tpl'
];

foreach($files as $file) {
    $exists = file_exists($file);
    $size = $exists ? filesize($file) : 0;
    $readable = $exists ? is_readable($file) : false;
    echo "<p>- <strong>$file</strong>: " . ($exists ? "✅ EXISTS ($size bytes)" : "❌ MISSING") . " " . ($readable ? "✅ READABLE" : "❌ NOT READABLE") . "</p>";
}

// Check .htaccess content
echo "<h3>.htaccess Check:</h3>";
if (file_exists('.htaccess')) {
    $htaccess_content = file_get_contents('.htaccess');
    if (strpos($htaccess_content, 'my-system') !== false) {
        echo "<p>✅ my-system rules found in .htaccess</p>";
        preg_match_all('/RewriteRule.*my-system.*/', $htaccess_content, $matches);
        foreach($matches[0] as $rule) {
            echo "<p><code>" . htmlspecialchars($rule) . "</code></p>";
        }
    } else {
        echo "<p>❌ my-system rules NOT found in .htaccess</p>";
    }
} else {
    echo "<p>❌ .htaccess file not found</p>";
}

// Check mod_rewrite
echo "<h3>Apache mod_rewrite:</h3>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<p>✅ mod_rewrite is enabled</p>";
    } else {
        echo "<p>❌ mod_rewrite is NOT enabled</p>";
    }
} else {
    echo "<p>⚠️ Cannot check mod_rewrite status</p>";
}

// Test system files
echo "<h3>System Files Test:</h3>";
$system_files = [
    'bootloader.php',
    'bootstrap.php',
    'includes/init.php'
];

foreach($system_files as $file) {
    $exists = file_exists($file);
    echo "<p>- $file: " . ($exists ? "✅ EXISTS" : "❌ MISSING") . "</p>";
}

// Test database connection
echo "<h3>Database Connection Test:</h3>";
try {
    if (file_exists('bootloader.php')) {
        echo "<p>✅ bootloader.php exists</p>";
        
        // Try to include bootloader to test database
        ob_start();
        include_once 'bootloader.php';
        ob_end_clean();
        
        if (isset($db)) {
            echo "<p>✅ Database connection available</p>";
            
            // Test users_wallets_transactions table
            $result = $db->query("SHOW TABLES LIKE 'users_wallets_transactions'");
            if ($result && $result->num_rows > 0) {
                echo "<p>✅ users_wallets_transactions table exists</p>";
                
                // Count records
                $count_result = $db->query("SELECT COUNT(*) as total FROM users_wallets_transactions");
                $count = $count_result->fetch_assoc()['total'];
                echo "<p>📊 Total transactions: $count</p>";
            } else {
                echo "<p>❌ users_wallets_transactions table NOT found</p>";
            }
        } else {
            echo "<p>❌ Database connection not available</p>";
        }
    } else {
        echo "<p>❌ bootloader.php not found</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ Error testing system: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test direct access
echo "<h3>Direct Access Test:</h3>";
echo "<p><a href='my-system.php?view=transactions' target='_blank'>Test: my-system.php?view=transactions</a></p>";
echo "<p><a href='my-system/transactions' target='_blank'>Test: my-system/transactions (rewrite)</a></p>";

// Check PHP extensions
echo "<h3>PHP Extensions:</h3>";
$required_extensions = ['mysqli', 'json', 'mbstring', 'curl'];
foreach($required_extensions as $ext) {
    echo "<p>- $ext: " . (extension_loaded($ext) ? "✅" : "❌") . "</p>";
}

// Check permissions
echo "<h3>Permissions Check:</h3>";
$permissions_files = ['my-system.php', '.htaccess'];
foreach($permissions_files as $file) {
    if (file_exists($file)) {
        $perms = fileperms($file);
        $perms_octal = substr(sprintf('%o', $perms), -4);
        echo "<p>- $file: $perms_octal</p>";
    }
}

echo "<h3>Error Log Check:</h3>";
$error_logs = [
    '/var/log/apache2/error.log',
    '/var/log/httpd/error_log',
    '/home/' . get_current_user() . '/error_log',
    'error_log'
];

foreach($error_logs as $log) {
    if (file_exists($log)) {
        echo "<p>✅ Found: $log</p>";
        $last_errors = shell_exec("tail -5 $log 2>/dev/null");
        if ($last_errors) {
            echo "<pre>" . htmlspecialchars($last_errors) . "</pre>";
        }
        break;
    }
}

echo "<p><strong>=== END DEBUG ===</strong></p>";
?>
