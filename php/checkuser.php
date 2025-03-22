<?php
session_start();
include("../database/database.php");
header("Content-Type: application/json"); // JSON response

// Hiển thị lỗi PHP để debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

    if (empty($username) || empty($password)) {
        echo json_encode(["message" => "Missing login information", "status" => 0]);
        exit();
    }

    // Kiểm tra kết nối database
    if (!$conn) {
        echo json_encode(["message" => "Database connection failed: " . mysqli_connect_error(), "status" => 0]);
        exit();
    }

    // Prepared Statement để tránh SQL Injection
    $sql = "SELECT username, password FROM customer WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo json_encode(["message" => "Query preparation failed: " . mysqli_error($conn), "status" => 0]);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        echo json_encode(["message" => "Query execution failed: " . mysqli_error($conn), "status" => 0]);
        exit();
    }

    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo json_encode(["message" => "User not found", "status" => 0]);
    } elseif (password_verify($password, $row["password"])) {
        echo json_encode(["message" => "Incorrect password", "status" => 0]);
    } else {
        $_SESSION["username"] = $username;
        echo json_encode(["message" => "Login successful", "status" => 1, "username" => $username]);
    }

    // Đóng kết nối
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
