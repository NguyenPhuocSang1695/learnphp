<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);

        // Tính tổng số lượng còn lại
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
