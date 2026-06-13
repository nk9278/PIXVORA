<?php
class Security {

    /**
     * Generate and store CSRF token
     */
    public static function generateCsrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verify CSRF token from POST request
     */
    public static function verifyCsrfToken($token) {
        if (!isset($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Sanitize string output (prevent XSS)
     */
    public static function esc($string) {
        return htmlspecialchars($string ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Hash password
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Verify password
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    /**
     * Clean input string
     */
    public static function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        return isset($_SESSION['admin_id']);
    }

    /**
     * Require admin login
     */
    public static function requireAdmin() {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/admin/login');
            exit();
        }

        // Session timeout check
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
            session_unset();
            session_destroy();
            header('Location: ' . BASE_URL . '/admin/login?timeout=1');
            exit();
        }
        $_SESSION['last_activity'] = time();
    }
}
