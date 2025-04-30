<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="../src/css/sign-up.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

</head>

<body>
    <div class="signup-container">
        <h1>Đăng ký tài khoản</h1>
        <p>Vui lòng điền thông tin bên dưới để tạo tài khoản</p>
        <form action="../php/handle.php" method="post">
            <div class="input-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" name="username" id="username" required />
            </div>
            <div class="input-group">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" id="password" required />
            </div>
            <div class="input-group">
                <label for="address">Địa chỉ</label>
                <input type="text" name="address" id="address" required />
            </div>
            <div class="input-group">
                <label for="numberphone">Số điện thoại</label>
                <input type="text" name="numberphone" id="numberphone" required />
            </div>
            <button type="submit" class="signUpButton">Đăng ký</button>
        </form>
        <div class="login-link">
            Đã có tài khoản? <a href="./sign-in.html">Đăng nhập</a>
        </div>
    </div>
</body>

</html>