<?php
require_once __DIR__ . '/../models/CustomerModel.php';

$customers = CustomerModel::getAllCustomers();

require_once __DIR__ . '/../views/Customer/listKhachhang.php';  // Đảm bảo gọi đúng view

?>
