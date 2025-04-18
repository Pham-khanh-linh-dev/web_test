<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý Khách Hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="assets/css/khachhang.css"> 
</head>
<body>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="text-primary mb-0">Danh sách khách hàng</h3>
     
      <a href="addCustomer.php" class="btn btn-primary d-lg-none">
        <i class="fas fa-plus"></i> Thêm mới
      </a>
    </div>
    <?php if (empty($customers)): ?>
  <div class="alert alert-info text-center">
    Không có khách hàng nào. <a href="addCustomer.php" class="alert-link">Thêm khách hàng mới</a>
  </div>
<?php else: ?>
  <div class="row">
    <?php foreach ($customers as $customer): ?>
      <div class="col-md-4 mb-3">
        <div class="card customer-card shadow-sm p-3" data-id="<?= $customer['id'] ?>">
          <div class="card-body">
            <h5 class="card-title text-primary"><?= htmlspecialchars($customer['name']) ?></h5>
            <p class="card-text">
              <i class="fas fa-phone text-muted"></i> <?= htmlspecialchars($customer['phone']) ?><br>
              <i class="fas fa-map-marker-alt text-muted"></i> <?= htmlspecialchars($customer['address']) ?>
            </p>
            <button class="btn btn-outline-primary btn-sm view-details">
              <i class="fas fa-history"></i> Lịch sử mua hàng
            </button>
          </div>
        </div>

        <div class="order-details card p-3 mt-2 shadow-sm" id="orders-<?= $customer['id'] ?>">
          <div class="text-center">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="assets/js/customers.js"></script>
  </div>