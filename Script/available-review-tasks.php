<?php

/**
 * available-review-tasks - Redirect to new location
 * 
 * @package Sngine
 * @author Zamblek
 */

// fetch bootloader
require('bootloader.php');

// user access
if (!$user->_logged_in) {
    user_login();
}

// Redirect to dashboard since available-tasks is removed
header("Location: " . $system['system_url'] . "/google-maps-reviews/dashboard");
exit();

?>
