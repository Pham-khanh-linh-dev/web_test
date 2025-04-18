<?php
// ProductModel.php

class ProductModel {

    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=da19db", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối DB lỗi: " . $e->getMessage());
        }
    }

    public function checkStock($product) {
        if (!isset($product["id"]) || !isset($product["name"]) || !isset($product["quantity"])) {
            die("Thiếu thông tin sản phẩm.");
        }

        $stmt = $this->pdo->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt->execute([$product["id"]]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            die("Sản phẩm {$product['name']} không tồn tại.");
        }

        $availableStock = $row["stock"];
        if ($product["quantity"] > $availableStock) {
            die("Sản phẩm {$product['name']} không đủ hàng. Tồn kho hiện tại: $availableStock");
        }
    }

    public function updateStock($product) {
        if (!isset($product["id"]) || !isset($product["quantity"])) {
            die("Thiếu thông tin sản phẩm để cập nhật tồn kho.");
        }

        $stmt = $this->pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt->execute([$product["quantity"], $product["id"]]);
    }
}
?>
