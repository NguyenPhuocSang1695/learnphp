<?php
session_start();
require_once '../configs/connectdb.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connect_db();

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Vui lòng nhập đầy đủ thông tin.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($user['Status'] === 'Block') {
                $error = "Tài khoản đã bị khóa.";
            } elseif (password_verify($password, $user['PasswordHash'])) {
                $_SESSION['username'] = $user['Username'];
                $_SESSION['role'] = $user['Role'];
                header("Location: ../index.php"); // hoặc trang chính
                exit();
            } else {
                $error = "Mật khẩu không đúng.";
            }
        } else {
            $error = "Tài khoản không tồn tại.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- CSS  -->
    <link rel="stylesheet" href="../css/index.css">
    <!-- JS    -->
    <!-- <script src="../javascript/checkuser.js"></script> -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 30px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #2e7d32;
            margin: 0;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .checkbox-group input {
            margin-right: 10px;
        }

        .btn-login {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: 500;
        }

        .btn-login:hover {
            background-color: #388E3C;
        }

        .helper-text {
            text-align: center;
            margin-top: 20px;
        }

        .helper-text a {
            color: #4CAF50;
            text-decoration: none;
        }

        .helper-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Đăng nhập</h1>
        </div>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control"
                    placeholder="Nhập username của bạn" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu"
                    required>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Lưu mật khẩu</label>
            </div>
            <button type="submit" class="btn-login">Đăng nhập</button>
            <?php if (!empty($error)) : ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>
            <div class="helper-text">
                <a href="#">Quên mật khẩu?</a>
            </div>
        </form>
    </div>
</body>

</html>