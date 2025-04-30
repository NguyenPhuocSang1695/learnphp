<?php
function connect_db()
{
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "learnphp";

    // Create connection
    $conn = new mysqli($server, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
