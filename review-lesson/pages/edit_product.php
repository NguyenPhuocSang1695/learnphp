<?php
session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();
$id = $_GET['id'];
$sql = "SELECT * FROM product WHERE product_id = $id";
$res = $newShop->runQuery($sql);
$row = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="../css/edit_product.css">
</head>

<body>
    <h2>Chỉnh sửa sản phẩm: <?php echo $row['product_name']; ?></h2>
    <form action="../php/xulisuasp.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
        Tên sản phẩm: <input type="text" name="product_name" value="<?php echo $row['product_name']; ?>"><br>
        Giá: <input type="text" name="price" value="<?php echo $row['price']; ?>"><br>
        Phân loại: <select name="sPl" id="sPl" required>
            <option value="">-- Xin vui lòng chọn sản phẩm --</option>
            <?php
            $sqll = "select * from category";
            $spl = $newShop->runQuery($sqll);
            while ($roww = $spl->fetch_assoc()) {
                echo "<option value= '" . $roww["category_id"] . "'>" . $roww["category_name"] . "</option>";
            }
            ?>
        </select> <br>
        Nhà sản xuất: <select name="sNsx" id="sNsx">
            <option value="">-- Xin vui lòng chọn nhà sản xuất --</option>
            <?php
            $sqlnsx = "select * from manufacturer";
            $resnsx = $newShop->runQuery($sqlnsx);
            while ($rownsx = $resnsx->fetch_assoc()) {
                echo "<option value= '" . $rowrownsxw["manufacturer_id"] . "'>" . $rownsx["manufacturer_name"] . "</option>";
            }
            ?>
        </select>

        <br>
        Hình ảnh:
        <input type="file" name="image" onchange="document.getElementById('hinhanh').src = window.URL.createObjectURL(this.files[0])"><br>

        <!-- Ảnh hiện tại của sản phẩm -->
        <img id="hinhanh" src="../img/<?php echo $row['imageURL']; ?>" style="max-width: 150px; margin-top:10px;"><br>

        <button type="submit" name="update">Cập nhật</button>
    </form>


    <a href="../index.php" style="text-decoration: none;">
        <button>
            Quay về trang chủ
        </button>
    </a>
    <script src="../js/pageReload.js"></script>
</body>

</html>