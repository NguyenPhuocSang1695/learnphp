<?php
session_start();
require_once "../conf/shopDB.php";

$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

if (isset($_POST['txttimkiem'])) {
    $limit = 5;
    $keyword = "%" . $_POST['txttimkiem'] . "%";

    $sql = "SELECT * FROM product WHERE product_name LIKE ? ORDER BY product_id DESC";
    $params = [$keyword];
    $stmt = $newShop->prepareAndExecute($sql, "s", $params);
    $res = $stmt->get_result();

    $resultHTML = [];

    if ($res->num_rows > 0) {
        while ($product = $res->fetch_assoc()) {
            $resultHTML[] = $product;
        }
    }

    // Tính tổng số trang
    $totalProduct = count($resultHTML);
    $totalPage = ceil($totalProduct / $limit);

    // Lưu vào session
    $_SESSION['ketquatimkiem'] = $resultHTML;
    $_SESSION['timkiem_totalPage'] = $totalPage;
    $_SESSION['txttimkiem'] = $_POST['txttimkiem'];
}

// Quay lại index
header("Location: ../index.php");
exit();
