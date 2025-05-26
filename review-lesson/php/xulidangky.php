<?php
session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $tendn = $_POST["username"];
    $matkhau = $_POST["password"];
    $email = $_POST["email"];

    // Kiểm tra username đã tồn tại chưa
    $check_sql = "SELECT * FROM user WHERE username = '$tendn'";
    $check_res = $newShop->runQuery($check_sql);

    if ($check_res->num_rows > 0) {
        // Username đã tồn tại
        echo "Tên đăng nhập đã tồn tại, vui lòng chọn tên khác.";
        header("Location: ../pages/dangky.php");
        // Bạn có thể redirect hoặc xử lý hiển thị thông báo khác
    } else {
        // Chèn dữ liệu mới vào database
        $insert_sql = "INSERT INTO user (username, password, email) VALUES ('$tendn', '$matkhau', '$email')";
        $insert_res = $newShop->runQuery($insert_sql);

        if ($insert_res) {
            $_SESSION["username"] = $tendn;
            header("Location: ../pages/dangnhap.php");
            exit();
        } else {
            echo "Đăng ký thất bại, vui lòng thử lại.";
            header("Location: ../pages/dangky.php");
        }
    }
}

// Dùng prepare 
/* 
<?php
session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $tendn = $_POST["username"];
    $matkhau = $_POST["password"];
    $email  = $_POST["email"];

    // Kiểm tra username đã tồn tại chưa — dùng prepared statement
    $check_sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $newShop->prepareAndExecute($check_sql, "s", [$tendn]);
    $stmt->store_result(); // để kiểm tra num_rows

    if ($stmt->num_rows > 0) {
        // Username đã tồn tại
        $stmt->close();
        echo "Tên đăng nhập đã tồn tại, vui lòng chọn tên khác.";
        header("Location: ../pages/dangky.php");
        exit();
    } else {
        $stmt->close();

        // Mã hóa mật khẩu trước khi lưu
        $hashed_password = password_hash($matkhau, PASSWORD_DEFAULT);

        // Chèn dữ liệu mới — dùng prepared statement
        $insert_sql = "INSERT INTO user (username, password, email) VALUES (?, ?, ?)";
        $insert_stmt = $newShop->prepareAndExecute($insert_sql, "sss", [$tendn, $hashed_password, $email]);

        if ($insert_stmt) {
            $_SESSION["username"] = $tendn;
            $insert_stmt->close();
            header("Location: ../pages/dangnhap.php");
            exit();
        } else {
            echo "Đăng ký thất bại, vui lòng thử lại.";
            header("Location: ../pages/dangky.php");
            exit();
        }
    }
}

*/
