<?php
    // Bắt đầu session
session_start();

// Xóa session cụ thể (xóa biến 'user')
unset($_SESSION['user']);
echo '<pre>'; // Giúp định dạng đẹp hơn khi hiển thị mảng
print_r($_SESSION);
echo '</pre>';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
      integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
      crossorigin="anonymous"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6 mt-5 mx-auto p-3 border rounded">
            <h4>Đăng xuất thành công</h4>
            <p>Tài khoản của bạn đã được đăng xuất khỏi hệ thống.</p>
            <p>Nhấn <a href="login.php">vào đây</a> để trở về trang đăng nhập, hoặc trang web sẽ tự động chuyển hướng sau <span id ="counter" class="text-danger">10</span> giây nữa.</p>
            <a href = "signin.php" class="btn btn-success px-5">Đăng nhập</a>
        </div>
      </div>
    </div>
    <script>
      window.addEventListener('load', startCountdown);
      function startCountdown(){
        console.log('start countdown');
        let count = 10;
        let counter = document.getElementById('counter');
        setInterval(() => {
          count--;
          counter.innerHTML = count;
          if(count == 0){
            window.location.href = '../../dangnhaphethongdienthoai.php';
          }
        }, 1000);
      }
        
    </script>
  </body>
</html>
