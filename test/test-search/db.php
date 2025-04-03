    <?php
    $host = "localhost";
    $user = "root"; // Thay bằng user của bạn
    $password = ""; // Thay bằng mật khẩu của bạn
    $database = "webdb";

    // Kết nối MySQLi
    $conn = new mysqli($host, $user, $password, $database);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
    ?>
