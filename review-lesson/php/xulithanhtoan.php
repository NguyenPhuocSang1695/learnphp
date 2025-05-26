<?php
session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

if (!isset($_SESSION['username'])) {
    die("Bạn chưa đăng nhập.");
}

// Kiểm tra submit form
if (isset($_POST['submit_payment'])) {
    $username = $_SESSION['username'];
    echo $username;

    // Lấy user_id từ bảng user theo username
    $sqlUser = "SELECT user_id FROM user WHERE username = ?";
    $stmtUser = $newShop->prepareAndExecute($sqlUser, "s", [$username]);
    $userData = $stmtUser->get_result()->fetch_assoc();
    if (!$userData) {
        die("Không tìm thấy thông tin người dùng.");
    }
    $user_id = $userData['user_id'];

    // Lấy thông tin địa chỉ giao hàng
    if (isset($_POST['radio']) && $_POST['radio'] === 'khac') {
        // Địa chỉ mới
        $customer_name = $_POST['hovaten_moi'] ?? '';
        $customer_numberphone = $_POST['sodienthoai_moi'] ?? '';
        $customer_address = $_POST['diachi_moi'] ?? '';
    } else {
        // Địa chỉ mặc định lấy từ bảng user
        $sqlUserInfo = "SELECT username, number_phone, address FROM user WHERE username = ?";
        $stmtUserInfo = $newShop->prepareAndExecute($sqlUserInfo, "s", [$username]);
        $userInfo = $stmtUserInfo->get_result()->fetch_assoc();
        $customer_name = $userInfo['username'];
        $customer_numberphone = $userInfo['number_phone'];
        $customer_address = $userInfo['address'];
    }

    // Kiểm tra giỏ hàng
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        die("Giỏ hàng của bạn đang trống.");
    }

    // Tính tổng tiền
    $total_amount = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    // Phương thức thanh toán
    $payment_method = $_POST['payment_method'] ?? 'cod';

    // Thêm vào bảng orders
    $order_date = date("Y-m-d H:i:s");
    $status = "Đang chờ";

    $sqlInsertOrder = "INSERT INTO `order` (user_id, order_date, total_amount, status, Customer_name, Customer_numberphone, Customer_address, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsertOrder = $newShop->prepareAndExecute($sqlInsertOrder, "isdsssss", [
        $user_id,
        $order_date,
        $total_amount,
        $status,
        $customer_name,
        $customer_numberphone,
        $customer_address,
        $payment_method
    ]);

    if ($stmtInsertOrder) {
        $order_id = $newShop->getConnection()->insert_id; // Lấy order_id vừa insert

        // Thêm chi tiết đơn hàng
        $sqlInsertDetail = "INSERT INTO order_detail (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmtDetail = $newShop->getConnection()->prepare($sqlInsertDetail);

        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $stmtDetail->bind_param("iiid", $order_id, $product_id, $quantity, $price);
            $stmtDetail->execute();
        }
        $stmtDetail->close();

        // Xóa giỏ hàng
        unset($_SESSION['cart']);

        echo "<p>Thanh toán thành công! Đơn hàng của bạn đã được lưu.</p>";
        echo '<a href="../index.php">Quay lại trang chủ</a>';
    } else {
        echo "<p>Đã có lỗi xảy ra khi xử lý đơn hàng. Vui lòng thử lại.</p>";
    }
} else {
    echo "<p>Phương thức không hợp lệ.</p>";
}
