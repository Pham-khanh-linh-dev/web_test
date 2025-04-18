<?php

//include_once __DIR__ . '/employee_system/views/layout/header.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Điện thoại - Phụ Kiện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2b1055, #7597de, #6B0F9C);
            color: #fff;
            padding: 80px 20px;
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .card {
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            width: 22rem;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.4);
        }

        .card-title {
            font-size: 1.6rem;
            font-weight: bold;
        }

        .divider {
            height: 180px;
            width: 4px;
            background-color: rgba(255, 255, 255, 0.5);
            margin: 0 20px;
        }

        .video-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        video {
            width: 100%;
            max-width: 500px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body>

    <div class="container mt-5">

        <div class="row align-items-center justify-content-center">
            <div class="col-md-5 video-container">
                <video controls src="img/videologo.mp4" type="video/mp4" autoplay muted loop></video>
            </div>
            <div class="col-md-6 text-center">
                <h3 class="mt-3">HỆ THỐNG ĐĂNG NHẬP</h3>
                <p class="section-title">Hãy <strong>CHỌN ĐỐI TƯỢNG</strong> để <strong>ĐĂNG NHẬP</strong> vào hệ thống</p>
                <div class="d-flex justify-content-center align-items-center">
                    <a href="views/auth/signin.php" class="card mx-3 text-decoration-none text-white">
                        <img src="img/image1.png" class="card-img-top" alt="Nhân viên">
                        <div class="card-body">
                            <h5 class="card-title">Nhân viên hệ thống</h5>
                            <p class="card-text">Nếu là Nhân viên hãy click vào đây để đăng nhập.</p>
                        </div>
                    </a>
                    <div class="divider"></div>
                    <a href="views/auth/signin.php" class="card mx-3 text-decoration-none text-white">
                        <img src="img/image2.png" class="card-img-top" alt="Admin">
                        <div class="card-body">
                            <h5 class="card-title">Quản trị viên</h5>
                            <p class="card-text">Nếu là quản trị viên hãy click vào đây để đăng nhập.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>