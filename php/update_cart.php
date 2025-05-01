<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity > 0 && isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;

        // Tính tổng số lượng trong giỏ hàng
        $total_items = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total_items += $item['quantity'];
        }

        echo json_encode([
            'success' => true,
            'total_items' => $total_items
        ]);
        exit();
    }
}

echo json_encode(['success' => false]);
exit();
