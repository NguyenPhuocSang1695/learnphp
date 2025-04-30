<?php
include("../database/database.php"); // Kết nối database
header("Content-Type: application/json");

// Nhận dữ liệu từ Fetch API
$data = json_decode(file_get_contents("php://input"), true);
$selectedType = isset($data["selectedType"]) ? $data["selectedType"] : "";

$query = "SELECT product_name, price FROM product WHERE type_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $selectedType);
$stmt->execute();
$result = $stmt->get_result();

$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();

// Trả về dữ liệu JSON
echo json_encode(["products" => $products]);