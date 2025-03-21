<?php
session_name("MySession");
session_start();

$_SESSION["test"] = "Session đang hoạt động!";
if (isset($_SESSION["test"])) {
    echo "okay!<br>";
} else {
    echo "Session không hoạt động!";
}
