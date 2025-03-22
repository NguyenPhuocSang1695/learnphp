    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS  -->
        <link rel="stylesheet" href="../css/sign-up.css">
        <link rel="stylesheet" href="../libs/bootstrap-5.3.3-dist/css/bootstrap.min.css">
        <title>Learn Php</title>
    </head>

    <body>
        <?php
        ?>
        <div class="container">
            <h1>Sign Up</h1>
            <form action="../php/handle.php" method="post">
                <label for="">username</label>
                <input type="text" name="username" id="username" required>
                <br>
                <label for="">password</label>
                <input type="password" name="" id="password" required>
                <br>
                <label for="">Địa chỉ</label>
                <input type="text" name="address" id="address" required>
                <br>
                <label for="">Số điện thoại</label>
                <input type="text" name="numberphone" id="numberphone" required>
                <br>
                <button type="submit" class="btn btn-primary signUpButton">Sign Up</button>
            </form>
        </div>
        <script src="./javascript/handle.js"></script>
    </body>

    </html>