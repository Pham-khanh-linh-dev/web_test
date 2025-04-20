<?php
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

    // Lấy tất cả sản phẩm (sao chép từ admin_system, đã sửa)
    public function getAllProducts($page = 1, $perPage = 10) {
        $perPage = max(1, (int)$perPage);
        $page = max(1, (int)$page);
        $offset = ($page - 1) * $perPage;

        $query = "SELECT p.id, p.barcode, p.name, p.category_id, p.selling_price, p.stock, p.created_at, c.name as category_name 
                  FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  LIMIT $perPage OFFSET $offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tổng số sản phẩm (sao chép từ admin_system, đã sửa)
    public function getTotalProducts() {
        $query = "SELECT COUNT(*) FROM products";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
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