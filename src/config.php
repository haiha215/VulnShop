<?php
// Thông tin kết nối database
// LƯU Ý: Trong Docker, servername là tên service trong docker-compose ("db"), KHÔNG phải "localhost"
$servername = "db"; 
$username = "root";
$password = "root";
$dbname = "vulnshop";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>