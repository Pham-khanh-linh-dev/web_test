<?php
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../lib/data_func.php';
    session_start();
    // Check authentication and admin access
    if(!isset($_SESSION['user']) ){
        header('Location: ../views/auth/signin.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password  = $_POST['password'];
        $db = new Database();

        // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
        $check = $db->checkEmailExists($email);
        if ($check) {
            echo "<script type='text/javascript'>alert('Email đã tồn tại! Vui lòng nhập email khác!');
            window.location.href = 'admins-create.php';  // Chuyển hướng về trang quản trị viên sau khi người dùng nhấn OK
            </script>";
            exit; // Dừng thực thi script nếu email đã tồn tại
        }
        else {
            $db->insertAdmin($email, $fullname, $password);
            echo "<script type='text/javascript'>alert('Thêm quản trị viên thành công!');
            window.location.href = 'admins-create.php';  // Chuyển hướng về trang quản trị viên sau khi người dùng nhấn OK
            </script>";
        }
        
    }

    
?>
<?php include('includes/header.php');?>
<div class="container-fluid px-4">
    <div class="card mt-3">
        <div class="card-header">
            <h4 class = "mb-0">Thêm Quản Trị Viên
                <a href="employee-list.php" class="btn btn-primary float-end">Trở về</a>
            </h4>
        </div> 
        <div>
            <div class = "card-body">
                <form action="" method="POST">
                    <div class = "row">
                        <div class ="col-md-12 mb-3">
                            <label for="">Họ Và Tên</label>
                            <input type="text" name="fullname" class="form-control" placeholder="Nhập họ và tên" required>
                        </div>
                        <div class ="col-md-6 mb-3">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
                        </div>
                        <div class ="col-md-6 mb-3">
                            <label for="">Mật Khẩu</label>
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                        </div>
                        <div class ="col-md-12 mb-3 text-center mt-4">
                            <button type="submit" name="Lưu" class = "btn btn-primary" >Lưu</button>
                            <button type="reset" class = "btn btn-danger mr-5">Nhập Lại</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div> 
    </div>
</div>



<?php include('includes/footer.php');?>