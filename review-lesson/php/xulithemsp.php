<?php
session_start();
require_once "../conf/shopDB.php";

// Kết nối database
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

// Nhận dữ liệu từ form
$tensp = $_POST["product_name"];
$gia = $_POST["price"];
$loai = $_POST["category_id"];
$nsx  = $_POST["manufacturer_id"];

// Xử lý ảnh upload
$ext = strtolower(pathinfo($_FILES["anh"]["name"], PATHINFO_EXTENSION));

// Hàm tạo chuỗi random
function generateRandomString($length = 10)
{
    return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length);
}

// Tạo tên ảnh mới random hoàn toàn
$newImageName = "product_" . generateRandomString(10) . "." . $ext;

// Thư mục lưu ảnh
$target_dir  = "../img/";
$target_file = $target_dir . $newImageName;

// Di chuyển ảnh vào thư mục
if (move_uploaded_file($_FILES["anh"]["tmp_name"], $target_file)) {

    // Thêm sản phẩm vào database
    $sql = "INSERT INTO product (product_name, price, category_id, manufacturer_id, imageURL) VALUES (?, ?, ?, ?, ?)";
    $params = [$tensp, $gia, $loai, $nsx, $newImageName];

    $newShop->prepareAndExecute($sql, "sdiis", $params);

    // Chuyển hướng về trang chủ
    header("Location: ../index.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
