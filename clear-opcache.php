<?php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OpCache cleared successfully!\n";
} else {
    echo "OpCache not available\n";
}
?>
