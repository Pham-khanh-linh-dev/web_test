<?php
    require_once '../../config/db.php';
    require_once '../../lib/data_func.php';

    session_start();
    

    

    if(isset($_POST['password'])  ){
        // Kiểm tra xem người dùng đã nhập mật khẩu mới hay chưa
        if (empty($_POST['password'])) {
            echo "<script type='text/javascript'>alert('Vui lòng nhập mật khẩu mới!');</script>";
            exit();
        }
        $new_password = $_POST['password'];
        $_SESSION['email'] = $_GET['email'];
        $email = $_GET['email'];

        $db = new Database();
        $db->firstLogin($email, $new_password);
        echo "<script type='text/javascript'>alert('Thay đổi thành công!');
            </script>";
            header('Location: /laptrinhweb_da19_hk2_2425/source/views/auth/signin.php?email=' . urlencode($email));
            exit();    }
    else {
        echo "";
        

    }

    

?>


<!DOCTYPE html>
<html lang="vi">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Nhập Mật Khẩu</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="password">Nhập Mật Khẩu Mới</label>
                        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required>
                    </div>
                    <button type="submit" class="btn btn-success mt-3 mr-5">Cập nhật</button>                    
                    <button class="btn btn-danger mt-3 "><a href="signin.php">Đăng xuất</a></button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
