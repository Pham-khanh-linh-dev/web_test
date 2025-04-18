<?php
session_start(); 
$fromDate = $_GET['from_date'] ?? date('Y-m-d');
$toDate = $_GET['to_date'] ?? date('Y-m-d');
$orderItems = $orderItems ?? [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand">Chi tiết đơn hàng</span>
        </div>
    </nav>

    <div class="container mt-4 bg-white p-4 shadow rounded">
        <h4>Chi tiết đơn hàng #<?= htmlspecialchars($_GET['id'] ?? '???') ?></h4>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($orderItems) > 0): ?>
                    <?php foreach ($orderItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price']) ?>₫</td>
                        <td><?= number_format($item['quantity'] * $item['price']) ?>₫</td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center">Không có chi tiết đơn hàng</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="javascript:history.back()" class="btn btn-secondary">← Quay lại</a>
    </div>

    <!-- <footer class="text-center py-3 text-muted">
        &copy; <?= date('Y') ?> Hệ thống báo cáo bán hàng
    </footer> -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
