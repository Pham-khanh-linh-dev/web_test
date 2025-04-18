<?php
//file thêm khách hàng từ hệ thống không cần nhập thủ công
header("Content-Type: application/json");


$conn = new mysqli("localhost", "root", "", "da19db"); 

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Lỗi kết nối CSDL"]));
}

// Nhận dữ liệu khi nhập
$data = json_decode(file_get_contents("php://input"), true);
$phone = $data["phone"] ?? "";
$name = $data["name"] ?? "";
$address = $data["address"] ?? "";

// Kiểm tra dữ liệu khi hhap
if (empty($phone) || empty($name) || empty($address)) {
    echo json_encode(["success" => false, "message" => "Vui lòng nhập đầy đủ thông tin!"]);
    exit;
}

// Kiểm tra xem khách hàng đã tồn tại 
$checkStmt = $conn->prepare("SELECT phone FROM customers WHERE phone = ?");
$checkStmt->bind_param("s", $phone);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Khách hàng đã tồn tại!"]);
    exit;
}
$checkStmt->close();

// Thêm khách hàng mới
$stmt = $conn->prepare("INSERT INTO customers (phone, name, address) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $phone, $name, $address);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Tạo tài khoản khách hàng thành công!"]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi SQL: " . $stmt->error]);
}
if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Tạo tài khoản khách hàng thành công!",
        "redirect" => true
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi SQL: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
