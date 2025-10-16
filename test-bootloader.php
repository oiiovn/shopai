<?php
echo "Testing bootloader...\n";
try {
    require_once('bootloader.php');
    echo "Bootloader loaded successfully\n";
    echo "ABSPATH: " . (defined('ABSPATH') ? ABSPATH : 'NOT DEFINED') . "\n";
    echo "System URL: " . (isset($system['system_url']) ? $system['system_url'] : 'NOT SET') . "\n";
} catch (Exception $e) {
    echo "Bootloader error: " . $e->getMessage() . "\n";
}
