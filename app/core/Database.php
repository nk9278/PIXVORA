<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // Defined in config
        $dsn = "mysql:host=" . (defined('DB_HOST') ? DB_HOST : 'localhost') . ";dbname=" . (defined('DB_NAME') ? DB_NAME : 'pixvora') . ";charset=" . (defined('DB_CHARSET') ? DB_CHARSET : 'utf8mb4');
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, defined('DB_USER') ? DB_USER : 'root', defined('DB_PASS') ? DB_PASS : '', $options);
        } catch (\PDOException $e) {
            // Log error in production, display in dev
            if (defined('APP_ENV') && APP_ENV === 'development') {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            } else {
                die("Database connection failed.");
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    public static function query($sql, $params = []) {
        $stmt = self::getInstance()->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetchAll($sql, $params = []) {
        return self::query($sql, $params)->fetchAll();
    }

    public static function fetch($sql, $params = []) {
        return self::query($sql, $params)->fetch();
    }

    public static function lastInsertId() {
        return self::getInstance()->getConnection()->lastInsertId();
    }
}
