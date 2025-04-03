<?php
require '../../configs/connectdb.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $categoryID = $_POST['categoryID'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stockQuantity'];
    $descriptionBrief = $_POST['descriptionBrief'];
    $descriptionDetail = $_POST['descriptionDetail'];

    // Handle the image upload
    $targetDir = "../../images/";  // Thư mục lưu trữ ảnh
    $imageName = basename($_FILES["imageURL"]["name"]);
    $imageURL = $targetDir . $imageName;

    // Kiểm tra xem file có hợp lệ không
    if (move_uploaded_file($_FILES["imageURL"]["tmp_name"], $imageURL)) {
        // Nếu upload thành công, tiếp tục thêm sản phẩm vào database

        // Kết nối với cơ sở dữ liệu
        $conn = connect_db();

        // Lưu đường dẫn ảnh dưới dạng đường dẫn tương đối: /images/tên_cây.jpg
        $imageRelativeURL = "/images/" . $imageName;

        // Câu lệnh SQL để thêm sản phẩm
        $sql = "INSERT INTO products (ProductName, CategoryID, Price, StockQuantity, DescriptionBrief, DescriptionDetail, ImageURL) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sdiisss", $productName, $categoryID, $price, $stockQuantity, $descriptionBrief, $descriptionDetail, $imageRelativeURL);
            $stmt->execute();
            echo "Sản phẩm đã được thêm thành công!";
            $stmt->close();
        } else {
            echo "Lỗi: " . $conn->error;
        }

        // Đóng kết nối
        $conn->close();
    } else {
        echo "Lỗi khi tải ảnh lên.";
    }
}
