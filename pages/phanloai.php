<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 4 Expensive Products</title>
</head>

<body>

    <h2>Top 4 Expensive Products</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
        </tr>

        <?php
        // Kết nối database
        $conn = new mysqli("localhost", "root", "", "test-db");

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Truy vấn lấy 4 sản phẩm có giá cao nhất
        $sql = "SELECT product_id, product_name, price FROM product ORDER BY price DESC LIMIT 4";
        $result = $conn->query($sql);

        $i = 1; // Biến đếm để đặt ID duy nhất cho mỗi dòng
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr id='row-$i'>";
                echo "<td id='id-$i'>" . $row["product_id"] . "</td>";
                echo "<td id='name-$i'>" . $row["product_name"] . "</td>";
                echo "<td id='price-$i'>" . number_format($row["price"], 0, ",", ".") . " VND</td>";
                echo "</tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='3'>No products found</td></tr>";
        }

        // Đóng kết nối
        $conn->close();
        ?>
    </table>

    <script>
        // Ví dụ cập nhật nội dung theo ID
        document.getElementById('id-1').style.color = 'red'; // Đổi màu chữ ID đầu tiên
        document.getElementById('name-2').style.fontWeight = 'bold'; // Làm đậm tên sản phẩm thứ 2
        document.getElementById('price-3').innerText = "Giá đặc biệt"; // Thay đổi nội dung giá thứ 3
    </script>

</body>

</html>