<?php
session_start();
require_once '../conf/connectdb.php';
$conn = connect_db();

if (isset($_POST['product_id'])) {
    $productId = mysqli_real_escape_string($conn, $_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Lấy thông tin sản phẩm từ DB
    $sql = "SELECT * FROM products WHERE product_id = '$productId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Tạo mảng sản phẩm trong giỏ hàng
        $item = [
            'id' => $product['product_id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => $quantity
        ];

        // Thêm vào session giỏ hàng
        if (isset($_SESSION['cart'][$productId])) {
            // Nếu đã có sản phẩm thì cộng thêm số lượng
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $item;
        }

        // Chuyển hướng về trang giỏ hàng hoặc trang trước đó
        header('Location: ../pages/cart.php?id=' . $productId);
        exit();
    } else {
        echo "Sản phẩm không tồn tại.";
    }
} else {
    echo "Không có ID sản phẩm.";
}
