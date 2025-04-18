<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bán hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/laptrinhweb_da19_hk2_2425/source/employee_system/assets/css/sell.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card p-5 shadow-lg">
            <h3 class="mb-4 text-primary"><i class="fas fa-cart-plus me-2"></i>Thêm sản phẩm vào đơn hàng</h3>

            <!-- Product Search -->
            <div class="input-group mb-4">
                <input type="text" id="product-search" class="form-control" placeholder="🔍 Tìm kiếm sản phẩm (tên, mã vạch, ID)..." onkeypress="if(event.key == 'Enter') findProduct()">
                <button class="btn btn-primary search-btn" onclick="findProduct()">
                    <i class="fas fa-search me-1"></i> Tìm
                </button>
            </div>

            <!-- Search Results -->
            <div class="table-responsive mb-5">
                <h5 class="mb-2 text-secondary"><i class="fas fa-box-open me-2"></i>Kết quả tìm kiếm</h5>
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Giá bán</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="search-result">
                        <tr><td colspan="3" class="text-center text-muted">Chưa có kết quả tìm kiếm</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Cart -->
            <h5 class="mb-2 text-secondary"><i class="fas fa-shopping-cart me-2"></i>Giỏ hàng</h5>
            <div class="table-responsive rounded shadow-sm">
                <table class="table table-hover align-middle">
                    <thead class="table-header">
                        <tr>
                            <th>Sản phẩm</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-end">Tổng tiền</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        <tr><td colspan="5" class="text-center text-muted">Chưa có sản phẩm nào</td></tr>
                    </tbody>
                    <tfoot>
                        <tr class="table-footer">
                            <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                            <td id="grand-total" class="fw-bold text-end">0 VND</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3 text-end">
                <button class="btn btn-primary" onclick="goToConfirmPage()">
                    <i class="fas fa-arrow-right me-1"></i> Tiếp tục thanh toán
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body" id="modalMessage"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/laptrinhweb_da19_hk2_2425/source/employee_system/assets/js/sell.js"></script>
</body>
</html>
