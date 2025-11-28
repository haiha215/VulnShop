<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trợ giúp (Secure) - VulnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow border-success">
            <div class="card-header bg-success text-white">
                <h4>Trang Trợ Giúp (Secure Version)</h4>
            </div>
            <div class="card-body">
                <?php
                // --- CẤU HÌNH BẢO MẬT (WHITELIST) ---
                // KEY là cái người dùng nhập trên URL (?page=intro)
                // VALUE là tên file thực tế trên server (intro.php)
                $allowed_pages = [
                    'intro'   => 'intro.php', 
                    // 'contact' => 'contact.php' // Có thể thêm file khác nếu muốn
                ];

                // 1. Lấy tham số page. Nếu không có hoặc rỗng, mặc định là 'intro'
                $page_input = isset($_GET['page']) && $_GET['page'] !== '' ? $_GET['page'] : 'intro';

                // 2. Kiểm tra input có nằm trong danh sách cho phép không
                if (array_key_exists($page_input, $allowed_pages)) {
                    $file_to_load = $allowed_pages[$page_input];
                    
                    // 3. Kiểm tra file vật lý tồn tại rồi mới include
                    if (file_exists($file_to_load)) {
                        include($file_to_load);
                    } else {
                        echo "<div class='alert alert-warning'>
                                File <b>$file_to_load</b> chưa tồn tại trên hệ thống. 
                              </div>";
                    }
                } else {
                    // Nếu nhập linh tinh (VD: ../../etc/passwd) -> Báo lỗi ngay
                    echo "<div class='alert alert-danger'>
                            <strong>Truy cập bị chặn!</strong><br> 
                            Trang bạn yêu cầu không hợp lệ hoặc không được phép truy cập.
                          </div>";
                }
                ?>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <strong>Cơ chế bảo mật (Whitelist):</strong>
            <ul>
                <li>Hệ thống chỉ chấp nhận từ khóa: <code>intro</code></li>
                <li>Hệ thống tự động nối đuôi <code>.php</code> và gọi file nằm cùng thư mục.</li>
                <li>Link test đúng: <a href="?page=intro">?page=intro</a></li>
                <li>Link tấn công (sẽ thất bại): <a href="?page=../../etc/passwd">?page=../../etc/passwd</a></li>
            </ul>
        </div>
        
    </div>
    <div class="text-center mt-4">
    <a href="help.php?page=intro.php" class="btn btn-outline-danger">🔴 Quay lại bản lỗi (Vulnerable)</a>
</div>
</body>
</html>