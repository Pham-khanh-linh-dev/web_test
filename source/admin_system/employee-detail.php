<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../lib/data_func.php';

// Check authentication and admin access
if(!isset($_SESSION['user']) ){
    header('Location: ../views/auth/signin.php');
    exit();
}

// Get employee ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id <= 0) {
    header('Location: employees.php');
    exit();
}

$db = new Database();
$employee = $db->getEmployeeById($id); // We'll create this method

if(!$employee) {
    header('Location: signin.php');
    exit();
}

include('includes/header.php');
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Chi Tiết Nhân Viên</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Trang Chủ</a></li>
        <li class="breadcrumb-item"><a href="employees.php">Quản Lý Nhân Viên</a></li>
        <li class="breadcrumb-item active"><?php echo htmlspecialchars($employee['fullname']); ?></li>
    </ol>
    
    <div class="row">
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i> Thông Tin Cá Nhân
                </div>
                <div class="card-body text-center">
                    <img src="<?php echo !empty($employee['avatar']) ? '../uploads/avatars/'.$employee['avatar'] : 'assets/img/default-avatar.png'; ?>" 
                         class="img-account-profile rounded-circle mb-2" width="150" height="150" alt="Avatar">
                    <h4 class="mb-1"><?php echo htmlspecialchars($employee['fullname']); ?></h4>
                    <div class="small text-muted mb-3"><?php echo htmlspecialchars($employee['role']); ?></div>
                    
                    <?php if($employee['status'] === 'inactive'): ?>
                        <span class="badge bg-warning text-dark">Chưa kích hoạt</span>
                    <?php elseif($employee['status'] === 'locked'): ?>
                        <span class="badge bg-danger">Đã khóa</span>
                    <?php else: ?>
                        <span class="badge bg-success">Hoạt động</span>
                    <?php endif; ?>
                    
                    
                </div>
            </div>
        </div>
        
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i> Thông Tin Chi Tiết
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <p class="mb-0 fw-bold">Họ và tên</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($employee['fullname']); ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <p class="mb-0 fw-bold">Email</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($employee['email']); ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <p class="mb-0 fw-bold">Tên đăng nhập</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($employee['username']); ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <p class="mb-0 fw-bold">Số điện thoại</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo !empty($employee['phone']) ? htmlspecialchars($employee['phone']) : 'Chưa cập nhật'; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <p class="mb-0 fw-bold">Ngày tạo tài khoản</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?php echo date('d/m/Y H:i:s', strtotime($employee['created_at'])); ?></p>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            
            
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>