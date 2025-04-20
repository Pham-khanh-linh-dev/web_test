<?php
require_once __DIR__ . '/../../core/DbCore.php';

class CategoryModel {
    private $db;

    public function __construct() {
        $dbCore = DbCore::getInstance();
        $this->db = $dbCore->getConnection(); // Sửa lỗi: gán $this->db
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY id ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addCategory($data) {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':name' => $data['name']]);
    }

    public function updateCategory($id, $data) {
        $sql = "UPDATE categories SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name']
        ]);
    }

    public function deleteCategory($id) {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>