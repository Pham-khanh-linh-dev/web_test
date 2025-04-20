<?php
// Bao gồm file cấu hình
include_once __DIR__ . '/config/constants.php';
include_once __DIR__ . '/config/auth_check.php';

// Kiểm tra quyền admin (đã được xử lý trong auth_check.php)
$employee_id = $userData['id'] ?? null;
if (!$employee_id) {
    echo "Không tìm thấy ID người dùng.";
    exit();
}

$employee_name = $_SESSION['user'] ?? 'Admin';
$pageTitle = 'Quản lý sản phẩm';

// Xử lý thêm/sửa/xóa sản phẩm
require_once __DIR__ . '/models/ProductModel.php';
require_once __DIR__ . '/models/CategoryModel.php';
$productModel = new ProductModel();
$categoryModel = new CategoryModel();

$action = $_GET['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add_product') {
    $data = [
        'barcode' => $_POST['barcode'],
        'name' => $_POST['name'],
        'category_id' => $_POST['category_id'],
        'purchase_price' => $_POST['purchase_price'],
        'selling_price' => $_POST['selling_price'],
        'stock' => $_POST['stock'],
        'created_by' => $employee_id
    ];
    $productModel->addProduct($data);
    header('Location: sanpham.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'edit_product') {
    $id = $_POST['id'];
    $data = [
        'barcode' => $_POST['barcode'],
        'name' => $_POST['name'],
        'category_id' => $_POST['category_id'],
        'purchase_price' => $_POST['purchase_price'],
        'selling_price' => $_POST['selling_price'],
        'stock' => $_POST['stock'],
        'created_by' => $employee_id
    ];
    $productModel->updateProduct($id, $data);
    header('Location: sanpham.php');
    exit();
}

if ($action === 'delete_product' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $productModel->deleteProduct($id);
    header('Location: sanpham.php');
    exit();
}

// Lấy danh sách sản phẩm
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$products = $productModel->getAllProducts($page, $perPage);
$totalProducts = $productModel->getTotalProducts();
$totalPages = ceil($totalProducts / $perPage);

// Lấy danh sách danh mục
$categories = $categoryModel->getAllCategories();

// Bao gồm header
include_once __DIR__ . '/includes/header.php';
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Quản lý sản phẩm</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
        <li class="breadcrumb-item active">Quản lý sản phẩm</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Danh sách sản phẩm
            <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addProductModal">Thêm sản phẩm</button>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Barcode</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá nhập</th>
                        <th>Giá bán</th>
                        <th>Số lượng tồn</th>
                        <th>Người tạo</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
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
                                <td><?php echo number_format($product['purchase_price']); ?>₫</td>
                                <td><?php echo number_format($product['selling_price']); ?>₫</td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                <td><?php echo htmlspecialchars($product['created_by']); ?></td>
                                <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editProductModal" onclick="loadProductData(<?php echo htmlspecialchars(json_encode($product)); ?>)">Sửa</a>
                                    <a href="sanpham.php?action=delete_product&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">Không có sản phẩm nào</td>
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

<!-- Modal Thêm sản phẩm -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="sanpham.php?action=add_product">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="barcode" class="form-label">Barcode</label>
                        <input type="text" class="form-control" id="barcode" name="barcode" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh mục</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="purchase_price" class="form-label">Giá nhập (VNĐ)</label>
                        <input type="number" class="form-control" id="purchase_price" name="purchase_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Giá bán (VNĐ)</label>
                        <input type="number" class="form-control" id="selling_price" name="selling_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Số lượng tồn</label>
                        <input type="number" class="form-control" id="stock" name="stock" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sửa sản phẩm -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Sửa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="sanpham.php?action=edit_product">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_barcode" class="form-label">Barcode</label>
                        <input type="text" class="form-control" id="edit_barcode" name="barcode" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category_id" class="form-label">Danh mục</label>
                        <select class="form-control" id="edit_category_id" name="category_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_purchase_price" class="form-label">Giá nhập (VNĐ)</label>
                        <input type="number" class="form-control" id="edit_purchase_price" name="purchase_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_selling_price" class="form-label">Giá bán (VNĐ)</label>
                        <input type="number" class="form-control" id="edit_selling_price" name="selling_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_stock" class="form-label">Số lượng tồn</label>
                        <input type="number" class="form-control" id="edit_stock" name="stock" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function loadProductData(product) {
    document.getElementById('edit_id').value = product.id;
    document.getElementById('edit_barcode').value = product.barcode;
    document.getElementById('edit_name').value = product.name;
    document.getElementById('edit_category_id').value = product.category_id;
    document.getElementById('edit_purchase_price').value = product.purchase_price;
    document.getElementById('edit_selling_price').value = product.selling_price;
    document.getElementById('edit_stock').value = product.stock;
}
</script>

<?php include_once __DIR__ . '/includes/footer.php'; ?>