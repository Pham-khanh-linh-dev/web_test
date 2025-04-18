<footer class="bg-custom-footer text-light mt-5 pt-4 pb-4 border-top">
    <style>
        footer {
            background-color:#90caf9 ; 
            color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
        }

        footer h5 {
            font-weight: bold;
            text-transform: uppercase;
        }

        footer a {
            color: #ffffff !important;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #a6d0e6;
        }

        footer .social-icons a {
            color: #ffffff;
            margin-right: 15px;
            font-size: 24px;
        }

        footer .social-icons a:hover {
            color: #a6d0e6; /* Màu hover của các icon xã hội */
        }

        footer small {
            color: #ffffff;
            font-size: 14px;
        }

        footer .container .row {
            padding-bottom: 30px;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3">
                <h5>Thông tin liên hệ</h5>
                <p class="mb-1"><i class="fa fa-envelope me-2"></i>support@laco.com</p>
                <p class="mb-1"><i class="fa fa-phone me-2"></i>+84 123 456 789</p>
                <p><i class="fa fa-map-marker-alt me-2"></i>123 Nguyễn Văn Cừ, TP. HCM</p>
            </div>
            <div class="col-md-3 mb-3">
                <h5>Liên kết nhanh</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-dark text-decoration-none">Trang chủ</a></li>
                    <li><a href="#" class="text-dark text-decoration-none">Tin tức</a></li>
                    <li><a href="#" class="text-dark text-decoration-none">Liên hệ</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-3">
                <h5>Theo dõi chúng tôi</h5>
                <a href="#" class="text-dark me-3"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" class="text-dark me-3"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-dark"><i class="fab fa-instagram fa-lg"></i></a>
            </div>
        </div>

        <div class="text-center mt-4">
            <small>© <?php echo date("Y"); ?> Laco Company. All rights reserved.</small>
        </div>
    </div>
</footer>
