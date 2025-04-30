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
    <link rel="stylesheet" href="../src/css/product-detail.css">
    <!-- JS   -->
    <script src="../src/js/index.js"></script>
    <script src="../assets/icons/fontawesome-free-6.7.2-web/js/all.min.js"></script>
    <script src="../assets/libs/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div classz="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="../index.php">
                        <h1>Shop<span>Online</span></h1>
                    </a>
                </div>

                <div class="search-box">
                    <form action="#" method="get">
                        <input type="text" placeholder="Tìm kiếm sản phẩm...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="header-actions">
                    <div class="hotline">
                        <i class="fas fa-phone-alt"></i>
                        <span>Hotline: 0123 456 789</span>
                    </div>

                    <div class="account">
                        <a href="#"><i class="fas fa-user"></i> Tài khoản</a>
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
                <li class="menu-item"><a href="index.php" class="active">Trang chủ</a></li>
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

        <!-- Detail products Section -->
        <section class="product-detail-section">
            <?php
            require_once '../conf/connectdb.php';
            $conn = connect_db();

            if (isset($_GET['id'])) {
                $id = mysqli_real_escape_string($conn, $_GET['id']); // Tránh SQL injection
                $sql = "SELECT * FROM products WHERE product_id = '$id'";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    // Tính toán giá sau giảm giá
                    $originalPrice = $row['price'];
                    $discount = $row['discount']; // Giả sử discount được lưu dưới dạng phần trăm (ví dụ: 22)
                    $discountedPrice = $originalPrice * (100 - $discount) / 100;

                    echo '<div class="container py-5">
                    <div class="row">
                        <!-- Product Simple Display -->
                        <div class="col-md-6">
                            <div class="product-image">
                                <img src="../assets/images/' . $row['image'] . '" alt="' . $row['name'] . '" class="img-fluid">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="product-info">
                                <h1 class="product-title mb-4">' . $row['name'] . '</h1>
                                <div class="product-price mb-4">';

                    // Chỉ hiển thị giảm giá nếu có
                    if ($discount > 0) {
                        echo '<span class="current-price">' . number_format($discountedPrice, 0, ',', '.') . ' đ</span>
                              <span class="old-price">' . number_format($originalPrice, 0, ',', '.') . ' đ</span>
                              <span class="discount-badge">-' . $discount . '%</span>';
                    } else {
                        echo '<span class="current-price">' . number_format($originalPrice, 0, ',', '.') . ' đ</span>';
                    }

                    echo '</div>
                                <div class="product-button">
                                    <button class="btn btn-primary add-to-cart">Thêm vào giỏ hàng</button>
                                    <button class="btn btn-secondary buy-now">Mua ngay</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                } else {
                    echo '<div class="container py-5">
                            <div class="alert alert-warning">
                                Không tìm thấy sản phẩm
                            </div>
                          </div>';
                }
            } else {
                echo '<div class="container py-5">
                        <div class="alert alert-warning">
                            Không có ID sản phẩm được cung cấp
                        </div>
                      </div>';
            }
            ?>
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
                        <img src="/api/placeholder/120/30" alt="Phương thức thanh toán">
                    </div>
                </div>
            </div>
        </footer>

        <script src="script.js"></script>
</body>

</html>