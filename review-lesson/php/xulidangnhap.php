<?php
ini_set('session.gc_maxlifetime', 10800);
// Set cookie session tồn tại trong 3 tiếng
session_set_cookie_params(10800);

session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();


if (isset($_POST["submitdn"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $tendn = $_POST["txttendn"];
    $matkhau = $_POST["pmk"];

    $sql = "select * from user where username = '$tendn'";
    $result = $newShop->runQuery($sql);
    $row = $result->fetch_assoc();

    if ($row) {
        if (password_verify($matkhau, $row["password"])) {
            $_SESSION["username"] = $row["username"];
            header("Location: ../index.php");
        } else {
            echo "
            <script>
            alert ('Sai mật khẩu');
            window.location.href = '../pages/dangnhap.php';
            </script>
            ";
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

if (isset($_POST["submitdn"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $tendn   = $_POST["txttendn"];
    $matkhau = $_POST["pmk"];

    // Dùng prepared statement để lấy thông tin user
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $newShop->prepareAndExecute($sql, "s", [$tendn]);

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // So sánh mật khẩu nhập với mật khẩu đã hash trong database
        if (password_verify($matkhau, $row["password"])) {
            $_SESSION["username"] = $row["username"];
            $stmt->close();
            header("Location: ../index.php");
            exit();
        } else {
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Tài khoản không tồn tại!";
    }

    $stmt->close();
}
?>

*/
