<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="../css/dangky.css">
</head>

<body>
    <div class="form-container">
        <h2>Đăng Ký</h2>
        <form action="../php/xulidangky.php" method="post" id="formRegister">
            <div class="form-group">
                <label for="username">Tên người dùng:</label>
                <input type="text" id="username" name="username" maxlength="50" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" maxlength="100" required>
            </div>

            <div class="form-group">
                <label for="number_phone">Số điện thoại: </label>
                <input type="tel" id="number_phone" name="number_phone" maxlength="11" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" name="address" maxlength="100" required>
            </div>
            <button type="submit" name="submit">Đăng Ký</button>
        </form>

        <a href="../index.php">
            <button>Quay lại trang chủ</button>
        </a>
    </div>
    <script src="../js/pageReload.js"></script>
</body>

</html>