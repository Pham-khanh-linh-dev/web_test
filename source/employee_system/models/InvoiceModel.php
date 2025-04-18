<?php
require_once(__DIR__ . '/../../config/db.php'); // Kết nối CSDL

class InvoiceModel {

    // Thêm khách hàng mới vào CSDL nếu chưa có
    public function processCustomer($customerData) {
        $conn = getDbConnection();
        $sql = "SELECT id FROM customers WHERE phone = :phone";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['phone' => $customerData['phone']]);
        $customer = $stmt->fetch();

        if (!$customer) {
            // Nếu khách hàng không tồn tại, thêm mới
            $sql = "INSERT INTO customers (name, phone, address) VALUES (:name, :phone, :address)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'name' => $customerData['name'],
                'phone' => $customerData['phone'],
                'address' => $customerData['address']
            ]);
        }
    }

    // Kiểm tra tồn kho của sản phẩm
    public function checkStock($productData) {
        $conn = getDbConnection();
        $sql = "SELECT stock FROM products WHERE id = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['product_id' => $productData['id']]);
        $product = $stmt->fetch();

        if ($product) {
            if ($product['stock'] < $productData['quantity']) {
                die("Sản phẩm không đủ số lượng trong kho!");
            }
        }
    }

    // Cập nhật tồn kho khi bán sản phẩm
    public function updateStock($productData) {
        $conn = getDbConnection();
        $sql = "UPDATE products SET stock = stock - :quantity WHERE id = :product_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'quantity' => $productData['quantity'],
            'product_id' => $productData['id']
        ]);
    }

    // Lưu hóa đơn vào CSDL
    public function saveInvoice($invoiceData) {
        $conn = getDbConnection();
        $sql = "INSERT INTO invoices (customer_id, total_amount, created_at) VALUES (:customer_id, :total_amount, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'customer_id' => $invoiceData['customer']['id'],
            'total_amount' => $invoiceData['total']
        ]);
        $invoiceId = $conn->lastInsertId();

        // Lưu thông tin chi tiết hóa đơn (sản phẩm trong hóa đơn)
        foreach ($invoiceData['products'] as $product) {
            $sql = "INSERT INTO invoice_details (invoice_id, product_id, quantity, price, total) VALUES (:invoice_id, :product_id, :quantity, :price, :total)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'invoice_id' => $invoiceId,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total' => $product['total']
            ]);
        }
    }
}
