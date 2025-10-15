<?php
echo "<h2>LiteSpeed Test</h2>";

// Test direct access
echo "<h3>1. Test Direct Access:</h3>";
echo "<p><a href='my-system.php?view=transactions' target='_blank'>my-system.php?view=transactions</a></p>";

// Test rewrite
echo "<h3>2. Test Rewrite:</h3>";
echo "<p><a href='my-system/transactions' target='_blank'>my-system/transactions</a></p>";

// Test with different URLs
echo "<h3>3. Test Different URLs:</h3>";
echo "<p><a href='my-system' target='_blank'>my-system</a></p>";
echo "<p><a href='my-system/' target='_blank'>my-system/</a></p>";

// Check $_GET parameters
echo "<h3>4. Current GET Parameters:</h3>";
echo "<pre>";
print_r($_GET);
echo "</pre>";

// Check $_SERVER
echo "<h3>5. Server Info:</h3>";
echo "<p><strong>REQUEST_URI:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p><strong>SCRIPT_NAME:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p><strong>PATH_INFO:</strong> " . ($_SERVER['PATH_INFO'] ?? 'Not set') . "</p>";

// Test .htaccess rules manually
echo "<h3>6. Manual .htaccess Test:</h3>";
if (isset($_GET['view'])) {
    echo "<p>✅ GET parameter 'view' = " . $_GET['view'] . "</p>";
    
    if ($_GET['view'] == 'transactions') {
        echo "<p>✅ View is 'transactions' - This should work!</p>";
        
        // Try to include bootloader
        if (file_exists('bootloader.php')) {
            echo "<p>✅ bootloader.php exists</p>";
            
            try {
                include_once 'bootloader.php';
                
                if (isset($smarty)) {
                    echo "<p>✅ Smarty loaded</p>";
                    
                    // Test template
                    if (file_exists('content/themes/default/templates/my-system.tpl')) {
                        echo "<p>✅ Template exists</p>";
                        
                        // Assign view
                        $smarty->assign('view', 'transactions');
                        echo "<p>✅ View assigned to Smarty</p>";
                        
                        // Test database
                        if (isset($db)) {
                            echo "<p>✅ Database connection available</p>";
                            
                            $result = $db->query("SELECT COUNT(*) as total FROM users_wallets_transactions");
                            $count = $result->fetch_assoc()['total'];
                            echo "<p>✅ Database query successful: $count transactions</p>";
                        }
                    }
                }
            } catch (Exception $e) {
                echo "<p>❌ Error: " . $e->getMessage() . "</p>";
            }
        }
    }
} else {
    echo "<p>❌ No 'view' parameter found</p>";
    echo "<p>This means .htaccess rewrite is not working</p>";
}

echo "<h3>7. LiteSpeed Specific:</h3>";
echo "<p><strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

// Check if it's LiteSpeed
if (strpos($_SERVER['SERVER_SOFTWARE'], 'LiteSpeed') !== false) {
    echo "<p>⚠️ LiteSpeed detected - may need different .htaccess syntax</p>";
}

echo "<p><strong>=== END TEST ===</strong></p>";
?>
