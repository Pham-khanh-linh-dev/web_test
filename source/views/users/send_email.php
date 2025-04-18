<?php
session_start();
require '../../config/db.php';
require '../../config/mail.php';
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT id, email, temporary_password FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $token = bin2hex(random_bytes(16));
    $conn->prepare("DELETE FROM password_reset WHERE user_id = ?")->execute([$user['id']]);
    $conn->prepare("INSERT INTO password_reset (user_id, token) VALUES (?, ?)")->execute([$user['id'], $token]);

    // Gửi email
    $reset_link = "http://localhost/web_da19/views/auth/reset_password.php?token=" . $token;
    $subject = "Đăng nhập lần đầu vào hệ thống";
    $message = "Nhấp vào link sau để đăng nhập: <a href='$reset_link'>$reset_link</a>. Mật khẩu tạm: " . $user['temporary_password'] . ". Link này chỉ có hiệu lực trong 1 phút.";
    
    sendMail($user['email'], $subject, $message);

    echo "Email đăng nhập đã được gửi!";
} else {
    echo "Nhân viên không tồn tại!";
}
?>
