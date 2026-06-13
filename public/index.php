<?php
// Define constants
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . '/app');
define('PUBLIC_DIR', ROOT_DIR . '/public');
// BASE_URL defined in config

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

// Initialize configuration
require_once APP_DIR . '/config/config.php';

// Front Controller Session Start
session_start();

// Route the request
$router = new Router();

// Phase 6 explicit download route
$router->add('download/{slug}/{format}', ['controller' => 'DownloadController', 'action' => 'process']);

$router->dispatch($_SERVER['REQUEST_URI']);
