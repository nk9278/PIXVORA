<?php
// Define constants
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . '/app');
define('PUBLIC_DIR', ROOT_DIR . '/public');
define('BASE_URL', 'http://localhost:8000'); // Assuming local development

// Basic autoloader
spl_autoload_register(function ($class) {
    $paths = [
        APP_DIR . '/core/',
        APP_DIR . '/models/',
        APP_DIR . '/controllers/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Initialize configuration and router
require_once APP_DIR . '/config/config.php';

// Front Controller Session Start (after config is loaded so ini_set applies properly)
session_start();

// Route the request
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);
