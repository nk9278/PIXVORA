<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pixvora');
define('DB_CHARSET', 'utf8mb4');

// Application Configuration
define('APP_NAME', 'Pixvora');
define('APP_ENV', 'development'); // development or production
define('BASE_URL', 'http://localhost:8000');

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
// ini_set('session.cookie_secure', 1); // Require HTTPS

// Error Reporting
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Allowed MIME types for uploads
define('ALLOWED_MIME_TYPES', [
    'image/jpeg',
    'image/png',
    'image/webp'
]);

// Upload directories
define('UPLOAD_DIR', PUBLIC_DIR . '/uploads/originals');
define('WEBP_DIR', PUBLIC_DIR . '/uploads/webp');
define('THUMB_DIR', PUBLIC_DIR . '/uploads/thumbnails');
