<?php
require '../../configs/connectdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $categoryID = $_POST['categoryID'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $attribute = $_POST['attribute'];
    $levelDifficulty = $_POST['levelDifficulty'];

    // Giá trị mặc định
    $status = 1; // ví dụ: 1 = hiển thị, 0 = ẩn
    $isPurchase = 0; // 0 = chưa được mua

    // Xử lý ảnh
    $targetDir = "../../assets/images/";
    $imageName = basename($_FILES["imageURL"]["name"]);
    $imageURL = $targetDir . $imageName;

    if (move_uploaded_file($_FILES["imageURL"]["tmp_name"], $imageURL)) {
        $conn = connect_db();

        // Đường dẫn ảnh lưu trong DB (đường dẫn tương đối)
        $imageRelativeURL = "/assets/images/" . $imageName;

        $sql = "INSERT INTO products
                (ProductName, CategoryID, Price, Description, ImageURL, Status, Attribute, LevelDifficulty, IsPurchase)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param(
                "sidssisii",
                $productName,
                $categoryID,
                $price,
                $description,
                $imageRelativeURL,
                $status,
                $attribute,
                $levelDifficulty,
                $isPurchase
            );

            if ($stmt->execute()) {
                echo "✅ Sản phẩm đã được thêm thành công!";
            } else {
                echo "❌ Lỗi khi thêm sản phẩm: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "❌ Lỗi chuẩn bị SQL: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "❌ Lỗi khi tải ảnh lên.";
    }
}
