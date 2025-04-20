<?php
include_once __DIR__ . '/config/constants.php';
include_once __DIR__ . '/config/auth_check.php';

$employee_id = $userData['id'] ?? null;
if (!$employee_id) {
    echo "Không tìm thấy ID người dùng.";
    exit();
}

$employee_name = $_SESSION['user'] ?? 'Employee';
$pageTitle = 'Danh sách sản phẩm';

require_once __DIR__ . '/models/ProductModel.php';
$productModel = new ProductModel();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$products = $productModel->getAllProducts($page, $perPage);
$totalProducts = $productModel->getTotalProducts();
$totalPages = ceil($totalProducts / $perPage);

include_once __DIR__ . '/views/layout/header.php';
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách sản phẩm</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="employee.php">Trang chủ</a></li>
        <li class="breadcrumb-item active">Danh sách sản phẩm</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Danh sách sản phẩm
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Barcode</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá bán</th>
                        <th>Số lượng tồn</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['id']); ?></td>
                                <td><?php echo htmlspecialchars($product['barcode']); ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                <td><?php echo number_format($product['selling_price']); ?>₫</td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                
                                <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Không có sản phẩm nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                            <a class="page-link" href="sanpham.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/views/layout/footer.php'; ?>