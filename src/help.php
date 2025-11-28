<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trợ giúp - VulnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h4>Trang Trợ Giúp (LFI Demo)</h4>
            </div>
            <div class="card-body">
                <?php
                // Code xử lý LFI
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    
                    // Kiểm tra file có tồn tại không trước khi include để tránh lỗi Warning xấu xí
                    // Lưu ý: Hacker vẫn có thể bypass check này
                    if (file_exists($page)) {
                        include($page);
                    } else {
                        echo "<div class='alert alert-danger'>Lỗi: Không tìm thấy file <b>$page</b></div>";
                    }
                } else {
                    echo "<p>Chào mừng đến trung tâm trợ giúp.</p>";
                }
                ?>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <strong>Hướng dẫn test:</strong>
            <ul>
                <li>Chạy đúng: <code>?page=intro.php</code> </li>
                <li>Tấn công LFI (Đọc file hệ thống): <code>?page=../../../../etc/passwd</code></li>
    
            </ul>
        </div>
    </div>
<div class="text-center mt-4">
    <a href="help_secure.php?page=intro" class="btn btn-success">🟢 Chuyển sang bản bảo mật (Secure)</a>
</div>
</body>
</html>