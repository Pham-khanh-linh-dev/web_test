<?php
// Get database instance
require_once __DIR__ . '/../../lib/data_func.php';
$db = new Database();

// Get formatted username and role
$userDisplay = $db->getUserNameAndRole($_SESSION['user']);
?>

<nav class="sb-topnav navbar navbar-expand" style="background-color: #e3f2fd;">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.php">Point Of Sales</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li>
        <div class="sb-sidenav-footer mt-2">
            <i class="fa-regular fa-circle-user"></i>
            <?php echo $userDisplay; ?>
        </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="admins-change.php">Đổi Mật Khẩu</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="../views/auth/logoutAdmin.php">Logout</a></li>
            </ul>
        </li>
        
    </ul>
</nav>