<?php
session_start();

// Bao gồm constants.php
require_once __DIR__ . '/constants.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    header('Location: ' . SOURCE_URL . 'views/auth/signin.php');
    exit();
}

// Kết nối cơ sở dữ liệu để kiểm tra vai trò
require_once __DIR__ . '/../../core/DbCore.php'; // Nếu bạn đã có DbCore

$db = DbCore::getInstance()->getConnection(); // Trả về PDO

$username = $_SESSION['user'];
$query = "SELECT * FROM users WHERE username = ? LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra xem người dùng có tồn tại và có vai trò admin không
if (!$user || (isset($user['role']) && $user['role'] !== 'admin')) {
    header('Location: ' . SOURCE_URL . 'views/auth/signin.php');
    exit();
}

// Nếu không có cột role trong bảng users, giả định tài khoản có username "admin" là admin
if (!isset($user['role']) && $username !== 'admin') {
    header('Location: ' . SOURCE_URL . 'views/auth/signin.php');
    exit();
}

// Lấy thông tin người dùng
$userData = [
    'id' => $user['id'] ?? null,
    'username' => $user['username'] ?? 'Admin'
];
?>