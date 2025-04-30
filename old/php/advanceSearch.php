<?php
include("../database/database.php"); // Kết nối database

// Lấy dữ liệu từ form
$productName = isset($_POST["productName"]) ? trim($_POST["productName"]) : "";
$minPrice = isset($_POST["minPrice"]) ? (float)$_POST["minPrice"] : 0;
$maxPrice = isset($_POST["maxPrice"]) ? (float)$_POST["maxPrice"] : 10000000;

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
if ($maxPrice > 0) {
    $query .= " AND price <= ?";
    $params[] = $maxPrice;
    $types .= "d";
}

// Chuẩn bị truy vấn
$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
</head>

<body>

    <h2>Kết quả tìm kiếm</h2>

    <?php if (!empty($products)) : ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
            </tr>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?= htmlspecialchars($product["product_id"]) ?></td>
                    <td><?= htmlspecialchars($product["product_name"]) ?></td>
                    <td><?= number_format($product["price"], 0, ",", ".") ?> VND</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>Không tìm thấy sản phẩm nào.</p>
    <?php endif; ?>

</body>

</html>