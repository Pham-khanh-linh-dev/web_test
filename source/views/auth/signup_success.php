<?php
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chúc mừng đăng ký thành công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        h2 {
            color: #28a745;
        }
        p {
            color: #555;
        }
        
        
    </style>
</head>
<body>
    <form action="" method="post">
        <div class="container">
            <h2>🎉 Đăng ký thành công! 🎉</h2>
            <button><a href="../../admin_system/index.php">Trang Chủ</a></button>
            <p>Giờ đây bạn đã chính thức là nhân viên cửa hàng. Vui lòng vào gmail nhấp vào đường link để đăng nhập hệ thống! Đếm ngược 60s</p>
            <span id ="counter" class="text-danger">60</span>
        </div>
    </form>

    <script>
      window.addEventListener('load', startCountdown);
      function startCountdown(){
        console.log('start countdown');
        let count = 60;
        let counter = document.getElementById('counter');
        setInterval(() => {
          count--;
          counter.innerHTML = count;
          if(count == 0){
            window.location.href = '../../admin_system/index.php';
          }
        }, 1000);
      }
        
    </script>
</body>
</html>
