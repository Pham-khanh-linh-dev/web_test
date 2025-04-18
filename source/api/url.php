<?php
  require_once '../config/db.php';
  include '../lib/data_func.php';
  
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Xác Nhận</title>
</head>
<body>  
  <div id="message"></div>

  <script>
    // Lấy các tham số từ URL
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');  // Mã token không cần sử dụng
    const email = urlParams.get('email');  // Địa chỉ email
    const expires = urlParams.get('expires');  // Thời gian hết hạn

    // Kiểm tra nếu tất cả các tham số có trong URL
    if (token && email && expires) {
      const currentTime = Math.floor(Date.now() / 1000);  // Lấy thời gian hiện tại tính bằng giây (Unix timestamp)
      
      // Kiểm tra nếu liên kết đã hết hạn
      if (currentTime > expires) {
        document.getElementById('message').innerHTML = "<p>Liên kết kích hoạt đã hết hạn.</p>";
        alert("Liên kết kích hoạt đã hết hạn.");
        const redirectUrl = `https://localhost/laptrinhweb_da19_hk2_2425/source/views/auth/signup.php`;
        window.location.href = redirectUrl;
      } else {
        // Gửi yêu cầu AJAX để cập nhật trạng thái người dùng
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `https://localhost/laptrinhweb_da19_hk2_2425/source/lib/update.php?email=${email}`, true);
        xhr.onload = function () {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
              // Chuyển hướng người dùng tới trang đổi mật khẩu
              const redirectUrl = `https://localhost/laptrinhweb_da19_hk2_2425/source/views/auth/firstLogin.php?email=${email}`;
              window.location.href = redirectUrl;  
            } else {
              alert(response.message);  
            }
          } else {
            alert("Lỗi khi gửi yêu cầu.");
          }
        };
        xhr.send();
      }
    } else {
      alert("Liên kết không hợp lệ hoặc thiếu tham số.");
    }
  </script>

</body>
</html>



