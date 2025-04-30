<?php
header("Content-Type: application/json");

// Kết nối database
$conn = new mysqli("localhost", "root", "", "test-db");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Lấy giá trị tìm kiếm từ AJAX
$product_id = isset($_GET["product_id"]) ? trim($_GET["product_id"]) : "";
$product_name = isset($_GET["product_name"]) ? trim($_GET["product_name"]) : "";
$max_price = isset($_GET["price"]) ? trim($_GET["price"]) : "";

// Xây dựng truy vấn SQL động
$sql = "SELECT product_id, product_name, price FROM product WHERE 1=1";

if (!empty($product_id)) {
    $sql .= " AND product_id = ?";
}
if (!empty($product_name)) {
    $sql .= " AND product_name LIKE ?";
}
if (!empty($max_price) && is_numeric($max_price)) {
    $sql .= " AND price <= ?";
}

$stmt = $conn->prepare($sql);

// Ràng buộc tham số vào truy vấn
$bind_types = "";
$bind_values = [];

if (!empty($product_id)) {
    $bind_types .= "i";
    $bind_values[] = $product_id;
}
if (!empty($product_name)) {
    $bind_types .= "s";
    $bind_values[] = "%" . $product_name . "%";
}
if (!empty($max_price) && is_numeric($max_price)) {
    $bind_types .= "d";
    $bind_values[] = $max_price;
}

if (!empty($bind_types)) {
    $stmt->bind_param($bind_types, ...$bind_values);
}

$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
$conn->close();
