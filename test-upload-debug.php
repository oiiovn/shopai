<?php
require_once('bootstrap.php');

// Generate secret if missing
if (!isset($_SESSION['secret'])) {
    $_SESSION['secret'] = md5(uniqid(rand(), true));
}

// Set required POST data
$_POST['secret'] = $_SESSION['secret'];
$_POST['handle'] = 'publisher';
$_POST['type'] = 'photos';

echo "Testing upload with secret...\n";
echo "Secret match: " . ($_SESSION['secret'] == $_POST['secret'] ? 'YES' : 'NO') . "\n";

try {
    $response = upload_file(true);
    echo "Upload successful!\n";
} catch (Exception $e) {
    echo "Upload failed: " . $e->getMessage() . "\n";
}
