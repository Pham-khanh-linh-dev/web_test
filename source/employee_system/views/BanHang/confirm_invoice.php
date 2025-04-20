<?php 
include_once '../../config/constants.php';
include_once '../../config/auth_check.php';
include_once __DIR__ . '/../../views/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
    <link rel="stylesheet" href="../../assets/css/sell.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-file-invoice"></i> Xác nhận đơn hàng</h2>

    <div class="card p-3 mb-4">
        <h5 class="mb-3"><i class="fas fa-user"></i> Thông tin khách hàng</h5>
        <div class="row g-3 align-items-center mb-2">
            <div class="col-auto">
                <input type="number" id="customer-phone" class="form-control" placeholder="Nhập số điện thoại">
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-primary" onclick="findCustomer()">Tìm khách</button>
            </div>
        </div>
        <div id="customer-info"></div>
    </div>

    <div class="card p-3 mb-4">
        <h5 class="mb-3"><i class="fas fa-box-open"></i> Danh sách sản phẩm</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody id="summary-product-list"></tbody>
            </table>
        </div>
        <div class="text-end mt-3">
            <h5>Tổng cộng: <span id="summary-grand-total">0 VND</span></h5>
        </div>
    </div>

    <form action="../../controllers/export_invoice.php" method="POST" id="invoiceForm" target="_blank">
                    <input type="hidden" name="invoice_data" id="invoiceData">
                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-success px-4" onclick="confirmInvoice()">
                            <i class="fas fa-file-invoice"></i> Xuất hóa đơn
                        </button>
                    </div>
                </form>
</div>


<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body" id="modalMessage"></div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/confirm_invoice.js"></script>
<?php  include_once __DIR__ . '/../../views/layout/footer.php'; ?>
</body>
</html>
