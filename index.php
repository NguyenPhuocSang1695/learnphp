<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Online - Website bán hàng</title>
    <!-- CSS   -->
    <link rel="stylesheet" href="./src/css/index.css">
    <link rel="stylesheet" href="./assets/icons/fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="./assets/libs/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- JS   -->
    <script src="./src/js/index.js"></script>
    <script src="./assets/icons/fontawesome-free-6.7.2-web/js/all.min.js"></script>
    <script src="./assets/libs/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div classz="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="index.php">
                        <h1>Shop<span>Online</span></h1>
                    </a>
                </div>

                <div class="search-box">
                    <form action="./php/handle-search.php" method="GET">
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
                        <a href="./pages/cart.php">
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
                        require_once './conf/connectdb.php';
                        $conn = connect_db();

                        $sql = "select * from product_types";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<li><a href="./pages/product-list.php?type_id=' . $row['type_id'] . '">' . $row['type_name'] . '</a></li>';
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
                            <img src="./assets/images/khonggianxanhbanner.jpg" alt="Cây cảnh đẹp">
                            <div class="banner-content">
                                <h2>Không gian xanh cho ngôi nhà của bạn</h2>
                                <p>Đa dạng các loại cây cảnh, cây nội thất và phụ kiện trang trí</p>
                                <a href="#" class="btn btn-primary">Khám phá ngay</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-banner mb-4">
                            <img src="./assets/images/caynoithatbanner.jpg" alt="Cây nội thất">
                            <div class="banner-content">
                                <h3>Cây nội thất</h3>
                                <a href="#">Xem thêm</a>
                            </div>
                        </div>
                        <div class="sub-banner">
                            <img src="./assets/images/phukientrangtribanner.jpg" alt="Phụ kiện trang trí">
                            <div class="banner-content">
                                <h3>Phụ kiện trang trí</h3>
                                <a href="#">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="categories-section">
            <div class="container">
                <div class="section-title">
                    <h2>Danh mục sản phẩm</h2>
                </div>
                </a>
                <div class="categories-main">
                    <?php
                    require_once './conf/connectdb.php';
                    $conn = connect_db();

                    $sql = "select * from product_types join products on product_types.type_id = products.type_id group by product_types.type_id limit 4";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<a href="">';
                            echo '<div class="col-lg-3 col-md-4 col-6">';
                            echo '<div class="category-item">';
                            echo '<img src="./assets/images/' . $row['image'] . '" alt="' . $row['type_name'] . '">';
                            echo '<h3>' . $row['type_name'] . '</h3>';
                            echo '<a href="./pages/product-list.php?type_id=' . $row['type_id'] . '" class="btn-view">Xem ngay</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Featured Products Section -->
        <section class="products-section">
            <div class="container">
                <div class="section-title">
                    <h2>Sản phẩm nổi bật</h2>
                </div>
                <div class="row">

                    <?php
                    require_once './conf/connectdb.php';
                    $conn = connect_db();

                    $sql = "select * from products limit 4";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {


                            echo '<div class="col-lg-3 col-md-4 col-6">';
                            echo '<a href="./pages/product-detail.php?id=' . $row['product_id'] . '">';
                            echo '<div class="product-card">';
                            echo '<div class="product-image">';
                            echo '<img src="./assets/images/' . $row['image'] . '" alt="' . $row['name'] . '">';

                            echo '<div class="product-tags">';
                            echo '<span class="tag-new">Mới</span>';
                            echo '</div>';
                            echo '<div class="product-actions">';
                            echo '<a href="#" class="btn-quickview"><i class="fas fa-eye"></i></a>';
                            echo '<a href="#" class="btn-wishlist"><i class="fas fa-heart"></i></a>';
                            echo '<a href="#" class="btn-add-cart"><i class="fas fa-shopping-cart"></i></a>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="product-info">';
                            echo '<h3 class="product-name"><a href="#">' . $row['name'] . '</a></h3>';
                            echo '<div class="product-price">';
                            echo '<span class="price">' . number_format($row['price'], 0, ',', '.') . '₫</span>';
                            if ($row['price']) {
                                echo '<span class="price-old">' . number_format($row['price'], 0, ',', '.') . '₫</span>';
                            }
                            echo '</div>';
                            echo '<div class="product-rating">';
                            echo '<i class="fas fa-star"></i>';

                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</a>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
                <div class="text-center mt-4">
                    <a href="./pages/all-products.php" class="btn btn-outline-primary">Xem tất cả sản phẩm</a>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="benefits-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Giao hàng miễn phí</h4>
                                <p>Cho đơn hàng từ 500.000₫</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Đổi trả dễ dàng</h4>
                                <p>Trong vòng 7 ngày</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Bảo hành cây</h4>
                                <p>Chăm sóc tận tâm</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Hỗ trợ 24/7</h4>
                                <p>Tư vấn chăm sóc cây</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Section -->
        <section class="blog-section">
            <div class="container">
                <div class="section-title">
                    <h2>Kiến thức về cây cảnh</h2>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="blog-item">
                            <div class="blog-image">
                                <img src="./assets/images/cachchamsoccay.jpg" alt="Cách chăm sóc cây">
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="far fa-calendar-alt"></i> 25/04/2025</span>
                                    <span><i class="far fa-comment"></i> 12</span>
                                </div>
                                <h3><a href="#">Hướng dẫn chăm sóc cây cảnh trong nhà hiệu quả</a></h3>
                                <p>Những mẹo đơn giản để chăm sóc cây cảnh trong nhà luôn xanh tốt và phát triển khỏe mạnh.</p>
                                <a href="#" class="read-more">Đọc tiếp <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="blog-item">
                            <div class="blog-image">
                                <img src="./assets/images/cayphongthuy.jpg" alt="Cây cảnh phong thủy">
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="far fa-calendar-alt"></i> 20/04/2025</span>
                                    <span><i class="far fa-comment"></i> 8</span>
                                </div>
                                <h3><a href="#">Top 10 cây cảnh phong thủy thích hợp cho văn phòng</a></h3>
                                <p>Những loại cây cảnh không chỉ đẹp mắt mà còn mang lại may mắn và tài lộc cho không gian làm việc.</p>
                                <a href="#" class="read-more">Đọc tiếp <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="blog-item">
                            <div class="blog-image">
                                <img src="./assets/images/senda.jpg" alt="Sen đá">
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="far fa-calendar-alt"></i> 15/04/2025</span>
                                    <span><i class="far fa-comment"></i> 15</span>
                                </div>
                                <h3><a href="#">Bí quyết trồng sen đá và xương rồng cho người mới bắt đầu</a></h3>
                                <p>Những bước cơ bản để bắt đầu trồng và chăm sóc các loại cây mọng nước một cách dễ dàng.</p>
                                <a href="#" class="read-more">Đọc tiếp <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
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
                        <img src="/api/placeholder/120/30" alt="Phương thức thanh toán">
                    </div>
                </div>
            </div>
        </footer>

        <script src="script.js"></script>
</body>

</html>