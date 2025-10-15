<?php
// Simple test file
echo "<h2>Test My System</h2>";

// Test 1: Basic PHP
echo "<p>✅ PHP working</p>";

// Test 2: Check files
$files = ['my-system.php', '.htaccess'];
foreach($files as $file) {
    echo "<p>- $file: " . (file_exists($file) ? "✅" : "❌") . "</p>";
}

// Test 3: Test .htaccess
if (file_exists('.htaccess')) {
    $content = file_get_contents('.htaccess');
    if (strpos($content, 'my-system') !== false) {
        echo "<p>✅ .htaccess has my-system rules</p>";
    } else {
        echo "<p>❌ .htaccess missing my-system rules</p>";
    }
}

// Test 4: Test direct access
echo "<p><a href='my-system.php?view=transactions'>Test Direct: my-system.php?view=transactions</a></p>";

// Test 5: Test rewrite
echo "<p><a href='my-system/transactions'>Test Rewrite: my-system/transactions</a></p>";

echo "<p><strong>If direct works but rewrite doesn't, it's a .htaccess issue.</strong></p>";
?>
