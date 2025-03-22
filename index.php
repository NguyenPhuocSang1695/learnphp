<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS   -->
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/main.css">
    <!-- JS  -->
    <script src="./javascript/filter-product.js"></script>
    <title>Trang chủ</title>
</head>

<body>
    <header class="site-header">
        <div class="container-header">
            <h1 class="title">Chào mừng đến với web của tôi</h1>
            <p class="subtitle">Hope you have a day like a <strong>penis</strong>—hard and standing tall</p>
            <h3 id="sayHelloCustomer">Xin chào</h3>
        </div>
    </header>


    <main>
        <div class="container">
            <div class="product_type">
                <form action="./php/filter-product.php" onsubmit="filterProduct(event)" method="post">
                    <h2>Product Type</h2>
                    <select name="select-type" id="select-type" name="select-type">
                        <option value="" name="select-product-type">Chọn loại sản phẩm</option>
                        <option value="T001" name="T001">Điện thoại</option>
                        <option value="T002" name="T002">Laptop</option>
                        <option value="T003" name="T003">Đồng hồ</option>
                        <option value="T004" name="T004">Máy ảnh</option>
                    </select>
                    <button type="submit">Loc</button>
                </form>
                <div id="result-filter">Kết quả lọc hiển thị ở đây</div>
            </div>
        </div>

        <div class="button-feature">
            <a href="./test/aSearch.html"><button style="margin-top: 100px;">Tìm kiếm ở Test</button></a> <br>
            <a href="./pages/sign-up.php"><button class="signUpButton" name="signUpButton" id="signUpButton" style="margin-top: 10px;">Đăng ký</button></a> <br>
            <a href="./pages/sign-in.html"><button style="margin-top: 10px;">Đăng nhập</button></a> <br>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Về chúng tôi</h3>
                <p>Chúng tôi chuyên cung cấp các sản phẩm công nghệ chất lượng cao.</p>
            </div>
            <div class="footer-section">
                <h3>Liên hệ</h3>
                <p>Email: support@webcuatoi.com</p>
                <p>Hotline: 0123 456 789</p>
            </div>
            <div class="footer-section">
                <h3>Theo dõi chúng tôi</h3>
                <a href="https://www.facebook.com/ngphsangqypo">Facebook</a> |
                <a href="https://www.instagram.com/phuocsang16s/">Instagram</a> |
                <a href="https://tiktok.com">Tiktok</a>
            </div>
        </div>
        <p class="footer-bottom">&copy; 2025 Web của tôi. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let username = localStorage.getItem("username");
            if (username) {
                document.getElementById("sayHelloCustomer").textContent = `Xin chào ${username}`;
            }
        });
    </script>


</body>

</html>