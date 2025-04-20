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
$pageTitle = 'Quản lý danh mục';

// Xử lý thêm/sửa/xóa danh mục
require_once __DIR__ . '/models/CategoryModel.php';
$categoryModel = new CategoryModel();

$action = $_GET['action'] ?? '';
$error = null;

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add_category') {
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description']
        ];
        $categoryModel->addCategory($data);
        header('Location: danhmuc.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'edit_category') {
        $id = $_POST['id'];
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description']
        ];
        $categoryModel->updateCategory($id, $data);
        header('Location: danhmuc.php');
        exit();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}

if ($action === 'delete_category' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $categoryModel->deleteCategory($id);
    header('Location: danhmuc.php');
    exit();
}

// Lấy danh sách danh mục
$categories = $categoryModel->getAllCategories();

// Bao gồm header
include_once __DIR__ . '/includes/header.php';
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Quản lý danh mục</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
        <li class="breadcrumb-item active">Quản lý danh mục</li>
    </ol>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Danh sách danh mục
            <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Thêm danh mục</button>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã danh mục</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($categories) > 0): ?>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($category['id']); ?></td>
                                <td><?php echo htmlspecialchars($category['name']); ?></td>
                                <td><?php echo htmlspecialchars($category['description'] ?? '---'); ?></td>
                                <td><?php echo htmlspecialchars($category['created_at']); ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal" onclick="loadCategoryData(<?php echo htmlspecialchars(json_encode($category)); ?>)">Sửa</a>
                                    <a href="danhmuc.php?action=delete_category&id=<?php echo $category['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Không có danh mục nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Thêm danh mục -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Thêm danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="danhmuc.php?action=add_category">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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

<!-- Modal Sửa danh mục -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Sửa danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="danhmuc.php?action=edit_category">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
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
function loadCategoryData(category) {
    document.getElementById('edit_id').value = category.id;
    document.getElementById('edit_name').value = category.name;
    document.getElementById('edit_description').value = category.description || '';
}
</script>

<?php include_once __DIR__ . '/includes/footer.php'; ?>