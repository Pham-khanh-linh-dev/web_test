<?php
  session_start();
  ob_start(); // Bắt đầu session
  include '../../config/mail.php';
  include '../../config/db.php';
  include '../../lib/data_func.php';
  


  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];

    $db = new Database();
    $check = $db->checkEmailExists($email);
    if ($check) {
      echo "<script type='text/javascript'>alert('Email đã tồn tại trên hệ thống!');
              window.location.href = 'signup.php';  // Chuyển hướng về trang đăng ký sau khi người dùng nhấn OK

            </script>";
      exit();
    } else{
      $db->insert($email, $fullname);
      $activation_token = bin2hex(random_bytes(16));
      $expires = time() + 60;
      $link = "https://localhost/laptrinhweb_da19_hk2_2425/source/api/url.php?token=$activation_token&email=$email&expires=$expires";


      $subject = 'Test Email from POS System';  
      $message = '
        <html>
        <head>
          <title>Kích hoạt tài khoản</title>
        </head>
        <body>
          <p>Chào bạn,</p>
          <p>Tài khoản của bạn đã kích hoạt thành công. Vui lòng nhấp vào link dưới đây để kích hoạt tài khoản hệ thống:</p>
          <p><a href="' . $link . '" target="_blank">Nhấp vào đây để kích hoạt</a></p>
          <p>Liên kết này sẽ hết hạn sau 1 phút.</p>
        </body>
        </html>
      '; 
      
      $result = sendMail($email, $subject, $message);
      if ($result == "Email đã được gửi thành công!") {
        header("Location: signup_success.php");
        exit(); 
      } 
    }  

    

  } else {
      echo "";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="utf-8">
    <title>Đăng Kí</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
      
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">Đăng Kí Tài Khoản Nhân Viên</h3>
            <form action = "" method = "POST"   class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">

                <div class="form-group">
                    <label for="email">Nhập Email</label>
                    <input name ="email" id="username" type="email" class="form-control" placeholder="Nhập email" required>
                </div>

                <div class="form-group">
                    <label for="">Họ và tên</label>
                    <input name ="fullname" id="fullname" type="text" class="form-control" placeholder="Nhập họ và tên" required>
                </div>
                
                <div class="form-group">
                    <button class="btn btn-success px-5">Đăng kí</button>
                    <a href="../../admin_system/index.php" class="btn btn-primary  float-end">Trang Chủ</a>

                </div>

            </form>
        </div>
    </div>
</div>
<footer class="py-4 bg-light " style = "margin-top: 12rem;">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; 2025 - POINT OF SALES - HỆ THỐNG QUẢN LÝ BÁN HÀNG  </div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>

