<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion " style="background-color: #e3f2fd;" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Chức năng hệ thống</div>
                <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                    Trang chủ
                </a>
                
                <div class="sb-sidenav-menu-heading">Chức năng chính</div>
                <!-- Chức năng quản lý tài khoản -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-circle-user"></i></div>
                    Quản lý tài khoản
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="../views/auth/signup.php">Đăng ký tài khoản nhân viên</a>
                        <a class="nav-link" href="employee-list.php">Xem thông tin nhân viên</a>
                    </nav>
                </div>
                <!-- Chức năng quản lí sản phẩm và danh mục -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Quản lí sản phẩm và danh mục
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link" href="#" >Quản lí danh mục</a>
                        <a class="nav-link collapsed" href="#" >Quản lí sản phẩm</a>   
                    </nav>
                </div>

                <!-- Chức năng quản lí khách hàng -->
                <a class="nav-link" href="customer.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                    Quản lí khách hàng
                </a>
                
                <!-- Chức năng xử lí giao dịch -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCart" aria-expanded="false" aria-controls="collapseCart">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                Xử lí giao dịch
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCart" aria-labelledby="headingCart" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion">
                        <a class="nav-link" href="#">Danh sách sản phẩm</a>
                        <a class="nav-link" href="#">Tổng tiền đơn hàng</a>
                        <a class="nav-link" href="#">Thông tin khách hàng</a>
                        <a class="nav-link" href="#">Hoàn tất thanh toán</a>
                    </nav>
                </div>
                
                <!-- Chức năng quản lí báo cáo -->
                <a class="nav-link" href="/laptrinhweb_da19_hk2_2425/source/admin_system/report/index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                    Báo cáo & Phân tích
                </a>
                


                <div class="sb-sidenav-menu-heading">Mở rộng</div>
                <!-- abc -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                    Quản lí cài đặt
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseExample" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionSettings">
                        <a class="nav-link" href="#">Cài đặt chung</a>
                        <a class="nav-link" href="#">Cài đặt thông báo</a>
                        <a class="nav-link" href="#">Cài đặt quyền truy cập</a>
                    </nav>
                </div>
            </div>
        </div>
        
    </nav>
</div>