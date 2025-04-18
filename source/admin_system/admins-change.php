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
        $pass = $_POST['pass'];
        $newpass = $_POST['newpass'];
        $verifypass  = $_POST['verifypass'];
        $user = $_SESSION['user'];

        $db = new Database();

        // check password
        $check = $db-> checkPassword($user, $pass);
        if ($check) {
            if($newpass === $pass) {
                echo "<script type='text/javascript'>alert('Mật khẩu mới không được trùng mật khẩu cũ!');
                window.location.href = 'admins-change.php';  // Chuyển hướng về trang quản trị viên sau khi người dùng nhấn OK
                </script>";
                exit; 
            }
            else if($newpass != $verifypass) {
                echo "<script type='text/javascript'>alert('Mật khẩu mới không khớp!');
                window.location.href = 'admins-change.php';  // Chuyển hướng về trang quản trị viên sau khi người dùng nhấn OK
                </script>";
                exit; 
            }
            else {
                $db->updatePass($user, $newpass);
                echo "<script type='text/javascript'>alert('Đổi mật khẩu thành công!');
                window.location.href = 'admins-change.php';  // Chuyển hướng về trang quản trị viên sau khi người dùng nhấn OK
                </script>";
            }

        }
        else {
            echo "<script type='text/javascript'>alert('Mật khẩu hiện tại không đúng!');
            window.location.href = 'admins-change.php';  // Chuyển hướng về trang quản trị viên sau khi người dùng nhấn OK
            </script>";
            exit;
        }
        
    }

    
?>
<?php include('includes/header.php');?>
<div class="container-fluid px-4">
    <div class="card mt-3">
        <div class="card-header">
            <h4 class = "mb-0">Đổi Mật Khẩu
                <a href="index.php" class="btn btn-primary float-end">Trở về</a>
            </h4>
        </div> 
        <div>
            <div class = "card-body col-md-6 col-lg-5 center mx-auto mt-5 ">
                <form action="" method="POST" >
                    <div class = "row" >
                        <div class ="col-md-12 mb-3">
                            <label for="">Nhập mật khẩu hiện tại</label>
                            <input type="password" name="pass" class="form-control" placeholder="Nhập mật khẩu hiện tại" required>
                        </div>
                        <div class ="col-md-12 mb-3">
                            <label for="">Nhập mật khẩu mới</label>
                            <input type="password" name="newpass" class="form-control" placeholder="Nhập mật khẩu mới" required>
                        </div>
                        <div class ="col-md-12 mb-3">
                            <label for="">Xác nhận mật khẩu mới</label>
                            <input type="password" name="verifypass" class="form-control" placeholder="Xác nhận mật khẩu mới" required>
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