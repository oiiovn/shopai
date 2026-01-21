<?php

/**
 * TCSN Health Check Script
 * Kiểm tra tình trạng hệ thống sau deployment
 */

// Cấu hình
$config = [
    'database' => [
        'host' => 'localhost',
        'port' => '3306',
        'name' => 'your_database_name',
        'user' => 'your_database_user',
        'pass' => 'your_database_password'
    ],
    'system_url' => 'https://yourdomain.com',
    'required_tables' => [
        'users', 'pages', 'posts', 'page_business_types', 
        'shop_ai_ranks', 'users_wallets_transactions',
        'qr_code_mapping', 'phone_check_history'
    ],
    'required_directories' => [
        'content/uploads',
        'content/cache',
        'content/themes/default/templates_compiled'
    ]
];

// Colors for output
$colors = [
    'red' => "\033[0;31m",
    'green' => "\033[0;32m",
    'yellow' => "\033[1;33m",
    'blue' => "\033[0;34m",
    'reset' => "\033[0m"
];

function printStatus($message, $status = 'info', $details = '') {
    global $colors;
    
    $statusColors = [
        'success' => $colors['green'] . '✅',
        'error' => $colors['red'] . '❌',
        'warning' => $colors['yellow'] . '⚠️',
        'info' => $colors['blue'] . 'ℹ️'
    ];
    
    echo $statusColors[$status] . " " . $message;
    if ($details) {
        echo " - " . $details;
    }
    echo $colors['reset'] . "\n";
}

function checkDatabase($config) {
    printStatus("Checking database connection...", 'info');
    
    try {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['name']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        printStatus("Database connection successful", 'success');
        return $pdo;
    } catch (Exception $e) {
        printStatus("Database connection failed", 'error', $e->getMessage());
        return false;
    }
}

function checkTables($pdo, $requiredTables) {
    printStatus("Checking required tables...", 'info');
    
    $missingTables = [];
    foreach ($requiredTables as $table) {
        try {
            $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
            if ($stmt->rowCount() == 0) {
                $missingTables[] = $table;
            }
        } catch (Exception $e) {
            $missingTables[] = $table;
        }
    }
    
    if (empty($missingTables)) {
        printStatus("All required tables exist", 'success');
    } else {
        printStatus("Missing tables found", 'error', implode(', ', $missingTables));
    }
    
    return empty($missingTables);
}

function checkDirectories($requiredDirs) {
    printStatus("Checking required directories...", 'info');
    
    $missingDirs = [];
    foreach ($requiredDirs as $dir) {
        if (!is_dir($dir) || !is_writable($dir)) {
            $missingDirs[] = $dir;
        }
    }
    
    if (empty($missingDirs)) {
        printStatus("All required directories exist and are writable", 'success');
    } else {
        printStatus("Missing or non-writable directories", 'error', implode(', ', $missingDirs));
    }
    
    return empty($missingDirs);
}

function checkFilePermissions() {
    printStatus("Checking file permissions...", 'info');
    
    $criticalFiles = [
        'includes/config.php' => '644',
        '.htaccess' => '644',
        'content/uploads' => '755',
        'content/cache' => '755'
    ];
    
    $issues = [];
    foreach ($criticalFiles as $file => $expectedPerm) {
        if (file_exists($file)) {
            $actualPerm = substr(sprintf('%o', fileperms($file)), -3);
            if ($actualPerm !== $expectedPerm) {
                $issues[] = "$file (expected: $expectedPerm, actual: $actualPerm)";
            }
        }
    }
    
    if (empty($issues)) {
        printStatus("File permissions are correct", 'success');
    } else {
        printStatus("File permission issues found", 'warning', implode(', ', $issues));
    }
    
    return empty($issues);
}

function checkSystemSettings($pdo) {
    printStatus("Checking system settings...", 'info');
    
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM system_settings");
        $result = $stmt->fetch();
        
        if ($result['count'] > 0) {
            printStatus("System settings configured", 'success', "{$result['count']} settings found");
        } else {
            printStatus("No system settings found", 'warning');
        }
        
        return true;
    } catch (Exception $e) {
        printStatus("Error checking system settings", 'error', $e->getMessage());
        return false;
    }
}

