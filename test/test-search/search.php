<?php
header("Content-Type: application/json");
include "./db.php"; // Kết nối database

$query = isset($_GET["q"]) ? trim($_GET["q"]) : "";

if ($query) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE ProductName LIKE ?");
    $searchTerm = "%$query%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();

    $result = $stmt->get_result();
    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
    $stmt->close();
} else {
    echo json_encode([]);
}

$conn->close();
