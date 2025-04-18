<?php
ob_start(); // Bắt đầu bộ đệm đầu ra

require_once("InvoiceController.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoice_data'])) {
    $invoiceData = json_decode($_POST['invoice_data'], true);
    if ($invoiceData) {
        $controller = new InvoiceController();
        // echo "<pre>";
        // print_r($invoiceData);
        // echo "</pre>";
        // exit;

        $controller->generateInvoice($invoiceData);
        // KHÔNG gọi ob_end_flush() ở đây nếu trong generateInvoice() đã gọi rồi
        exit; // Chấm dứt script sau khi PDF được xuất
    } else {
        if (ob_get_level()) ob_end_clean();
        echo "Dữ liệu hóa đơn không hợp lệ!";
    }
} else {
    if (ob_get_level()) ob_end_clean();
    echo "Không có dữ liệu hóa đơn được gửi!";
}
