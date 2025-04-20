<?php
include_once __DIR__ . '/../config/auth_check.php';
include_once __DIR__ . '/../config/constants.php';

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'employee') {
    header('Location: ../views/auth/loginEmployee.php');
    exit();
}

// Lấy employee_id từ $userData
$employee_id = $userData['id'] ?? null;
if (!$employee_id) {
    echo "Không tìm thấy ID nhân viên.";
    exit();
}

$employee_name = $_SESSION['user'] ?? 'Employee';
$profile_image = BASE_URL . 'assets/img/default-profile.png';
$pageTitle = 'Chi tiết đơn hàng';

$order_id = $_GET['id'] ?? null;
if (!$order_id) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../core/DbCore.php';
$dbCore = DbCore::getInstance();
$db = $dbCore->getConnection();

// Lấy thông tin đơn hàng
$sql_order = "SELECT o.id, o.total_price, o.created_at, c.name as customer_name
              FROM orders o
              LEFT JOIN customers c ON o.customer_id = c.id
              WHERE o.id = :order_id AND o.employee_id = :employee_id";
$stmt_order = $db->prepare($sql_order);
$stmt_order->execute([
    ':order_id' => $order_id,
    ':employee_id' => $employee_id
]);
$order = $stmt_order->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: index.php');
    exit();
}

// Lấy chi tiết sản phẩm trong đơn hàng
$sql_items = "SELECT p.name, oi.quantity, oi.price
              FROM order_items oi
              JOIN products p ON oi.product_id = p.id
              WHERE oi.order_id = :order_id";
$stmt_items = $db->prepare($sql_items);
$stmt_items->execute([':order_id' => $order_id]);
$items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

include_once __DIR__ . '/../views/layout/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar-card p-3 mb-4 animate-fadein">
                <h5 class="text-center fw-bold mb-4" style="color: var(--primary-color);">CHỨC NĂNG</h5>
                <div class="row row-cols-1 g-3">
                    <div class="col">
                        <a href="index.php" class="text-decoration-none d-block text-center feature-link p-3 rounded active">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="fw-bold">Báo cáo</div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="../Banhang.php" class="text-decoration-none d-block text-center feature-link p-3 rounded">
                            <div class="feature-icon">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <div class="fw-bold">Bán hàng</div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="../Khachhang.php" class="text-decoration-none d-block text-center feature-link p-3 rounded">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="fw-bold">Khách hàng</div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="../sanpham.php" class="text-decoration-none d-block text-center feature-link p-3 rounded">
                            <div class="feature-icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="fw-bold">Sản phẩm</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h1 class="h4 mb-4">Chi tiết đơn hàng #<?php echo $order['id']; ?></h1>
                    <div class="mb-4">
                        <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                        <p><strong>Ngày tạo:</strong> <?php echo $order['created_at']; ?></p>
                        <p><strong>Tổng tiền:</strong> <?php echo number_format($order['total_price']); ?>₫</p>
                    </div>

                    <h5>Danh sách sản phẩm</h5>
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($item['price']); ?>₫</td>
                                    <td><?php echo number_format($item['quantity'] * $item['price']); ?>₫</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <a href="index.php" class="btn btn-primary">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include_once __DIR__ . '/../views/layout/footer.php'; ?>