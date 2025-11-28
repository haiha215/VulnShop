<?php
include 'config.php';

// Tự động tạo bảng comments nếu chưa có
$conn->query("CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50),
    comment_text TEXT
)");

// Xử lý khi người dùng gửi bình luận
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $comment = $_POST['comment'];
    
    // --- LỖI: Lưu trực tiếp vào DB không lọc ---
    // (Ở đây dùng Prepared Statement để tránh SQLi, NHƯNG vẫn dính XSS vì nội dung script được lưu nguyên vẹn)
    $stmt = $conn->prepare("INSERT INTO comments (user_name, comment_text) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $comment);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sản phẩm - VulnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>
    <div class="row">
        <div class="col-md-4">
            <img src="https://via.placeholder.com/300" class="img-fluid" alt="Product">
        </div>
        <div class="col-md-8">
            <h2>iPhone 15 Fake (Siêu cấp VIP)</h2>
            <p class="text-danger">Giá: $150.00</p>
            <p>Mô tả: Hàng giống thật 99%, chạy Android giao diện iOS.</p>
        </div>
    </div>

    <hr>
    
    <h4>Đánh giá sản phẩm</h4>
    <form method="POST" action="" class="mb-4">
        <div class="mb-2">
            <input type="text" name="user" class="form-control" placeholder="Tên của bạn" required>
        </div>
        <div class="mb-2">
            <textarea name="comment" class="form-control" placeholder="Viết bình luận..." required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Gửi đánh giá</button>
    </form>

    <div class="list-group">
        <?php
        $sql = "SELECT * FROM comments ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='list-group-item'>";
                echo "<strong>" . $row["user_name"] . ":</strong><br>";

                // --- VÁ LỖI (SECURE) ---
                echo htmlspecialchars($row["comment_text"], ENT_QUOTES, 'UTF-8');
                
                echo "</div>";
            }
        }
        ?>
    </div>
    <div class="text-center mt-4 mb-5">
    <a href="product.php" class="btn btn-outline-danger">🔴 Quay lại bản lỗi (Vulnerable)</a>
</div>
</body>
</html>