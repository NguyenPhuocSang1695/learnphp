<?php
require_once "./baiThiDB.php";
$db = new baiThiDB("localhost", "root", "", "BaiThiDB");
$db->connectDB();

// Nhận dữ liệu từ form 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $addOK = 0;
    $cbocongtysx = $_POST["cbocongtysx"];
    $tensp = $_POST["txttensp"];
    $giachinhthuc = $_POST["txtgia"];
    $giamgia = $_POST["txtgiagiam"];
    $mota = $_POST["txtareamota"];
    $hinhdaidien = basename($_FILES["f_daidien"]["name"]);

    $sql = "insert into SANPHAM (tenSanPham, Gia, giamGia, moTa, Hinh, maNhaSanXuat)
    value ('$tensp', '$giachinhthuc', '$giamgia', '$mota', '$hinhdaidien', '$cbocongtysx')";

    $res = $db->runQuery($sql);
    if ($res) {
        header("Location: ../index.php?success=1");
    } else {
        header("Location: ../index.php?success=0");
    }
    exit;
}
