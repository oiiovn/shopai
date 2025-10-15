<?php

/**
 * config - PRODUCTION VERSION
 * 
 * @package Sngine
 * @author Zamblek
 */

// ** MySQL settings ** //
/** The name of the database */
define('DB_NAME', 'your_production_database_name');

/** MySQL database username */
define('DB_USER', 'your_production_db_username');

/** MySQL database password */
define('DB_PASSWORD', 'your_production_db_password');

/** MySQL hostname */
define('DB_HOST', 'localhost'); // hoặc IP server production

/** MySQL port */
define('DB_PORT', '3306'); // port mặc định cho production


// ** System URL ** //
define('SYS_URL', 'https://yourdomain.com'); // URL production của bạn


// ** i18n settings ** //
define('DEFAULT_LOCALE', 'vi_vn');


/**
 * For developers: Debugging mode.
 * 
 * PRODUCTION: Set to false
 */
define('DEBUGGING', false);

// ** LICENCE ** //
/**
 * A unique key for your licence.
 */
define('LICENCE_KEY', '');

// ** JWT Secret ** //
/**
 * JWT Secret for API authentication
 * Generate a strong random string for production
 */
define('JWT_SECRET', 'your_jwt_secret_key_here');

// ** Additional Production Settings ** //

// ** File Upload Settings ** //
define('MAX_FILE_SIZE', 10485760); // 10MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// ** Security Settings ** //
define('ENABLE_CSRF_PROTECTION', true);
define('SESSION_TIMEOUT', 3600); // 1 hour

// ** API Settings ** //
define('CHECKSOPRO_API_TOKEN', '1770dd4e380567afd3668f8a9be69c21c587e08da9c5b75b5269174291ec7076');
define('PAY2S_API_URL', 'https://api.pay2s.com');
define('VIETQR_API_URL', 'https://api.vietqr.io');

// ** Cron Job Settings ** //
define('CRON_ENABLED', true);
define('SHOP_AI_RECHARGE_CHECK_INTERVAL', 300); // 5 minutes
define('BANK_TRANSACTION_SYNC_INTERVAL', 600); // 10 minutes

// ** Cache Settings ** //
define('CACHE_ENABLED', true);
define('CACHE_LIFETIME', 3600); // 1 hour

// ** Error Reporting ** //
if (DEBUGGING) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../../logs/error.log');
}
