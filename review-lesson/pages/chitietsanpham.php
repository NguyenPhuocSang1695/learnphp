<?php
session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];

    // Lấy thông tin sản phẩm
    $sql = "SELECT * FROM product WHERE product_id = ?";
    $params = [$product_id];
    $stmt = $newShop->prepareAndExecute($sql, "i", $params);
    $product = $stmt->get_result()->fetch_assoc();

    if (!$product) {
        echo "Sản phẩm không tồn tại.";
        exit;
    }
} else {
    echo "Không có ID sản phẩm.";
    exit;
}

$totalQuantity = 0;
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $item) {
        $totalQuantity += $item['quantity'];
    }
}

if (isset($_SESSION['success_message'])) {
    echo "<div class='alert-success' id='alertBox' style='padding: 10px; margin: 15px 0; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; text-align: center;'>
        " . $_SESSION['success_message'] . "
    </div>";
    unset($_SESSION['success_message']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="../css/ctsp.css">
    <link rel="stylesheet" href="../css/cart-on-num.css">
</head>

<body>
    <nav>
        <div class="cart" onclick="location.href='../pages/giohang.php'">
            <button style="cursor: pointer;">🛒</button>
            <div class="soluongsp"><?php echo $totalQuantity; ?></div>
        </div>
    </nav>
    <main>
        <div class="chitietsanpham">
            <form action="../php/xulithemgiohang.php" method="POST" enctype="multipart/form-data">
                <p name=" 'prodcu'"><strong>ID sản phẩm:</strong> <?php echo htmlspecialchars($product['product_id']); ?></p>
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>" readonly>

                <img style="max-width: 150px;" src="../img/<?php echo htmlspecialchars($product['imageURL']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-image">

                <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
                <p>Giá: <strong><?php echo number_format($product['price']); ?> VNĐ</strong></p>
                <p>Ngày tạo: <?php echo htmlspecialchars($product['created_at']); ?></p>
                <div class="the-quantity">
                    <button type="button" class="btn-quantity" name="minus" data-action="decrease">-</button>
                    <input type="number" name="quantity" id="quantity" value="1" min="1">
                    <button type="button" class="btn-quantity" name="plus" data-action="increase">+</button>
                </div>

                <!-- Nút thêm vào giỏ hàng - -->
                <button type="submit" name="submit" id="submit">Thêm vào giỏ hàng</button>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const minusButton = document.querySelector('.btn-quantity[name="minus"]');
            const plusButton = document.querySelector('.btn-quantity[name="plus"]');

            minusButton.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            plusButton.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });
        });
    </script>
    <script>
        // Nếu có hộp thông báo thì tự ẩn sau 3 giây
        const alertBox = document.getElementById('alertBox');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 3000);
        }
    </script>

</body>

</html>