<?php
include("../database/database.php"); // Kết nối database
header("Content-Type: application/json");

// Lấy dữ liệu từ request JSON
$data = json_decode(file_get_contents("php://input"), true);

$productName = isset($data["productName"]) ? trim($data["productName"]) : "";
$minPrice = isset($data["minPrice"]) && $data["minPrice"] !== "" ? (float)$data["minPrice"] : 0;
$maxPrice = isset($data["maxPrice"]) && $data["maxPrice"] !== "" ? (float)$data["maxPrice"] : null;
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$limit = isset($_GET["limit"]) ? (int)$_GET["limit"] : 5; // Giới hạn 5 sản phẩm/trang
$offset = ($page - 1) * $limit;

// Tạo câu truy vấn động
$query = "SELECT product_id, product_name, price FROM product WHERE 1=1";
$params = [];
$types = "";

// Nếu có điều kiện tìm kiếm theo tên sản phẩm
if (!empty($productName)) {
    $query .= " AND product_name LIKE ?";
    $params[] = "%$productName%";
    $types .= "s";
}

// Nếu có điều kiện tìm kiếm theo giá
if ($minPrice > 0) {
    $query .= " AND price >= ?";
    $params[] = $minPrice;
    $types .= "d";
}
if ($maxPrice !== null) { // Chỉ lọc maxPrice nếu người dùng nhập
    $query .= " AND price <= ?";
    $params[] = $maxPrice;
    $types .= "d";
}

// Lấy tổng số sản phẩm (không có LIMIT)
$countQuery = "SELECT COUNT(*) as total FROM product WHERE 1=1";
if (!empty($productName)) $countQuery .= " AND product_name LIKE '%$productName%'";
if ($minPrice > 0) $countQuery .= " AND price >= $minPrice";
if ($maxPrice !== null) $countQuery .= " AND price <= $maxPrice";

$totalProducts = $conn->query($countQuery)->fetch_assoc()["total"];
$totalPages = ceil($totalProducts / $limit);

// Thêm LIMIT vào truy vấn
$query .= " LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "dd";

// Chuẩn bị truy vấn
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

// Trả về JSON
echo json_encode([
    "status" => "success",
    "products" => $products,
    "totalPages" => $totalPages,
    "currentPage" => $page
]);
