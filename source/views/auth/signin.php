<?php
    ob_start(); 
    session_start();
    include '../../config/db.php';
    include '../../lib/data_func.php';
    $db = new Database();
  if (!$db) {
    die("Lỗi kết nối Database!");
}
    ob_start(); // Thêm dòng này để tránh lỗi header
    session_start();
    // if(isset($_SESSION['user']) ){
    //     header('Location: /laptrinhweb_da19_hk2_2425/source/admin.php');
    //     exit();
    // }
    // if(isset($_SESSION['pass']) ){
    //     header('Location: /laptrinhweb_da19_hk2_2425/source/employee.php');
    //     exit();
    // }  không cần dùng đến vì nếu 1 trong 2 session tồn tại thì sẽ chuyển hướng ngay lập tức ko thể login 2 role cùng 1 lúc  
    $user = '';
    $pass = '';
    if(isset($_POST['user']) && isset($_POST['pass'])){
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        $db = new Database();
        if ($db->checkAdmin($user, $pass)){
            $_SESSION['user'] = $user;
            $encodedUser = base64_encode($user);
            var_dump("Admin Login Success");
            header('Location: /laptrinhweb_da19_hk2_2425/source/admin_system/index.php?username=' . $encodedUser);
            exit();

        } else if ($db->checkUser($user, $pass)){
            $_SESSION['user'] = $user;
            $encodedUser = base64_encode($user);
            header('Location: /laptrinhweb_da19_hk2_2425/source/employee_system/employee.php?username=' . $encodedUser);
            exit();
        } else if ($db->checkActive($user, $pass)){
            echo "<script type='text/javascript'>alert('Bạn chưa kích hoạt tài khoản. Vui lòng nhấp vào đường link được gửi đến gmail của bạn!');</script>";
        } else if ($db -> changePass($user, $pass)){
          echo "<script type='text/javascript'>
              alert('Bạn đã kích hoạt tài khoản. Vui lòng nhấp OK để vào trang đổi mật khẩu sau đó đăng nhập lại nhé!');
              window.location.href = '/laptrinhweb_da19_hk2_2425/source/views/auth/firstLogin.php?email=" . $user . '@gmail.com' . "';
          </script>";
          exit();
        }
          else if ($db -> checkLocked($user, $pass)){
            echo "<script type='text/javascript'>alert('Bạn đã bị khóa tài khoản và không thể đăng nhập');</script>";

        }
        else
        {
          echo "<script type='text/javascript'>alert('Sai tài khoản hoặc mật khẩu!');</script>";
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng Nhập</title>
  <link rel="stylesheet" href="../css/signin.css">
</head>
<body>
      <div class="login">
        <img src="../../img/login.png" alt="login image" class="login_img">

        <form action="" method="POST" class="login_form" >
          <h1 class="login_title">Đăng Nhập</h1>

          <div class="login_content">
            <div class="login_box">
              <i class="bx bx-lock-alt"></i>
              
              <div class="login_box-input">
                <input type="text" class="login_input" placeholder="Tài khoản" name = "user" required>
                <label for="" class="login_label"></label>
              </div>
            </div>

            <div class="login_box">
              <i class="ri-lock-2-line login_icon"></i>

              <div class="login_box-input">
                <input type="password" class="login_input" placeholder="Mật Khẩu " name = "pass" required>
                <label for="" class="login_label"></label>
              </div>
            </div>
          </div>

          <div class="login_check">
            <div class="login_check-group">
              <input type="checkbox" class="login_check-input">
              <label for="" class="login_check-label">Lưu Tài Khoản</label>
            </div>

              <a href="#" class="login_forgot">Quên Mật Khẩu?</a>
          </div>

          <button type="submit" class="login_button">Đăng Nhập</button>

        </form>
      </div>

</body>
</html>
