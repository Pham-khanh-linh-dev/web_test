<?php
include_once 'config/auth_check.php';
include_once 'config/constants.php';
require_once(__DIR__ . '/controllers/InvoiceController.php');
include_once __DIR__ . '/views/layout/header.php';


$controller = new InvoiceController();

// Gọi hàm generateInvoice() chỉ khi có dữ liệu POST từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoice_data'])) {
    $controller->generateInvoice($_POST['invoice_data']);
}

// Sau đó include view để hiển thị trang
include(__DIR__ .'/views/Banhang/sell.php');

?>
