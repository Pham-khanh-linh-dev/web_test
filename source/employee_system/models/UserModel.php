<?php
require_once __DIR__ . '/../../config/db.php';

class User {
    private $conn;

    public function __construct() {
        $this->conn = getDbConnection(); // PDO object
    }

    public function getUserById($id) {
        $sql = "SELECT id, username, avatar FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }

        return null;
    }

    public function getUserByIdByUsername($username) {
        $sql = "SELECT id, username, avatar FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
}
?>
