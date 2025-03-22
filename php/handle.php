<?php
include("../database/database.php");
header("Content-Type: application/json"); // Định dạng JSON
session_start();
$response = ["isLogin" => false]; // Mặc định chưa đăng nhập
// Kiểm tra nếu form được gửi bằng POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
    $numberphone = isset($_POST["numberphone"]) ? trim($_POST["numberphone"]) : "";
    $address = isset($_POST["address"]) ? trim($_POST["address"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Chuẩn bị truy vấn
    $sql = $conn->prepare("INSERT INTO customer (username, numberphone, address, password) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $username, $numberphone, $address, $hashed_password);

    // Thực thi truy vấn
    if ($sql->execute()) {
        $_SESSION["islogin"] = true;
        $response["isLogin"] = true;
        setcookie("islogin", "true", time() + (3 * 24 * 60 * 60), "/");
        header("Location: ../pages/sign-in.html");
        echo json_encode(["message" => "New record created successfully"]);
    } else {
        echo json_encode(["error" => $sql->error]);
        $isLogin = false;
    }

    // Đóng kết nối
    $sql->close();
    $conn->close();
} else {
    $isLogin = false;
    echo json_encode(["error" => "No data received"]);
}