function checkShopAI($pdo) {
    printStatus("Checking Shop-AI configuration...", 'info');
    
    try {
        // Check ranks
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM shop_ai_ranks");
        $ranks = $stmt->fetch()['count'];
        
        // Check business types
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM page_business_types");
        $businessTypes = $stmt->fetch()['count'];
        
        if ($ranks > 0 && $businessTypes > 0) {
            printStatus("Shop-AI configuration complete", 'success', "Ranks: $ranks, Business Types: $businessTypes");
        } else {
            printStatus("Shop-AI configuration incomplete", 'warning', "Ranks: $ranks, Business Types: $businessTypes");
        }
        
        return true;
    } catch (Exception $e) {
        printStatus("Error checking Shop-AI configuration", 'error', $e->getMessage());
        return false;
    }
}

function checkAPIEndpoints($systemUrl) {
    printStatus("Checking API endpoints...", 'info');
    
    $endpoints = [
        '/shop-ai' => 'Shop-AI main page',
        '/api.php' => 'API endpoint',
        '/admin.php' => 'Admin panel'
    ];
    
    $issues = [];
    foreach ($endpoints as $endpoint => $description) {
        $url = $systemUrl . $endpoint;
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'method' => 'GET'
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            $issues[] = $description;
        }
    }
    
    if (empty($issues)) {
        printStatus("All API endpoints accessible", 'success');
    } else {
        printStatus("API endpoint issues", 'warning', implode(', ', $issues));
    }
    
    return empty($issues);
}

function generateReport($results) {
    global $colors;
    
    echo "\n" . $colors['blue'] . "📊 DEPLOYMENT HEALTH CHECK REPORT" . $colors['reset'] . "\n";
    echo str_repeat("=", 50) . "\n";
    
    $totalChecks = count($results);
    $passedChecks = array_sum($results);
    
    echo "Total Checks: $totalChecks\n";
    echo "Passed: " . $colors['green'] . $passedChecks . $colors['reset'] . "\n";
    echo "Failed: " . $colors['red'] . ($totalChecks - $passedChecks) . $colors['reset'] . "\n";
    echo "Success Rate: " . round(($passedChecks / $totalChecks) * 100, 2) . "%\n";
    
    if ($passedChecks == $totalChecks) {
        echo "\n" . $colors['green'] . "🎉 All checks passed! System is ready for production." . $colors['reset'] . "\n";
    } else {
        echo "\n" . $colors['yellow'] . "⚠️ Some checks failed. Please review and fix issues before going live." . $colors['reset'] . "\n";
    }
    
    echo "\n" . $colors['blue'] . "📋 Next Steps:" . $colors['reset'] . "\n";
    echo "1. Update config.php with production settings\n";
    echo "2. Setup cron jobs\n";
    echo "3. Configure SSL certificate\n";
    echo "4. Test all features\n";
    echo "5. Monitor error logs\n";
}

// Main execution
echo $colors['blue'] . "🏥 TCSN Health Check Starting..." . $colors['reset'] . "\n\n";

$results = [];

// Database check
$pdo = checkDatabase($config['database']);
$results['database'] = $pdo !== false;

if ($pdo) {
    // Table checks
    $results['tables'] = checkTables($pdo, $config['required_tables']);
    
    // System settings
    $results['system_settings'] = checkSystemSettings($pdo);
    
    // Shop-AI check
    $results['shop_ai'] = checkShopAI($pdo);
}

// Directory checks
$results['directories'] = checkDirectories($config['required_directories']);

// File permissions
$results['permissions'] = checkFilePermissions();

// API endpoints (optional, might fail in CLI)
$results['api_endpoints'] = checkAPIEndpoints($config['system_url']);

// Generate report
generateReport($results);

echo "\n" . $colors['blue'] . "Health check completed at " . date('Y-m-d H:i:s') . $colors['reset'] . "\n";
