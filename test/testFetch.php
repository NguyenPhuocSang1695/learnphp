<?php
header("Content-Type: application/json");
session_start();

$response = ["isLogin" => isset($_SESSION['user'])]; // Kiểm tra đăng nhập
echo json_encode($response);
