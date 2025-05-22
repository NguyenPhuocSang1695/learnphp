<?php
require_once "./php/baiThiDB.php";
$newBaiThi = new baiThiDB("localhost", "root", "", "baithidb");
$newBaiThi->connectDB();
if (isset($_GET["success"])) {
    if ($_GET["success"] == 1) {
        echo "<script>alert('Thêm sản phẩm thành công!');</script>";
    } else {
        echo "<script>alert('Thêm sản phẩm thất bại!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        tr,
        td {
            border: 1px black solid;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="./php/xulythemsp.php" name="frmthemsp" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td colspan="2" align="center">Quản lí sản phẩm</td>
                </tr>
                <tr>
                    <td>Công ty sản xuất:</td>
                    <td><select name="cbocongtysx" id="">
                            <option value="0"> Xin mời chọn công ty</option>
                            <?php
                            // Tạo câu lệnh truy vấn 
                            $sql = "select tenNSX, maNhaSanXuat from nhasanxuat";
                            $res = $newBaiThi->runQuery($sql);

                            while ($row = $res->fetch_assoc()) {
                                echo '<option value="' . $row["maNhaSanXuat"] . '"> ' . $row["tenNSX"] . '</option>';
                            }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td>Nhập tên sản phẩm:</td>
                    <td><input type="text" name="txttensp" id=""></td>
                </tr>
                <tr>
                    <td>Nhập giá chính thức:</td>
                    <td><input type="text" name="txtgia" id=""></td>
                </tr>
                <tr>
                    <td>Nhập giá đã được giảm:</td>
                    <td><input type="text" name="txtgiagiam" id=""></td>
                </tr>
                <tr>
                    <td>Nhập mô tả</td>
                    <td><textarea name="txtareamota" id=""></textarea></td>
                </tr>
                <tr>
                    <td>Hình đại diện:</td>
                    <td><input type="file" name="f_daidien" id=""></td>
                </tr>

                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="" id="" value="Thêm sản phẩm">
                    </td>
                </tr>
            </table>
        </form>

        <a href="./pages/cau3.php">
            <button>Câu 3</button>
        </a>
    </div>
</body>

</html>