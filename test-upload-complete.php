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
$_POST['multiple'] = 'false';  // Thêm dòng này

echo "Testing upload with complete parameters...\n";
echo "Secret match: " . ($_SESSION['secret'] == $_POST['secret'] ? 'YES' : 'NO') . "\n";
echo "Multiple: " . $_POST['multiple'] . "\n";

try {
    $response = upload_file(true);
    echo "Upload successful!\n";
    print_r($response);
} catch (Exception $e) {
    echo "Upload failed: " . $e->getMessage() . "\n";
}
