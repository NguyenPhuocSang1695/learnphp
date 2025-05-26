<?php
session_start();
require_once "./conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();

$totalQuantity = 0;
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $item) {
        $totalQuantity += $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="./css/index.css">
    <!-- <link rel="stylesheet" href="./css/cart-on-num.css"> -->

</head>

<body>
    <header>
        <h1>Chào mừng đến với cửa hàng của chúng tôi!</h1>

        <?php if (isset($_SESSION["username"])): ?>
            <div class="user-greeting">
                👋 Xin chào <?php echo $_SESSION['username']; ?>!
            </div>
        <?php else: ?>
            <div class="guest-greeting">
                Xin chào quý khách, xin vui lòng đăng nhập!
            </div>
        <?php endif; ?>

        <div class="header-controls">
            <div class="auth-buttons">
                <?php if (isset($_SESSION["username"])): ?>
                    <a href='./php/xulydangxuat.php'>
                        <button>Đăng xuất</button>
                    </a>
                    <a href='./pages/personal.php'>
                        <button>Thông tin KH</button>
                    </a>
                <?php else: ?>
                    <a href='./pages/dangnhap.php'>
                        <button>Đăng nhập</button>
                    </a>
                    <a href='./pages/dangky.php'>
                        <button>Đăng ký</button>
                    </a>
                <?php endif; ?>
            </div>

            <div class="cart">
                <a href="./pages/giohang.php">
                    <button>🛒</button>
                    <p class="soluongsp"><?php echo htmlspecialchars($totalQuantity) ?></p>
                </a>
            </div>
        </div>
    </header>
    <!-- Lọc theo phân loại  -->
    <section>
        <h2>Phân loại sản phẩm</h2>
        <form action="index.php" method="get">
            <select name="category_id">
                <option value="">-- Tất cả --</option>
                <?php
                $sql = "SELECT * FROM category where 1=1 group by category_id order by category_id desc";
                $res = $newShop->runQuery($sql);
                while ($row = $res->fetch_assoc()) {
                    // Nếu có GET category_id thì giữ trạng thái selected
                    $selected = (isset($_GET['category_id']) && $_GET['category_id'] == $row['category_id']) ? 'selected' : '';
                    echo "<option value='" . $row['category_id'] . "' $selected>" . $row['category_name'] . "</option>";
                }
                ?>
            </select>
            <button type="submit" name="submitloc">Lọc</button>
        </form>

        <div class="kqloc">
            <?php
            if (isset($_GET['category_id']) || isset($_GET['page'])) {
                // Số sản phẩm mỗi trang
                $limit = 5;

                // Trang hiện tại (mặc định là 1)
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                if ($page < 1) $page = 1;

                // Tính offset
                $offset = ($page - 1) * $limit;

                // Lọc sản phẩm theo category nếu có
                if (isset($_GET['category_id']) && $_GET['category_id'] != "") {
                    $cat_id = $_GET['category_id'];
                    $sqlCount = "SELECT COUNT(*) as total FROM product WHERE category_id = '$cat_id'";
                    $sqlProducts = "SELECT * FROM product WHERE category_id = '$cat_id' LIMIT $limit OFFSET $offset";
                } else {
                    $sqlCount = "SELECT COUNT(*) as total FROM product";
                    $sqlProducts = "SELECT * FROM product LIMIT $limit OFFSET $offset";
                }

                // Tổng số sản phẩm để tính số trang
                $resCount = $newShop->runQuery($sqlCount);
                $rowCount = $resCount->fetch_assoc();
                $totalProducts = $rowCount['total'];
                $totalPages = ceil($totalProducts / $limit);

                // Lấy sản phẩm trang hiện tại
                $resProducts = $newShop->runQuery($sqlProducts);

                // Hiển thị bảng
                echo "<table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Ảnh sản phẩm</th>
            </tr>
        </thead>
        <tbody>";

                $stt = $offset + 1;
                while ($product = $resProducts->fetch_assoc()) {
                    echo "<tr>
            <td>$stt</td>
            <td>{$product['product_name']}</td>
            <td>" . number_format($product['price'], 0,  ',', ".") . " VNĐ</td>
            <td><img style='max-width: 150px' src='./img/{$product["imageURL"]}'></td>
          </tr>";
                    $stt++;
                }

                echo "</tbody></table>";

                // Hiển thị nút phân trang
                echo "<div class='pagination'>";
                for ($i = 1; $i <= $totalPages; $i++) {
                    // Ghi nhớ category_id nếu đang lọc
                    $categoryParam = isset($_GET['category_id']) ? "&category_id=" . $_GET['category_id'] : "";

                    if ($i == $page) {
                        echo "<strong>$i</strong> ";
                    } else {
                        echo "<a href='?page=$i$categoryParam'>$i</a> ";
                    }
                }
                echo "</div>";
            }
            ?>
        </div>

    </section>

    <!-- Tìm kiếm  -->
    <section>
        <form action="./php/xulitimkiem.php" method="post">
            <h2>Tìm kiếm</h2>
            <input type="text" name="txttimkiem" id="txttimkiem">
            <button type="submit" name="tk">🔍</button>
        </form>

        <section>
            <h2>Kết quả tìm kiếm</h2>
            <?php
            // Kiểm tra xem có kết quả tìm kiếm trong session không
            if (isset($_SESSION['ketquatimkiem'])) {
                $limit = 5;
                $page = isset($_GET['pagetk']) ? (int)$_GET['pagetk'] : 1;
                if ($page < 1) $page = 1;

                $offset = ($page - 1) * $limit;

                // Lấy mảng sản phẩm từ session
                $ketqua = $_SESSION['ketquatimkiem'];

                // Lấy phần tử cho trang hiện tại (phân trang bằng array_slice)
                $hienthi = array_slice($ketqua, $offset, $limit);

                echo "<table border='1' cellpadding='8' cellspacing='0' style='width: 100%; border-collapse: collapse; text-align: center;'>";
                echo "<thead>
            <tr >
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Giá (VNĐ)</th>
                <th>Ảnh</th>
            </tr>
          </thead>";
                echo "<tbody>";

                $stt = $offset + 1;
                foreach ($hienthi as $product) {
                    echo "<tr onclick=\"window.location='./pages/chitietsanpham.php?product_id={$product['product_id']}'\" style='cursor: pointer;'>";
                    echo "<td>" . $stt++ . "</td>";
                    echo "<td>" . htmlspecialchars($product['product_name']) . "</td>";
                    echo "<td>" . number_format($product['price']) . "</td>";
                    echo "<td><img src='./img/" . htmlspecialchars($product['imageURL']) . "' style='max-width:100px'></td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";

                // Hiển thị phân trang
                $totalPage = $_SESSION['timkiem_totalPage'];

                echo "<div class='pagination' style='margin-top: 15px; text-align: center;'>";
                for ($i = 1; $i <= $totalPage; $i++) {
                    if ($i == $page) {
                        echo "<strong style='padding:5px 10px; margin: 0 3px; background:#333; color:#fff; border-radius: 3px;'>$i</strong>";
                    } else {
                        echo "<a href='?pagetk=$i' style='padding:5px 10px; margin: 0 3px; border:1px solid #333; border-radius: 3px; text-decoration:none; color:#333;'>$i</a>";
                    }
                }
                echo "</div>";
            } else {
                echo "<p>Không có kết quả tìm kiếm.</p>";
            }

            ?>
        </section>
    </section>


    <!-- Thêm sp  -->
    <section>
        <h2>Thêm sản phẩm mới</h2>
        <form action="./php/xulithemsp.php" method="post" enctype="multipart/form-data">
            <label for="product_name">Tên sản phẩm:</label><br>
            <input type="text" name="product_name" id="product_name" required><br><br>

            <label for="price">Giá:</label><br>
            <input type="number" name="price" id="price" min="0" required><br><br>

            <label for="category_id">Loại sản phẩm:</label><br>
            <select name="category_id" id="category_id" required>
                <option value="">-- Chọn loại sản phẩm --</option>
                <?php
                $sql = "SELECT * FROM category";
                $res = $newShop->runQuery($sql);
                while ($row = $res->fetch_assoc()) {
                    echo "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
                }
                ?>
            </select><br><br>

            <label for="manufacturer_id">Nhà sản xuất:</label><br>
            <select name="manufacturer_id" id="manufacturer_id" required>
                <option value="">-- Chọn nhà sản xuất --</option>
                <?php
                $sqlManu = "SELECT * FROM manufacturer";
                $resManu = $newShop->runQuery($sqlManu);
                while ($manu = $resManu->fetch_assoc()) {
                    echo "<option value='" . $manu['manufacturer_id'] . "'>" . $manu['manufacturer_name'] . "</option>";
                }
                ?>
            </select><br><br>

            <label for="hinh">Ảnh:</label>
            <img id="img" style="max-width: 150px;">
            <input type="file" name="anh" id="" onchange="img.src = window.URL.createObjectURL(this.files[0])">

            <button type="submit">Thêm sản phẩm</button>
        </form>
    </section>


    <section>
        <h2>Chỉnh sửa sản phẩm</h2>
        <form action="./php/xulisuasp.php" method="post" enctype="multipart/form-data">
            <div class="chinhsua-sp">
                <?php
                $sql = "SELECT * FROM product GROUP BY product_id ORDER BY product_id DESC";
                $res = $newShop->runQuery($sql);

                while ($row = $res->fetch_assoc()) {
                    echo "<div>";
                    echo "<strong>" . $row["product_name"] . "</strong>";
                    echo " - <input type='hidden' name='product_id' value='" . $row["product_id"] . "'>";
                    echo " <a href='./pages/edit_product.php?id=" . $row["product_id"] . "'>Chỉnh sửa</a>";
                    echo "</div>";
                }
                ?>
            </div>
        </form>
    </section>


</body>

</html>