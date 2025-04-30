<?php
header('Content-Type: application/json');

// Kết nối CSDL
header('Content-Type: application/json');
include('../database/database.php');

// Lấy thông tin tìm kiếm từ request
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Số kết quả mỗi trang
$offset = ($page - 1) * $limit;

// Truy vấn tìm kiếm theo username, số điện thoại hoặc địa chỉ
$sql = "SELECT username, numberphone, address FROM customer 
        WHERE username LIKE '%$search%' 
        OR numberphone LIKE '%$search%' 
        OR address LIKE '%$search%'
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$customers = [];
while ($row = $result->fetch_assoc()) {
    $customers[] = $row;
}

// Lấy tổng số kết quả tìm được
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM customer 
                            WHERE username LIKE '%$search%' 
                            OR numberphone LIKE '%$search%' 
                            OR address LIKE '%$search%'");
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $limit);

// Trả về JSON
echo json_encode([
    "customers" => $customers,
    "totalPages" => $totalPages,
    "currentPage" => $page
]);

$conn->close();
