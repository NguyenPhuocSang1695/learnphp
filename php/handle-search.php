<?php
session_start();
require_once '../conf/connectdb.php';

$conn = connect_db();

if (isset($_GET['searchKey'])) {
    $searchTerm = mb_strtolower(trim($_GET['searchKey']), 'UTF-8');

    $sql = "SELECT p.product_id as id, p.name, p.price, p.image 
            FROM products p 
            LEFT JOIN product_types pt ON p.type_id = pt.type_id
            WHERE LOWER(p.name) LIKE ? 
            OR LOWER(p.description) LIKE ?
            OR LOWER(pt.type_name) LIKE ?";

    $stmt = mysqli_prepare($conn, $sql);
    $searchPattern = "%{$searchTerm}%";
    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $searchPattern,
        $searchPattern,
        $searchPattern
    );
    mysqli_stmt_execute($stmt);

    $_SESSION['search_result'] = mysqli_stmt_get_result($stmt)->fetch_all(MYSQLI_ASSOC) ?: [];
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
header('Location: ../pages/search-result.php');
exit();
