<?php
// Kết nối CSDL
require_once __DIR__ . '/../config/db.php';
$conn = getDbConnection();

$phone = $_GET['phone'] ?? null;
$customer = null;
$orders = [];

// Nếu có số điện thoại, truy vấn dữ liệu khách hàng và hóa đơn
if ($phone) {
    $stmt = $conn->prepare("SELECT * FROM customers WHERE phone = ?");
    $stmt->execute([$phone]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($customer) {
        $stmt = $conn->prepare("SELECT id, created_at, total_price FROM orders 
                                WHERE customer_id = ? ORDER BY created_at DESC");
        $stmt->execute([$customer['id']]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tra cứu hóa đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f7f7f7; padding: 20px; }
        h2 { margin-bottom: 20px; }
        .container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container">
    <h2>Tra cứu hóa đơn khách hàng</h2>
    
    <!-- Form nhập số điện thoại -->
    <form method="GET" action="Hoadon.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại khách hàng" required>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
    </form>

    <?php if ($customer): ?>
        <h3>Hóa đơn của khách hàng: <?= htmlspecialchars($customer['name']) ?> (<?= htmlspecialchars($customer['phone']) ?>)</h3>
        <?php if (!empty($orders)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã hóa đơn</th>
                        <th>Ngày tạo</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['created_at']) ?></td>
                        <td><?= number_format($order['total_price']) ?> VNĐ</td>
                        <td>
                            <a href="invoice_details.php?order_id=<?= $order['id'] ?>" class="btn btn-info btn-sm">Xem chi tiết</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-danger">Không có hóa đơn nào được tìm thấy.</p>
        <?php endif; ?>
    <?php elseif ($phone): ?>
        <p class="text-danger">Không tìm thấy khách hàng với số điện thoại: <?= htmlspecialchars($phone) ?></p>
    <?php endif; ?>
</div>

</body>
</html>
