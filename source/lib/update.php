<?php
// Kết nối với database
require_once '../config/db.php'; // require_once bắt buộc ngăn ko cho chương trình chạy tiếp nếu file không tồn tại
include '../lib/data_func.php'; // include cho phép chương trình chạy tiếp nếu file không tồn tại chỉ thông báo warning

if (isset($_GET['email'])) {
    $email = $_GET['email'];  

    // Tạo đối tượng Database
    $db = new Database();

    // Gọi hàm updateStatus để cập nhật trạng thái người dùng
    try {
        $db->updateStatus($email);  
        echo json_encode(["status" => "success", "message" => "Tài khoản đã được kích hoạt thành công."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Không tìm thấy email."]);
}
?>
