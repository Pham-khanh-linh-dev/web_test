<?php
class DbCore {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        require_once __DIR__ . '/../config/db.php';
        $this->pdo = getDbConnection();
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DbCore();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
