
<?php

header("Content-Type: application/json");


$conn = new mysqli("localhost", "root", "", "da19db"); 

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Lỗi kết nối CSDL"]));
}


$data = json_decode(file_get_contents("php://input"), true);
$phone = $data["phone"] ?? "";

if (empty($phone)) {
    echo json_encode(["success" => false, "message" => "Số điện thoại không hợp lệ"]);
    exit;
}


$stmt = $conn->prepare("SELECT name, address FROM customers WHERE phone = ?");
$stmt->bind_param("s", $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
 
    echo json_encode([
        "success" => true,
        "name" => $row["name"],
        "address" => $row["address"]
    ]);
} else {
    echo json_encode([
        "success" => false,
        "new_customer" => true,
        "message" => "Không tìm thấy khách hàng, vui lòng nhập thông tin!" // them khach hang
    ]);
}

$stmt->close();
$conn->close();
?>
