<?php
require_once "../php/baiThiDB.php";
$db = new baiThiDB("localhost", "root", "", "BaiThiDB");
$db->connectDB();

function xoaTK($matk)
{
    global $db;
    // Kiểm tra mã tk có tồn tại không 
    $checkmtk = "SELECT maTaiKhoan FROM TAIKHOAN WHERE maTaiKhoan = $matk";
    $resCheck = $db->runQuery($checkmtk);

    if ($resCheck->num_rows == 0) {
        return 0;
    } else {
        $sql = "DELETE FROM TAIKHOAN WHERE maTaiKhoan = $matk";
        $db->runQuery($sql);
        return 1;
    }
}

if (isset($_POST["submit"])) {
    $matk = $_POST["matk"];
    $isXoa = xoaTK($matk);
    if ($isXoa == 0) {
        echo "Không tìm thấy tài khoản với mã: " . $matk;
    } else {
        echo "Đã xóa thành công tài khoản: " . $matk;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="./xoatk.php" method="post" enctype="multipart/form-data">
        <label for="matk">Mã tk:</label>
        <input type="number" name="matk" id="matk">
        <input type="submit" name="submit" id="">
    </form>

    <a href="./cau3.php"><button>quay lai câu 3</button></a>
</body>


</html>