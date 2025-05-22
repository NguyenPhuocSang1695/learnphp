<?php
require_once "../php/myDB.php";
$newDB = new myDB("localhost", "root", "", "myDB");
$newDB->connectDB();

// Xử lý upload hình ảnh 
$target_dir = "./uploads/";

$uploadOK = 1;

// Kiểm tra khi nhấn vào nút submit 
if (isset($_POST["submit"])) {
    $target_file = $target_dir . basename($_FILES["fHinh"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["fHinh"]["tmp_name"]);
    if ($check != false) {
        echo " File is mot cai anh " . $check["mime"] . ".";
        $uploadOK = 1;
    } else {
        echo "Khong phai image";
        $uploadOK = 0;
    }
    if ($uploadOK == 1) {
        if (move_uploaded_file($_FILES["fHinh"]["tmp_name"], $target_file)) {
            echo "Upload thành công: " . htmlspecialchars(basename($_FILES["fHinh"]["name"])) . ".";
        } else {
            echo "Có lỗi khi upload file.";
        }
    }
}

// Xử lý thêm sản phẩm vào database 

//   Lấy dữ liệu từ form 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $masp = $_POST["iMasp"];
    $tensp = $_POST["iTensp"];
    $mota = $_POST["iMota"];
    $giadx = $_POST["iGiadx"];
    $giaban = $_POST["iGiaban"];
    $tonkho = $_POST["iSl"];
    $tinhtrang = $_POST["selTT"];
    $hinh = basename($_FILES["fHinh"]["name"]);

    $query = "INSERT INTO SP (masp, tensp, mota, giade, giaban, soluongton, tinhtrang, hinh)
                      VALUES ('$masp', '$tensp', '$mota', '$giadx', '$giaban', '$tonkho', '$tinhtrang', '$hinh')";
    $runQuery = $newDB->runQuery($query);
    $newDB->closeDB();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        /* table, */
        tr,
        td {
            border: 1px black solid;

        }

        table {
            padding: 10px 5px;
            background-color: gainsboro;
            border-collapse: collapse;
            color: darkblue;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="./themsp.php" name="frmThemSP" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Mã sản phẩm:</td>
                    <td><input type="text" name="iMasp" id=""></td>
                </tr>


                <td>Tên sản phẩm:</td>
                <td><input type="text" name="iTensp" id=""></td>

                <tr>
                    <td>Mô tả sản phẩm:</td>
                    <td><input type="text" name="iMota" id=""></td>
                </tr>
                <tr>
                    <td>Giá đề xuất:</td>
                    <td><input type="text" name="iGiadx" id=""></td>
                </tr>
                <tr>
                    <td>Giá bán:</td>
                    <td><input type="text" name="iGiaban" id=""></td>
                </tr>
                <tr>
                    <td>Tồn kho:</td>
                    <td><input type="text" name="iSl" id=""></td>
                </tr>
                <tr>
                    <td>Tìn trạng:</td>
                    <td><select name="selTT" id="">
                            <option value="1">Hiên</option>
                            <option value=")">Ẩn</option>
                        </select></td>
                </tr>

                <tr>
                    <td>Hình ảnh:</td>
                    <td><input type="file" name="fHinh" id="fHinh"></td>
                </tr>

                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="submit" value="Thêm sản phẩm mới">
                        <input type="reset" value="Xóa form">
                    </td>

                </tr>
            </table>
        </form>
    </div>

    <script>
        let pattern = "^(?=(?:[^A-Z]*[A-Z]){3}[^A-Z]*$)(?=(?:[^a-z]*[a-z]){6}[^a-z]*$)[A-Za-z]{9}$";
    </script>
</body>

</html>