<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Cho phép truy cập từ các domain khác nếu cần

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Kết nối thất bại"]));
}

// Nhận category_id từ URL
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

$sql = "SELECT ProductName, DescriptionBrief, Price, ImageURL FROM products WHERE CategoryID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($products);
