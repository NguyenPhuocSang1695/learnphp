<?php
session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

// Nhận dữ liệu từ form 
$id = $_POST["product_id"];
$ten = $_POST["product_name"];
$gia = $_POST["price"];

// Thư mục ảnh
$target_dir = "../img/";

// Lấy tên ảnh cũ trong database
$sqlSelect = "SELECT imageURL FROM product WHERE product_id = $id";
$res = $newShop->runQuery($sqlSelect);
$row = $res->fetch_assoc();
$anh_cu = $row["imageURL"];

// Nếu người dùng chọn ảnh mới
if (!empty($_FILES["image"]["name"])) {
    $hinh = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $hinh;

    // Xoá ảnh cũ nếu tồn tại
    if (file_exists($target_dir . $anh_cu) && !empty($anh_cu)) {
        unlink($target_dir . $anh_cu);
    }

    // Upload ảnh mới
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Update dữ liệu sản phẩm với ảnh mới
        $sqlUpdate = "UPDATE product SET product_name = '$ten', price = '$gia', imageURL = '$hinh' WHERE product_id = $id";
    } else {
        echo "Lỗi upload ảnh!";
        exit();
    }
} else {
    // Nếu không chọn ảnh mới, chỉ update tên và giá
    $sqlUpdate = "UPDATE product SET product_name = '$ten', price = '$gia' WHERE product_id = $id";
}

// Chạy query update
$newShop->runQuery($sqlUpdate);

// Chuyển về trang chỉnh sửa
header("Location: ../pages/edit_product.php?id=" . $id);
exit();
