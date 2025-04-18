<?php
// views/layout/header.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Trang chủ'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/employee.css?v=<?= time(); ?>">
    <style>
        .custom-header {
            background-color: #90caf9;
            font-family: 'Segoe UI', sans-serif;
            padding: 15px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1000;
        }

        .custom-header .nav-link {
            color: #ffffff !important;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            padding: 8px 15px;
        }

        .custom-header .nav-link:hover {
            color: #d1ecf1 !important;
            transform: translateY(-2px);
        }

        .custom-header .dropdown-menu {
            background-color: #ffffff;
            border: none;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-top: 10px;
            padding: 0;
            overflow: hidden;
        }

        .custom-header .dropdown-item {
            color: #333;
            padding: 10px 20px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .custom-header .dropdown-item:hover {
            background-color: #00A0D9;
            color: white;
            padding-left: 25px;
        }

        .custom-header .dropdown-divider {
            margin: 0;
            border-color: #eee;
        }

        .profile-dropdown {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }

        .profile-name {
            margin-left: 10px;
            color: white;
            font-weight: 600;
        }

        .profile-dropdown:hover .profile-img {
            border-color: white;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<header class="custom-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
        <img src="<?= BASE_URL ?>../img/logolaco.png" alt="Logo" style="height: 50px;">

        <ul class="nav align-items-center">
    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>employee.php">HOME</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">NEWS</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle profile-dropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile" class="profile-img">
            <span class="profile-name"><?php echo htmlspecialchars($employee_name); ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user-circle me-2"></i>Thông tin cá nhân</a></li>
            <li><a class="dropdown-item" href="views/auth/logoutEmployee.php"><i class="fas fa-key me-2"></i>Đổi mật khẩu</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="../views/auth/logoutEmployee.php"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
        </ul>
    </li>
</ul>

        </div>
    </div>
</header>