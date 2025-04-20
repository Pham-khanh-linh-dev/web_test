<?php
require_once __DIR__ . '/../../core/DbCore.php';

class ProductModel {
    private $pdo;

    public function __construct() {
        $this->pdo = DbCore::getInstance()->getConnection();
    }

    public function getAllProducts($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $query = "SELECT p.id, p.barcode, p.name, p.category_id, p.purchase_price, p.selling_price, p.stock, p.created_by, p.created_at, c.name as category_name 
                  FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalProducts() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM products");
        return $stmt->fetchColumn();
    }

    public function addProduct($data) {
        $query = "INSERT INTO products (barcode, name, category_id, purchase_price, selling_price, stock, created_by) 
                  VALUES (:barcode, :name, :category_id, :purchase_price, :selling_price, :stock, :created_by)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':barcode'        => $data['barcode'],
            ':name'           => $data['name'],
            ':category_id'    => $data['category_id'],
            ':purchase_price' => $data['purchase_price'],
            ':selling_price'  => $data['selling_price'],
            ':stock'          => $data['stock'],
            ':created_by'     => $data['created_by']
        ]);
    }

    public function updateProduct($id, $data) {
        $query = "UPDATE products 
                  SET barcode = :barcode, name = :name, category_id = :category_id, 
                      purchase_price = :purchase_price, selling_price = :selling_price, 
                      stock = :stock, created_by = :created_by 
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':barcode'        => $data['barcode'],
            ':name'           => $data['name'],
            ':category_id'    => $data['category_id'],
            ':purchase_price' => $data['purchase_price'],
            ':selling_price'  => $data['selling_price'],
            ':stock'          => $data['stock'],
            ':created_by'     => $data['created_by'],
            ':id'             => $id
        ]);
    }

    public function deleteProduct($id) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
?>
