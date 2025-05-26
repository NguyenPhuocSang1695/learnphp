<?php
session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Lấy thông tin sản phẩm từ database để đảm bảo giá và tên chuẩn
    $sql = "SELECT * FROM product WHERE product_id = ?";
    $params = [$product_id];
    $stmt = $newShop->prepareAndExecute($sql, "i", $params);
    $product = $stmt->get_result()->fetch_assoc();

    if (!$product) {
        echo "Sản phẩm không tồn tại.";
        exit;
    }

    // Tạo mảng giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra sản phẩm đã có trong giỏ chưa
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    unset($item); // Xoá tham chiếu

    // Nếu chưa có thì thêm mới
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'product_name' => $product['product_name'],
            'price' => $product['price'],
            'imageURL' => $product['imageURL'],
            'quantity' => $quantity
        ];
    }

    // Sau khi thêm thành công:
    $_SESSION['success_message'] = "Đã thêm sản phẩm <strong>" . htmlspecialchars($product['product_name']) . "</strong> vào giỏ hàng!";

    // Chuyển lại trang chi tiết sản phẩm
    header("Location: ../pages/chitietsanpham.php?product_id=" . $product_id);
    exit;
}
