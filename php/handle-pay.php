<?php
session_start();
require_once '../conf/connectdb.php';
$conn = connect_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $info_option = $_POST['info_option'];
    $payment_method = $_POST['payment_method'];

    // Nếu người dùng chọn nhập thông tin mới thì lấy từ form
    if ($info_option === 'new') {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
    } else {
        // Lấy thông tin mặc định từ database
        $sql = "SELECT first_name, last_name, phone, address FROM customers WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        $name = $user['first_name'] . ' ' . $user['last_name'];
        $phone = $user['phone'];
        $address = $user['address'];
    }

    // Tính tổng tiền
    $total_amount = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }
    $total_amount += 30000; // phí ship

    // Thêm đơn hàng vào bảng orders
    $insert_order = "INSERT INTO orders (username, total_amount, status) VALUES ('$username', '$total_amount', 'pending')";
    if (mysqli_query($conn, $insert_order)) {
        $order_id = mysqli_insert_id($conn); // Lấy id đơn hàng vừa thêm

        // Thêm chi tiết đơn hàng
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['id'];
            $quantity = $item['quantity'];
            $unit_price = $item['price'];

            $insert_detail = "INSERT INTO order_details (order_id, product_id, quantity, unit_price) 
                              VALUES ('$order_id', '$product_id', '$quantity', '$unit_price')";
            mysqli_query($conn, $insert_detail);
        }

        // (Tuỳ chọn) Có thể lưu thêm thông tin giao hàng phụ vào bảng khác nếu muốn

        // Xoá giỏ hàng
        unset($_SESSION['cart']);
        $_SESSION['order_id'] = $order_id;

        // Chuyển hướng hoặc thông báo đặt hàng thành công
        header("Location: ../pages/order-success.php?order_id=$order_id");
        exit();
    } else {
        echo "Lỗi khi tạo đơn hàng: " . mysqli_error($conn);
    }
}
