<?php

session_start();

$count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
}

header('Content-Type: application/json');
echo json_encode(['count' => $count]);
?>
<script src="../src/js/cart-count.js"></script>