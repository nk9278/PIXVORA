<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pixvora');
define('DB_CHARSET', 'utf8mb4');

// Application Configuration
define('APP_NAME', 'Pixvora');
define('APP_ENV', 'production'); // Forced to production for Phase 12
define('BASE_URL', 'https://trypixvora.com');

// Session Configuration & Security
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1); // Require HTTPS
ini_set('session.cookie_samesite', 'Strict'); // CSRF defense in depth

// Error Reporting
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', APP_DIR . '/logs/php_errors.log');
    error_reporting(E_ALL);
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
define('RESPONSIVE_DIR', PUBLIC_DIR . '/uploads/responsive');
define('GENERATED_DIR', PUBLIC_DIR . '/uploads/generated');
define('PNG_DIR', PUBLIC_DIR . '/uploads/png');
