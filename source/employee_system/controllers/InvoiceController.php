<?php
// InvoiceController.php

require_once(__DIR__ . '/../models/InvoiceModel.php');
require_once(__DIR__ . '/../models/CustomerModel.php');
require_once(__DIR__ . '/../models/ProductModel.php');

class InvoiceController {

    public function generateInvoice($invoiceData) {
        // Nếu dữ liệu không phải mảng, decode từ JSON
        if (!is_array($invoiceData)) {
            $invoiceData = json_decode($invoiceData, true);
        }

        if (!$invoiceData || !isset($invoiceData["products"])) {
            die("Dữ liệu không hợp lệ!");
        }

        $customerModel = new CustomerModel();
        $productModel = new ProductModel();

        // --- Xử lý khách hàng ---
        if (!empty($invoiceData["customer"])) {
            $customerId = $customerModel->processCustomer($invoiceData["customer"]);
            $invoiceData["customer"]["id"] = $customerId;

            if (isset($invoiceData["total"])) {
                $customerModel->updateTotalSpent($customerId, $invoiceData["total"]);
            }
        }

        // --- Kiểm tra tồn kho ---
        foreach ($invoiceData["products"]["items"] as $product) {
            $productModel->checkStock($product);
        }

        // --- Cập nhật tồn kho ---
        foreach ($invoiceData["products"]["items"] as $product) {
            $productModel->updateStock($product);
        }


        // --- Xuất PDF ---
        $this->generatePDF($invoiceData);
    }

    private function generatePDF($invoiceData) {
        ob_start();

        $html = $this->generateHTML($invoiceData);
        require_once(__DIR__ . '/../TCPDF-main/tcpdf.php');

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->writeHTML($html, true, false, true, false, '');

        ob_end_clean();
        $pdf->Output("hoa_don.pdf", "D");
    }

    private function generateHTML($invoiceData) {
        $html = "<h2 style='text-align:center;'>HÓA ĐƠN BÁN HÀNG</h2>";
        $html .= "<table border='1' cellpadding='10' cellspacing='0' style='width:100%; border-collapse: collapse;'>";
        $html .= "<tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                  </tr>";
    
        foreach ($invoiceData["products"]["items"] as $product) {
            $html .= "<tr>
                        <td>" . htmlspecialchars($product["name"]) . "</td>
                        <td>" . htmlspecialchars($product["quantity"]) . "</td>
                        <td>" . number_format($product["price"], 0, ',', '.') . "</td>
                        <td>" . number_format($product["total"], 0, ',', '.') . "</td>
                      </tr>";
        }
    
        $formattedTotal = number_format($invoiceData["total"], 0, ',', '.');
        $html .= "</table><h3 style='text-align:right;'>Tổng cộng: " . $formattedTotal . " VND</h3>";
    
        if (!empty($invoiceData["customer"])) {
            $html .= "<h4>Khách hàng: " . htmlspecialchars($invoiceData["customer"]["name"]) . "</h4>";
            $html .= "<p>SĐT: " . htmlspecialchars($invoiceData["customer"]["phone"]) . "</p>";
            $html .= "<p>Địa chỉ: " . htmlspecialchars($invoiceData["customer"]["address"]) . "</p>";
        }
    
        return $html;
    }
    
}
?>
