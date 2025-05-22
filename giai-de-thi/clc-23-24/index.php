<?php
require_once "./php/myDB.php";
$newMyDB = new myDB("localhost", "root", "", "myDB");
$newMyDB->connectDB();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Tên SP</th>
                    <th>Mô tả</th>
                    <th>Giá đề xuất</th>
                    <th>Giá bán</th>
                    <th>Số lượng tồn</th>
                    <th>Tình trạng</th>
                    <th>Hình ảnh</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dữ liệu sản phẩm sẽ được load vào đây -->
                <?php
                $query = "select * from SP where 1=1";
                $result = $newMyDB->runQuery($query);


                while ($row =  $stmt = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['masp']}</td>";
                    echo "<td>{$row['tensp']}</td>";
                    echo "<td>{$row['mota']}</td>";
                    echo "<td>" . number_format($row['giade']) . "₫</td>";
                    echo "<td>" . number_format($row['giaban']) . "₫</td>";
                    echo "<td>{$row['soluongton']}</td>";
                    echo "<td>" . ($row['tinhtrang'] == 1 ? "Còn hàng" : "Hết hàng") . "</td>";
                    echo "<td><img src='./img/{$row['hinh']}' width='100'></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="button-feature" style="margin-top: 100px">
            <a href="./pages/themsp.php"><button>Thêm sản phẩm</button></a>
        </div>
    </div>

</body>

</html>