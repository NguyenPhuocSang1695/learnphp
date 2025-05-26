<?php
session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();
$newShop->isLogined();

// Đếm số lượng sản phẩm trong giỏ hàng (giống nhau)
// $totalQuantity = 0;
// if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
//     foreach ($_SESSION['cart'] as $item) {
//         $totalQuantity += $item['quantity'];
//     }
// }

// Đếm số lượng sản phẩm khác nhau
$totalQuantity = 0;
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $totalQuantity = count($_SESSION['cart']);
}

// Lưu totalQuantity vào session
$_SESSION['totalQuantity'] = $totalQuantity;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../css/giohang.css">
    <link rel="stylesheet" href="../css/cart-on-num.css">
</head>

<body>
    <nav>
        <div class="cart">
            <button style="cursor: pointer;">🛒</button>
            <div class="soluongsp"><?php echo $totalQuantity; ?></div>
        </div>
    </nav>
    <main>
        <h1>Giỏ hàng của bạn</h1>
        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_id']); ?></td>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo number_format($item['price']); ?> VNĐ</td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td><?php echo number_format($item['price'] * $item['quantity']); ?> VNĐ</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Giỏ hàng của bạn đang trống.</p>
        <?php endif; ?>


        <a href="../index.php">
            <button>
                Quay lại trang chủ
            </button>
        </a>


        <a href="../pages/thanhtoan.php">
            <button style="margin: 30px 30px;">
                Thanh toán
            </button>
        </a>
    </main>
</body>

</html>