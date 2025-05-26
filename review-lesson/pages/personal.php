<?php
session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thông Tin Khách Hàng</title>
    <link rel="stylesheet" href="../css/personal.css">
</head>

<body>
    <div class="container">
        <h1>Thông Tin Khách Hàng</h1>

        <div class="customer-info">
            <?php
            $sql = "select * from user where username = '$username'";
            $result = $newShop->runQuery($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<p><strong>Username:</strong>" . $row["username"] . "</p>";
                echo "<p><strong>Email:</strong>" . $row["email"] . "</p>";
                echo "<p><strong>Số điện thoại:</strong>" . $row["number_phone"] . "</p>";
                echo "<p><strong>Địa chỉ:</strong>" . $row["address"] . "</p>";
            }
            ?>
        </div>

        <h2>Danh Sách Đơn Hàng</h2>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Mã Đơn</th>
                    <th>Ngày Mua</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Lấy user_id từ username
                $userIdSql = "SELECT user_id FROM user WHERE username = '$username'";
                $resUserId = $newShop->runQuery($userIdSql);
                $rowUserId = $resUserId->fetch_assoc();
                $userId = $rowUserId['user_id'];

                // Lấy danh sách đơn hàng theo user_id
                $orderSql = "SELECT * FROM `order` WHERE user_id = '$userId'";
                $resOrder = $newShop->runQuery($orderSql);

                // Hiển thị đơn hàng
                while ($row = $resOrder->fetch_assoc()) {
                    echo "<tr onclick=\"window.location='./chitietdonhang.php?order_id={$row['order_id']}'\" style='cursor: pointer;'>";
                    echo "<td>{$row['order_id']}</td>";
                    echo "<td>{$row['order_date']}</td>";
                    echo "<td>" . number_format($row['total_amount']) . " VNĐ</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "</tr>";
                }
                ?>
                <!-- Thêm đơn hàng khác tại đây -->
            </tbody>
        </table>
    </div>

    <a href="../index.php">
        <button>
            Quay về trang chủ
        </button>
    </a>
    <script src="../js/pageReload.js"></script>
</body>

</html>