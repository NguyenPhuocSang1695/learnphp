<?php
// Kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdb"; // Thay bằng tên database thực tế của bạn

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Nhận category_id từ URL
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Truy vấn database
$sql = "SELECT ProductName, DescriptionBrief, Price, ImageURL FROM products WHERE CategoryID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../libs/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <title>Kết quả lọc sản phẩm</title>
</head>

<body>
    <div class="container mt-4">
        <h2>Danh sách sản phẩm</h2>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="<?= htmlspecialchars($row['ImageURL']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['ProductName']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['ProductName']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($row['DescriptionBrief']) ?></p>
                            <p class="card-text"><strong>Giá:</strong> <?= number_format($row['Price']) ?> VNĐ</p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>