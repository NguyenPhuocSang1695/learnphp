<?php
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

// Lấy chi tiết đơn hàng
$sql = "SELECT od.*, p.product_name 
        FROM order_detail od
        JOIN product p ON od.product_id = p.product_id
        WHERE od.order_id = ?";
$params = [$order_id];
$stmt = $newShop->prepareAndExecute($sql, "i", $params);
$res = $stmt->get_result();

$sqlOrder = "SELECT * FROM `order` WHERE order_id = ?";
$stmtOrder = $newShop->prepareAndExecute($sqlOrder, "i", [$order_id]);
$resOrder = $stmtOrder->get_result();
$resProducts = $resOrder->fetch_assoc();
if (!$res->num_rows) {
    echo "Không có đơn hàng nào với ID: $order_id";
    exit;
}

// Xử lý hủy đơn hàng
if (isset($_POST['cancel_order'])) {
    $sql = "UPDATE `order` SET status = 'Đã hủy' WHERE order_id = ? AND status != 'Đã giao'";
    $stmt = $newShop->prepareAndExecute($sql, "i", [$order_id]);
    if ($stmt->affected_rows > 0) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?order_id=" . $order_id);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="../css/cthd.css">
</head>

<body>

    <header>
        <nav>
            <a href="../index.php">Trang chủ</a>
            <a href="./personal.php">Tài khoản</a>
            <a href="./giohang.php">Giỏ hàng</a>
        </nav>

        <section>
            <h1>Thông tin người nhận</h1>
            <p><strong>Họ và tên:</strong> <?= htmlspecialchars($resProducts['Customer_name'] ?? 'Chưa cập nhật') ?></p>
            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($resProducts['Customer_numberphone'] ?? 'Chưa cập nhật') ?></p>
            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($resProducts['Customer_address'] ?? 'Chưa cập nhật') ?></p>
            <p><strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($resProducts['payment_method'] ?? 'Chưa cập nhật') ?></p>
            <p><strong>Ngày đặt hàng:</strong> <?= htmlspecialchars($resProducts['order_date'] ?? 'Chưa cập nhật') ?></p>
            <p><strong>Trạng thái đơn hàng:</strong> <?= htmlspecialchars($resProducts['status'] ?? 'Chưa cập nhật') ?></p>

        </section>
    </header>

    <h2>Chi tiết đơn hàng #<?= $order_id ?></h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stt = 1;
            $tongdon = 0;
            while ($row = $res->fetch_assoc()) {
                $thanhtien = $row['quantity'] * $row['price'];
                $tongdon += $thanhtien;
                echo "<tr>
                <td>$stt</td>
                <td>{$row['product_name']}</td>
                <td>{$row['quantity']}</td>
                <td>" . number_format($row['price']) . " VNĐ</td>
                <td>" . number_format($thanhtien) . " VNĐ</td>
               
            </tr>";
                $stt++;
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan='4'>Tổng đơn hàng</th>
                <th><?= number_format($tongdon) ?> VNĐ</th>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 20px;">
        <a href="./personal.php" style="margin-right: 20px;">← Quay lại danh sách đơn hàng</a>

        <?php if ($resProducts['status'] !== 'Đã giao' && $resProducts['status'] !== 'Đã hủy'): ?>
            <form method="POST" style="display: inline;">
                <button type="submit" name="cancel_order"
                    style="padding: 8px 15px; 
                               background-color: #dc3545; 
                               color: white; 
                               border: none; 
                               border-radius: 4px; 
                               cursor: pointer;"
                    onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                    Hủy đơn hàng
                </button>
            </form>
        <?php endif; ?>
    </div>

</body>

</html>