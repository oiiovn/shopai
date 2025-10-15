<?php
require_once('bootstrap.php');

echo "Session secret: " . (isset($_SESSION['secret']) ? $_SESSION['secret'] : 'NOT SET') . "\n";
echo "POST secret: " . (isset($_POST['secret']) ? $_POST['secret'] : 'NOT SET') . "\n";

// Check where secret is generated
if (isset($_SESSION['secret'])) {
    echo "Secret exists: " . $_SESSION['secret'] . "\n";
} else {
    echo "Secret NOT in session - this causes upload failure!\n";
}
