<?php
$servername = "localhost:3309";
$username = "root";
$password = "";
$dbname = "humg_blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

?>