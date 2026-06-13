<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (\PDOException $e) {
            // Log error in production, display in dev
            if (APP_ENV === 'development') {
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

    // Quick query helper
    public static function query($sql, $params = []) {
        $stmt = self::getInstance()->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Quick fetch helper
    public static function fetchAll($sql, $params = []) {
        return self::query($sql, $params)->fetchAll();
    }

    // Quick fetch single helper
    public static function fetch($sql, $params = []) {
        return self::query($sql, $params)->fetch();
    }

    // Last insert id
    public static function lastInsertId() {
        return self::getInstance()->getConnection()->lastInsertId();
    }
}
