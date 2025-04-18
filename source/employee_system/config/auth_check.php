<?php
session_start();

$timeout_duration = 30;


if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
  
    session_unset();
    session_destroy();
    header('Location: ../views/auth/signin.php');
    exit();
}


$_SESSION['last_activity'] = time();

require_once __DIR__ . '/constants.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../views/auth/signin.php');
    exit();
}

require_once __DIR__ . '/../models/UserModel.php';

$userObj = new User();
$username = $_SESSION['user'];
$userData = $userObj->getUserByIdByUsername($username);

if (!$userData) {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}

$employee_name = $userData['username'];
$profile_image = BASE_URL . "../" . (trim($userData['avatar']) ?: "default.jpg");
?>
