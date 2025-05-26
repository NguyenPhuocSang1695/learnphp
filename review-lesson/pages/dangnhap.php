<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../css/dangnhap.css">
    <style>

    </style>
</head>

<body>
    <div class="container">
        <form action="../php/xulidangnhap.php" method="post" enctype="multipart/form-data">
            <h2>Đăng nhập</h2>
            <div class="tendangnhao">
                <label for="txttendn">Tên đăng nhập:</label>
                <input type="text" name="txttendn" id="txttendn">
            </div>
            <br>
            <div class="matkhau">
                <label for="pmk">Mật khẩu</label>
                <input type="password" name="pmk" id="pmk">
            </div>
            <br>
            <input type="submit" name="submitdn" id="submitdn">
        </form>
    </div>
</body>

</html>