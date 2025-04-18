<?php
include_once 'config/auth_check.php';
include_once 'config/constants.php';
$pageTitle = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/employee.css?v=<?= time(); ?>">

</head>
<body>
  <?php include_once __DIR__ . '/views/layout/header.php'; ?>
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="sidebar-card p-3 mb-4 animate-fadein">
                    <h5 class="text-center fw-bold mb-4" style="color: var(--primary-color);">CHỨC NĂNG</h5>
                    <div class="row row-cols-1 g-3">
                        <div class="col">
                            <a href="report.php" class="text-decoration-none d-block text-center feature-link p-3 rounded">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="fw-bold">Báo cáo</div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="Banhang.php" class="text-decoration-none d-block text-center feature-link p-3 rounded">
                                <div class="feature-icon">
                                    <i class="fas fa-cash-register"></i>
                                </div>
                                <div class="fw-bold">Bán hàng</div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="Khachhang.php" class="text-decoration-none d-block text-center feature-link p-3 rounded">
                                <div class="feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="fw-bold">Khách hàng</div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="sanpham.php" class="text-decoration-none d-block text-center feature-link p-3 rounded">
                                <div class="feature-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <div class="fw-bold">Sản phẩm</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner -->
            <div class="col-md-9">
                <div class="main-carousel carousel slide shadow" id="mainCarousel" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner rounded-3 overflow-hidden">
                        <div class="carousel-item active">
                            <img src="../img/anh1.jpg" class="d-block w-100" style="height: 350px; object-fit: cover;">
                        </div>
                        <div class="carousel-item">
                            <img src="../img/anh2.png" class="d-block w-100" style="height: 350px; object-fit: cover;">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 mb-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4 animate-fadein delay-1">
                <div class="value-card p-4" style="background-image: url('../img/kyluat.png');">
                    <h6>Kỷ luật</h6>
                    <p>Đúng giờ, Nghiêm chỉnh</p>
                </div>
            </div>
            <div class="col-md-4 mb-4 animate-fadein delay-2">
                <div class="value-card p-4" style="background-image: url('../img/friendly.png');">
                    <h6>Thái độ</h6>
                    <p>Tận tâm phục vụ</p>
                </div>
            </div>
            <div class="col-md-4 mb-4 animate-fadein delay-3">
                <div class="value-card p-4" style="background-image: url('../img/trungthanh.png');">
                    <h6>Trung thực</h6>
                    <p>Không gian dối trong quá trình làm việc</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include_once __DIR__ . '/views/layout/footer.php'; ?>
</body>
</html>