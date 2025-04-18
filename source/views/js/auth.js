// Lấy các tham số từ URL
const urlParams = new URLSearchParams(window.location.search);
const token = urlParams.get('token');  // Mã token
const email = urlParams.get('email');  // Địa chỉ email
const expires = urlParams.get('expires');  // Thời gian hết hạn

// Kiểm tra nếu tất cả các tham số có trong URL
if (token && email && expires) {
  const currentTime = Math.floor(Date.now() / 1000);  // Lấy thời gian hiện tại tính bằng giây (Unix timestamp)
  
  // Kiểm tra nếu liên kết đã hết hạn
  if (currentTime > expires) {
    alert("Liên kết kích hoạt đã hết hạn.");
    // Chuyển hướng đến trang đăng ký nếu liên kết đã hết hạn
    window.location.href = `https://localhost/laptrinhweb_da19_hk2_2425/source/signup.php`;
  } else {
    alert("Liên kết kích hoạt hợp lệ. Vui lòng kích hoạt tài khoản của bạn.");
    // Chuyển hướng đến trang đăng nhập với tham số token và email
    window.location.href = `https://localhost/laptrinhweb_da19_hk2_2425/source/signin.php?token=${token}&email=${email}`;
  }
} else {
  alert("Liên kết không hợp lệ hoặc thiếu tham số.");
}