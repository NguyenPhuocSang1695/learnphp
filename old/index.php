<?php
session_start();
$username = $_SESSION['username'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS   -->
    <link rel="stylesheet" href="./src/css/footer.css">
    <link rel="stylesheet" href="./src/css/header.css">
    <link rel="stylesheet" href="./src/css/main.css">
    <!-- JS  -->
    <script src="./javascript/filter-product.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Trang chủ</title>
</head>

<body>
    <header class="site-header">
        <div class="container-header">
            <h1 class="title">Chào mừng đến với web của tôi</h1>
            <p class="subtitle">Hope you have a day like a <strong>penis</strong>—hard and standing tall</p>
            <h3 id="sayHelloCustomer">
                <?php if ($username): ?>
                    Xin chào <strong><?= htmlspecialchars($username) ?></strong>!
                <?php else: ?>
                    Xin chào, vui lòng <a href="login.php">đăng nhập</a>.
                <?php endif; ?>
            </h3>

        </div>
    </header>


    <main class="bg-gray-100 min-h-screen py-10">
        <div class="container mx-auto max-w-4xl bg-white rounded-2xl shadow-xl p-8 space-y-10">

            <!-- Bộ lọc sản phẩm -->
            <section class="text-center">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Lọc theo loại sản phẩm</h2>
                <form method="post" class="space-y-4">
                    <select name="select-type" id="select-type"
                        class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php
                        require_once './configs/connectdb.php';
                        $conn = connect_db();

                        $sql = $conn->prepare("SELECT CategoryID, CategoryName FROM categories ORDER BY CategoryID ASC");
                        $sql->execute();
                        $result = $sql->get_result();

                        echo "<option value=''>Chọn loại sản phẩm</option>";
                        while ($row = $result->fetch_assoc()) {
                            $selected = (isset($_POST['select-type']) && $_POST['select-type'] == $row['CategoryID']) ? 'selected' : '';
                            echo "<option value='" . $row['CategoryID'] . "' $selected>" . $row['CategoryName'] . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all">Lọc</button>
                </form>
                <div id="result-filter" class="mt-4 p-4 bg-gray-100 rounded-lg text-gray-700 text-left">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['select-type']) && $_POST['select-type'] !== '') {
                        $selectedType = $_POST['select-type'];
                        $stmt = $conn->prepare("SELECT ProductName, ProductID FROM products WHERE CategoryID = ?");
                        $stmt->bind_param("i", $selectedType);
                        $stmt->execute();
                        $results = $stmt->get_result();

                        if ($results->num_rows > 0) {
                            while ($row = $results->fetch_assoc()) {
                                echo "<p>" . $row['ProductName'] . "</p>";
                            }
                        } else {
                            echo "<p>Không có sản phẩm thuộc loại này.</p>";
                        }
                    }
                    ?>
                    Kết quả lọc hiển thị ở đây
                </div>
            </section>

            <!-- Tìm kiếm sản phẩm -->

            <section>
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Tìm kiếm sản phẩm</h2>
                <div class="flex gap-3">
                    <form id="searchForm" method="get">
                        <input id="searchInput" name="searchInput" type="text" placeholder="Nhập tên sản phẩm..."
                            class="flex-1 px-4 py-3 border rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <input type="submit" id="searchButton" name="searchButton" placeholder="Tìm
                        kiếm"
                            class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all"></input>
                    </form>
                </div>
            </section>


            <!-- Các nút tính năng -->
            <section class="text-center">
                <a href="./pages/sign-up.php">
                    <button
                        class="px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all mt-3">
                        Đăng ký
                    </button>
                </a>
                <a href="./pages/sign-in.php">
                    <button
                        class="px-6 py-3 bg-gray-700 text-white rounded-xl hover:bg-gray-800 transition-all mt-3 ml-3">
                        Đăng nhập
                    </button>
                </a>
            </section>

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