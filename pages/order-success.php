<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Online - Website bán hàng</title>
    <!-- CSS   -->
    <link rel="stylesheet" href="../src/css/components/no-main.css">
    <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="../assets/libs/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/cart.css">
    <!-- JS   -->
    <script src="../src/js/index.js"></script>
    <script src="../assets/icons/fontawesome-free-6.7.2-web/js/all.min.js"></script>
    <script src="../assets/libs/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="../index.php">
                        <h1>Shop<span>Online</span></h1>
                    </a>
                </div>

                <div class="search-box">
                    <form action="../php/handle-search.php" method="GET">
                        <input type="text" name="searchKey" placeholder="Tìm kiếm sản phẩm...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="header-actions">
                    <div class="hotline">
                        <i class="fas fa-phone-alt"></i>
                        <span>Hotline: 0123 456 789</span>
                    </div>

                    <div class="account">
                        <a class="btn" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                            <i class="fas fa-user"></i>
                        </a>


                        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                                    <?php
                                    if (isset($_SESSION['username'])) {
                                        echo "Xin chào " . htmlspecialchars($_SESSION['username']);
                                    } else {
                                        echo "Xin vui lòng đăng nhập";
                                    }
                                    ?>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <?php if (isset($_SESSION['username'])): ?>
                                    <a href="./pages/profile.php" class="text-decoration-none">
                                        <p style="color: black;">Thông tin tài khoản</p>
                                    </a>
                                    <a href="./pages/orders.php" class="text-decoration-none">
                                        <p style="color: black;">Đơn hàng của tôi</p>
                                    </a>
                                    <a href="./php/handle-logout.php" class="text-decoration-none">
                                        <p style="color: black;">Đăng xuất</p>
                                    </a>
                                <?php else: ?>
                                    <a href="./pages/login.php" class="text-decoration-none">
                                        <p style="color: black;">Đăng nhập</p>
                                    </a>
                                    <a href="./pages/register.php" class="text-decoration-none">
                                        <p style="color: black;">Đăng ký</p>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="cart">
                        <a href="./cart.php">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="main-nav">
        <div class="container">
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
                <span>Danh mục</span>
            </div>

            <ul class="main-menu">
                <li class="menu-item"><a href="../index.php" class="active">Trang chủ</a></li>
                <li class="menu-item has-dropdown">
                    <a href="#">Sản phẩm <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown">
                        <?php
                        require_once '../conf/connectdb.php';
                        $conn = connect_db();

                        $sql = "select * from product_types";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<li><a href="../pages/product-list.php?type_id=' . $row['type_id'] . '">' . $row['type_name'] . '</a></li>';
                            }
                        } else {
                            echo "Lỗi truy vấn: " . mysqli_error($conn);
                        }
                        ?>
                    </ul>
                </li>
                <li class="menu-item"><a href="#">Khuyến mãi</a></li>
                <li class="menu-item"><a href="#">Tin tức</a></li>
                <li class="menu-item"><a href="#">Giới thiệu</a></li>
                <li class="menu-item"><a href="#">Liên hệ</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content Placeholder -->
    <main class="main-content">
        <!-- Banner Section -->
        <section class="banner-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="main-banner">
                            <img src="../assets/images/khonggianxanhbanner.jpg" alt="Cây cảnh đẹp">
                            <div class="banner-content">
                                <h2>Không gian xanh cho ngôi nhà của bạn</h2>
                                <p>Đa dạng các loại cây cảnh, cây nội thất và phụ kiện trang trí</p>
                                <a href="#" class="btn btn-primary">Khám phá ngay</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-banner mb-4">
                            <img src="../assets/images/caynoithatbanner.jpg" alt="Cây nội thất">
                            <div class="banner-content">
                                <h3>Cây nội thất</h3>
                                <a href="#">Xem thêm</a>
                            </div>
                        </div>
                        <div class="sub-banner">
                            <img src="../assets/images/phukientrangtribanner.jpg" alt="Phụ kiện trang trí">
                            <div class="banner-content">
                                <h3>Phụ kiện trang trí</h3>
                                <a href="#">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- CART   -->
        <section class="order-success">
            <?php
            $order_id = $_GET['order_id'];

            // Lấy thông tin đơn hàng + khách
            $sql_order = "SELECT o.*, c.first_name, c.last_name, c.phone, c.address 
              FROM orders o
              JOIN customers c ON o.username = c.username
              WHERE o.order_id = '$order_id'";
            $result_order = mysqli_query($conn, $sql_order);
            $order = mysqli_fetch_assoc($result_order);

            // Lấy chi tiết đơn hàng
            $sql_details = "SELECT od.*, p.name 
                FROM order_details od
                JOIN products p ON od.product_id = p.product_id
                WHERE od.order_id = '$order_id'";
            $result_details = mysqli_query($conn, $sql_details);
            ?>
            <div class="container mt-5 mb-5">
                <div class="card shadow-lg p-4">
                    <h2 class="text-center text-success mb-4">Hóa Đơn Đơn Hàng</h2>

                    <div class="mb-3">
                        <strong>Mã đơn hàng:</strong> <?php echo $order['order_id']; ?><br>
                        <strong>Khách hàng:</strong> <?php echo $order['first_name'] . ' ' . $order['last_name']; ?><br>
                        <strong>Số điện thoại:</strong> <?php echo $order['phone']; ?><br>
                        <strong>Địa chỉ:</strong> <?php echo $order['address']; ?><br>
                        <strong>Ngày đặt:</strong> <?php echo $order['order_date']; ?><br>
                        <strong>Thanh toán:</strong> <?php echo $order['payment_method']; ?>
                    </div>

                    <hr>

                    <h5 class="text-success">Chi tiết đơn hàng</h5>
                    <table class="table table-bordered mt-3">
                        <thead class="table-success">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            while ($row = mysqli_fetch_assoc($result_details)) {
                                $subtotal = $row['quantity'] * $row['unit_price'];
                                $total += $subtotal;
                                echo "<tr>
                  <td>{$row['name']}</td>
                  <td>{$row['quantity']}</td>
                  <td>" . number_format($row['unit_price'], 0, ',', '.') . " đ</td>
                  <td>" . number_format($subtotal, 0, ',', '.') . " đ</td>
                </tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Tổng cộng:</th>
                                <th><?php echo number_format($total, 0, ',', '.') . " đ"; ?></th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="text-center mt-4">
                        <a href="index.php" class="btn btn-success">Về trang chủ</a>
                        <button onclick="window.print()" class="btn btn-outline-success">In hóa đơn</button>
                    </div>

                </div>
            </div>


        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="footer-top">
                    <div class="footer-column">
                        <h3>Về chúng tôi</h3>
                        <p>Shop Online - Nơi cung cấp các sản phẩm chất lượng với giá cả phải chăng, dịch vụ tận tâm và uy tín hàng đầu.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                    <div class="footer-column">
                        <h3>Thông tin liên hệ</h3>
                        <ul class="contact-info">
                            <li><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</li>
                            <li><i class="fas fa-phone"></i> 0123 456 789</li>
                            <li><i class="fas fa-envelope"></i> info@shoponline.com</li>
                        </ul>
                    </div>

                    <div class="footer-column">
                        <h3>Hỗ trợ khách hàng</h3>
                        <ul class="footer-links">
                            <li><a href="#">Hướng dẫn mua hàng</a></li>
                            <li><a href="#">Chính sách đổi trả</a></li>
                            <li><a href="#">Chính sách bảo hành</a></li>
                            <li><a href="#">Phương thức thanh toán</a></li>
                            <li><a href="#">Phương thức vận chuyển</a></li>
                        </ul>
                    </div>

                    <div class="footer-column">
                        <h3>Đăng ký nhận tin</h3>
                        <p>Nhận thông tin khuyến mãi mới nhất từ Shop Online</p>
                        <form class="newsletter-form">
                            <input type="email" placeholder="Email của bạn">
                            <button type="submit">Đăng ký</button>
                        </form>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; 2025 Shop Online. Tất cả quyền được bảo lưu.</p>
                    <div class="payment-methods">
                        <img style="width: 100%; height: 145px" src="../assets/images/pmmt.png" alt="Phương thức thanh toán">
                    </div>
                </div>
            </div>
        </footer>

        <script src="script.js"></script>
        <script>
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const form = this.closest('form');
                    const formData = new FormData(form);

                    fetch('../php/update_cart.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Cập nhật cart-count
                                const cartCount = document.querySelector('.cart-count');
                                if (cartCount) {
                                    cartCount.textContent = data.total_items;
                                }
                            }
                        });
                });
            });

            // Thêm đoạn code này vào phần script ở cuối file
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const cartItem = this.closest('.cart-item');

                    const formData = new FormData();
                    formData.append('product_id', productId);

                    fetch('../php/remove_from_cart.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Xóa phần tử khỏi DOM
                                cartItem.remove();

                                // Cập nhật cart-count
                                const cartCount = document.querySelector('.cart-count');
                                if (cartCount) {
                                    cartCount.textContent = data.total_items;
                                }

                                // Nếu giỏ hàng rỗng
                                if (data.total_items === 0) {
                                    document.querySelector('.cart-items').innerHTML = "Giỏ hàng rỗng.";
                                }

                                // Cập nhật tổng tiền
                                location.reload(); // Tạm thời reload để cập nhật tổng tiền
                            }
                        });
                });
            });
        </script>
</body>

</html>