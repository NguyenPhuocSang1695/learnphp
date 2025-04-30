<?php
session_start();
require_once '../configs/connectdb.php';

$conn = connect_db();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin.";
    header("Location: ../html/login.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM users WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if ($user['Status'] === 'Block') {
        $_SESSION['error'] = "Tài khoản đã bị khóa.";
        header("Location: ../html/login.php");
        exit();
    }

    if (password_verify($password, $user['PasswordHash'])) {
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['Role'];
        header("Location: ../html/dashboard.php"); // hoặc trang chính
        exit();
    } else {
        $_SESSION['error'] = "Mật khẩu không đúng.";
        header("Location: ../html/login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Tài khoản không tồn tại.";
    header("Location: ../html/login.php");
    exit();
}
