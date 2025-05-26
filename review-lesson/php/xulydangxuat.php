<?php
session_start(); // Bắt buộc có trước khi unset/destroy session

session_unset();    // Xóa hết các biến session
session_destroy();  // Hủy session

header("Location: ../pages/dangnhap.php");
exit();
