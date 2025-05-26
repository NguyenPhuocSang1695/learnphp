<?php
session_start();
require_once "../conf/shopDB.php";
$newShop = new shopDB("localhost", "root", "", "shopDB");
$newShop->connectDB();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="../css/thanhtoan.css">
</head>

<body>
    <header>
        <h1>Thanh toán</h1>
        <p>Vui lòng kiểm tra thông tin đơn hàng trước khi thanh toán.</p>
        <div class="diachigiaohang">
            <div class="luachondiachi" style="display:flex; flex-direction: column;">
                <label>
                    <input type="radio" name="radio" id="macdinh" checked> Địa chỉ mặc định
                </label>
                <label>
                    <input type="radio" name="radio" id="khac"> Địa chỉ mới
                </label>
            </div>

            <!-- Lấy thông tin từ địa chỉ mặc định của bạn hoặc nhập địa chỉ mới để giao hàng. -->
            <?php
            $sql = "SELECT * FROM user WHERE username = ?";
            $params = [$_SESSION['username']];
            $stmt = $newShop->prepareAndExecute($sql, "i", $params);
            $user = $stmt->get_result()->fetch_assoc();
            if (!$user) {
                echo "<p>Không tìm thấy thông tin người dùng.</p>";
                exit;
            }
            $defaultAddress = [
                'hovaten' => $user['username'],
                'sodienthoai' => $user['number_phone'],
                'diachi' => $user['address']
            ];
            ?>

            <div class="thongtinmacdinh" style="display:flex; flex-direction: column;">
                <label for="hovaten">Họ và tên:</label>
                <input type="text" id="hovaten" name="hovaten" value="<?php echo htmlspecialchars($defaultAddress['hovaten']); ?>" readonly>
                <label for="sodienthoai">Số điện thoại:</label>
                <input type="text" id="sodienthoai" name="sodienthoai" value="<?php echo htmlspecialchars($defaultAddress['sodienthoai']); ?>" readonly>
                <label for="diachi">Địa chỉ:</label>
                <input type="text" id="diachi" name="diachi" value="<?php echo htmlspecialchars($defaultAddress['diachi']); ?>" readonly>
            </div>

            <script>
                document.getElementById('macdinh').addEventListener('change', function() {
                    document.querySelector('.thongtinmacdinh').style.display = 'flex';
                    document.querySelector('.thongtinmoi').style.display = 'none';
                });

                document.getElementById('khac').addEventListener('change', function() {
                    document.querySelector('.thongtinmacdinh').style.display = 'none';
                    document.querySelector('.thongtinmoi').style.display = 'block';
                });
            </script>

            <div class="thongtinmoi" style="display:flex; flex-direction: column; display: none;">
                <label for="hovaten_moi">Họ và tên:</label>
                <input type="text" id="hovaten_moi" name="hovaten_moi" required>
                <label for="sodienthoai_moi">Số điện thoại:</label>
                <input type="text" id="sodienthoai_moi" name="sodienthoai_moi" required>
                <label for="diachi_moi">Địa chỉ:</label>
                <input type="text" id="diachi_moi" name="diachi_moi" required>
            </div>

            <div class="order-summary">
                <h2>Tóm tắt đơn hàng</h2>
                <?php
                // Hiển thị thông tin giỏ hàng
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    $total = 0;
                    echo "<table class='cart-table'>
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>";

                    foreach ($_SESSION['cart'] as $item) {
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                        echo "<tr>
                            <td>" . htmlspecialchars($item['product_name']) . "</td>
                            <td>" . number_format($item['price'], 0, ',', '.') . " VNĐ</td>
                            <td>" . htmlspecialchars($item['quantity']) . "</td>
                            <td>" . number_format($subtotal, 0, ',', '.') . " VNĐ</td>
                          </tr>";
                    }

                    echo "<tr class='total-row'>
                        <td colspan='3'><strong>Tổng cộng:</strong></td>
                        <td><strong>" . number_format($total, 0, ',', '.') . " VNĐ</strong></td>
                      </tr>";
                    echo "</tbody></table>";
                } else {
                    echo "<p>Giỏ hàng của bạn đang trống.</p>";
                }
                ?>
            </div>

            <div class="payment-methods">
                <h2>Phương thức thanh toán</h2>
                <form action="../php/xulithanhtoan.php" method="POST">
                    <label for="payment_method">Chọn phương thức thanh toán:</label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                        <option value="banking">Chuyển khoản ngân hàng</option>
                    </select>
                    <button type="submit" name="submit_payment">Thanh toán</button>
                </form>
                <div class="thongtinchuyenkhoan" style="width: 5    00px; display: none;">
                    <label for="bank_account"><strong>Số tài khoản: </strong> 123456</label> <br>
                    <label for="bank_name"><strong>Tên ngân hàng:</strong> ABC Bank</label> <br>
                    <label for="bank_holder"><strong>Chủ tài khoản:</strong> Nguyễn Văn A</label> <br>
                    <label for="bank_branch"><strong>Chi nhánh:</strong> Hà Nội</label> <br>
                    <label for=""><strong>Nội dung:</strong> Thanh toán đơn hàng + mã đơn hàng</label>
                </div>
    </header>
    <script>
        document.getElementById('payment_method').addEventListener('change', function() {
            const method = this.value;
            const bankInfo = document.querySelector('.thongtinchuyenkhoan');
            if (method === 'bank_transfer') {
                bankInfo.style.display = 'block';
            } else {
                bankInfo.style.display = 'none';
            }
        });
    </script>
</body>

</html>