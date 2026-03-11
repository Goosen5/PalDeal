<?php
/**
 * Main entry point for the application
 */
// Define base path
define('BASE_PATH', dirname(dirname(__FILE__)));
define('PUBLIC_PATH', __DIR__);

// Set error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Serve static files directly when using PHP built-in server
$requested = $_SERVER['REQUEST_URI'];
$file = PUBLIC_PATH . $requested;
if (php_sapi_name() === 'cli-server' && is_file($file)) {
    return false;
}

// Load configuration
require_once BASE_PATH . '/config/config.php';

// Load application
require_once BASE_PATH . '/src/Application.php';

$app = new Application();
$app->run();
?>
