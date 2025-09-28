<?php
// Debug GPT Verify
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'debug-gpt.log');

echo "=== DEBUG GPT VERIFY ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n";
echo "POST data: " . print_r($_POST, true) . "\n";
echo "FILES data: " . print_r($_FILES, true) . "\n";

// Test database connection
try {
    require_once('Script/bootloader.php');
    echo "Database connection: OK\n";
    echo "User logged in: " . ($user->_logged_in ? 'YES' : 'NO') . "\n";
    if ($user->_logged_in) {
        echo "User ID: " . $user->_data['user_id'] . "\n";
    }
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}

// Test OpenAI API key
try {
    include_once('Script/includes/openai-functions.php');
    $openai_api_key = getOpenAIAPIKey();
    echo "OpenAI API key: " . (empty($openai_api_key) ? 'NOT SET' : 'SET') . "\n";
} catch (Exception $e) {
    echo "OpenAI functions error: " . $e->getMessage() . "\n";
}

echo "=== END DEBUG ===\n";
?>
