<?php
header('Content-Type: application/json');

// Kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Lấy danh sách danh mục
$sql = "SELECT category_id, category_name FROM categories";
$result = $conn->query($sql);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

echo json_encode($categories);
