<?php
session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

// Nhận dữ liệu từ form 
$idsp = $_POST["product_id"];
$sql  = "delete from product where product_id = '$idsp'";
$newShop->runQuery($sql);

header("Location: ../index.php");
