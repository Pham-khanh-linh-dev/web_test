<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../lib/data_func.php';

// Check authentication and admin access
if(!isset($_SESSION['user']) ){
    header('Location: ../views/auth/signin.php');
    exit();
}

$db = new Database();
$employees = $db->getAllEmployees(); // We'll create this method

// Handle actions
if(isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    
    switch($action) {
        case 'resend_email':
            $result = $db->resendActivationEmail($id);
            $message = "Đã gửi lại email kích hoạt tài khoản!";
            break;
        case 'lock':
            $db->updateEmployeeStatus($id, 'locked');
            $message = "Đã khóa tài khoản nhân viên!";
            break;
        case 'unlock':
            $db->updateEmployeeStatus($id, 'active');
            $message = "Đã mở khóa tài khoản nhân viên!";
            break;
            case 'delete':
                if ($db->deleteEmployee($id)) {
                    $message = "Đã xóa tài khoản nhân viên thành công!";
                    $message_type = "success";
                }
                else {
                    $message = "Không thể xóa tài khoản nhân viên!";
                    $message_type = "error";
                }
                break;
    }
    
    // Refresh employee list after action
    $employees = $db->getAllEmployees();
}

include('includes/header.php');
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Quản Lý Nhân Viên</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Trang Chủ</a></li>
        <li class="breadcrumb-item active">Quản Lý Nhân Viên</li>
    </ol>
    
    <?php if(isset($message)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-users me-1"></i> Danh Sách Nhân Viên</div>
            <a href="admins-create.php" class="btn btn-primary btn-sm">Thêm Quản Lí</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="employeeTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="70">Ảnh</th>
                            <th>Họ Tên</th>
                            <th>Email</th>
                            <th>Tên Đăng Nhập</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th>Tùy Chọn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($employees as $employee): ?>
                        <tr>
                            <td>
                                <img src="<?php echo !empty($employee['avatar']) ? '../uploads/avatars/'.$employee['avatar'] : 'assets/img/default-avatar.png'; ?>" 
                                     class="rounded-circle" width="50" height="50" alt="Avatar">
                            </td>
                            <td><?php echo htmlspecialchars($employee['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($employee['email']); ?></td>
                            <td><?php echo htmlspecialchars($employee['username']); ?></td>
                            <td>
                                <?php if($employee['status'] === 'inactive'): ?>
                                    <span class="badge bg-warning text-dark">Chưa kích hoạt</span>
                                <?php elseif($employee['status'] === 'locked'): ?>
                                    <span class="badge bg-danger">Đã khóa</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($employee['created_at'])); ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="employee-detail.php?id=<?php echo $employee['id']; ?>" class="btn btn-info btn-sm" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <?php if($employee['status'] === 'inactive'): ?>
                                    <a href="?action=resend_email&id=<?php echo $employee['id']; ?>" class="btn btn-primary btn-sm" title="Gửi lại email">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if($employee['status'] !== 'locked'): ?>
                                    <a href="?action=lock&id=<?php echo $employee['id']; ?>" class="btn btn-danger btn-sm" title="Khóa tài khoản">
                                        <i class="fas fa-lock"></i>
                                    </a>
                                    <?php else: ?>
                                    <a href="?action=unlock&id=<?php echo $employee['id']; ?>" class="btn btn-success btn-sm" title="Mở khóa tài khoản">
                                        <i class="fas fa-unlock"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <a href="employee-sales.php?id=<?php echo $employee['id']; ?>" class="btn btn-warning btn-sm" title="Xem doanh số">
                                        <i class="fas fa-chart-line"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="confirmDelete(<?php echo $employee['id']; ?>, '<?php echo htmlspecialchars($employee['fullname']); ?>')" 
                                        class="btn btn-danger btn-sm" title="Xóa tài khoản">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#employeeTable').DataTable({
            responsive: true,
            "language": {
                "search": "Tìm kiếm:",
                "lengthMenu": "Hiển thị _MENU_ dòng",
                "zeroRecords": "Không tìm thấy kết quả",
                "info": "Hiển thị trang _PAGE_ / _PAGES_",
                "infoEmpty": "Không có dữ liệu",
                "infoFiltered": "(lọc từ _MAX_ dòng)",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Sau",
                    "previous": "Trước"
                }
            }
        });
    });

    function confirmDelete(id, name) {
        if (confirm('Bạn có chắc chắn muốn xóa tài khoản của nhân viên "' + name + '" không?')) {
            window.location.href = 'employee-list.php?action=delete&id=' + id;
        }
    }
</script>