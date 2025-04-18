<?php
require_once __DIR__ . '/../../config/db.php';

class CustomerModel {
    private function getConnection() {
        return getDbConnection();
    }

    public static function getAllCustomers() {
        $conn = getDbConnection();
        $sql = "SELECT id, name, phone, address FROM customers ORDER BY id DESC";
        $result = $conn->query($sql);

        $customers = [];
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $customers[] = $row;
            }
        }
        return $customers;
    }

    // ✅ Trả về ID khách hàng sau khi xử lý
    public function processCustomer($customerData) {
        $conn = getDbConnection();

        $phone = $customerData['phone'] ?? null;
        $name = $customerData['name'] ?? null;
        $address = $customerData['address'] ?? null;

        if (!$phone || !$name || !$address) {
            throw new Exception("Thiếu thông tin khách hàng!");
        }

        // Kiểm tra khách hàng đã tồn tại chưa
        $stmt = $conn->prepare("SELECT id FROM customers WHERE phone = ?");
        $stmt->execute([$phone]);

        if ($stmt->rowCount() == 0) {
            // Nếu chưa có thì thêm mới
            $insert = $conn->prepare("INSERT INTO customers (name, phone, address) VALUES (?, ?, ?)");
            $insert->execute([$name, $phone, $address]);

            return $conn->lastInsertId(); // Trả về ID mới
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id']; // Trả về ID cũ
        }
    }

    public function updateTotalSpent($customerId, $amount) {
        $db = $this->getConnection();

        error_log("Đang cập nhật khách hàng $customerId với số tiền $amount");

        $stmt = $db->prepare("UPDATE customers SET total_spent = total_spent + :amount WHERE id = :id");
        $stmt->execute([
            ':amount' => $amount,
            ':id' => $customerId
        ]);
    }

    public function getCustomerById($id) {
        $db = $this->getConnection();
        $stmt = $db->prepare("SELECT * FROM customers WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
