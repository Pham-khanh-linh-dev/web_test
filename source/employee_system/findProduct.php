<?php

header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "da19db"); 

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Lỗi kết nối CSDL"]));
}

$search = $_POST['search'] ?? '';

if (empty($search)) {
    echo json_encode(["success" => false, "message" => "Từ khóa tìm kiếm không hợp lệ!"]);
    exit;
}

$query = "SELECT * FROM products WHERE name LIKE ? OR barcode LIKE ? OR id LIKE ?";
$stmt = $conn->prepare($query);
$searchTerm = "%" . $search . "%";
$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode([
    "success" => true,
    "products" => $products 
]);

$stmt->close();
$conn->close();
?>
