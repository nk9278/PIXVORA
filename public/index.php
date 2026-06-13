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

// Phase 7 PNG routes
$router->add('api/generate-png/{slug}', ['controller' => 'PngController', 'action' => 'generate']);
$router->add('download-png/{slug}', ['controller' => 'PngController', 'action' => 'download']);

// Phase 8 Search routes
$router->add('search', ['controller' => 'SearchController', 'action' => 'index']);
$router->add('search/{query}', ['controller' => 'SearchController', 'action' => 'index']);
$router->add('api/search-suggest', ['controller' => 'SearchController', 'action' => 'suggest']);

// Phase 10 Blog CMS routes
$router->add('blog', ['controller' => 'BlogController', 'action' => 'index']);
$router->add('blog/category/{category}', ['controller' => 'BlogController', 'action' => 'category']);
$router->add('blog/{slug}', ['controller' => 'BlogController', 'action' => 'article']);

// Phase 9 Programmatic SEO & Sitemap routes
$router->add('tag/{slug}', ['controller' => 'SeoController', 'action' => 'tag']);
$router->add('collection/{slug}', ['controller' => 'SeoController', 'action' => 'landing']);
// Override HomeController default category with SeoController for richer pages
$router->add('category/{slug}', ['controller' => 'SeoController', 'action' => 'category']);

$router->add('robots.txt', ['controller' => 'SitemapController', 'action' => 'robots']);
$router->add('sitemap.xml', ['controller' => 'SitemapController', 'action' => 'index']);
$router->add('sitemap-images.xml', ['controller' => 'SitemapController', 'action' => 'images']);
$router->add('sitemap-categories.xml', ['controller' => 'SitemapController', 'action' => 'categories']);

$router->dispatch($_SERVER['REQUEST_URI']);
