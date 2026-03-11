<?php
/**
 * Application Configuration
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'paldeals');
define('DB_PORT', '3306');


// App Configuration
define('APP_NAME', 'PalDeals');
define('APP_VERSION', '1.0.0');
define('APP_ENV', 'development');

// Session Configuration
session_start();

// Timezone
date_default_timezone_set('UTC');
?>
