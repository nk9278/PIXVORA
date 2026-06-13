<?php
// Mock DB Config for testing routes
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pixvora');
define('DB_CHARSET', 'utf8mb4');

define('APP_NAME', 'Pixvora');
define('APP_ENV', 'development');

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
//ini_set('session.cookie_secure', 1); // Disabled for local testing

if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

define('ALLOWED_MIME_TYPES', ['image/jpeg', 'image/png', 'image/webp']);
define('UPLOAD_DIR', PUBLIC_DIR . '/uploads/originals');
define('WEBP_DIR', PUBLIC_DIR . '/uploads/webp');
define('THUMB_DIR', PUBLIC_DIR . '/uploads/thumbnails');
