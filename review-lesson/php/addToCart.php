<?php
session_start();

$productId = $_POST['product_id'];
$quantity = $_POST['quantity'];

// Thêm sản phẩm vào session
$_SESSION['cart'][$productId] = [
    'product_id' => $productId,
    'quantity' => $quantity
];

// Cập nhật totalQuantity luôn
$_SESSION['totalQuantity'] = count($_SESSION['cart']);

header("Location: index.php");
exit();
