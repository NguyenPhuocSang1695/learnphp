<?php
session_start();

require_once '../conf/connectdb.php';
$conn =  connect_db();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM customers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose a different one.";
        exit;
    }

    // Insert new user into the database
    $stmt = $conn->prepare("INSERT INTO customers (username, first_name, last_name, password, email, phone, address) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt->bind_param(
        "sssssss",
        $username,
        $first_name,
        $last_name,
        $hashed_password,
        $email,
        $phone,
        $address
    );

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Đăng ký thành công!";
        header('Location: ../index.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
