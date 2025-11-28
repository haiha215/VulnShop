<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>VulnShop - Pentest Lab Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-header { font-weight: bold; text-transform: uppercase; }
        .vuln-card { transition: transform 0.2s; }
        .vuln-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
    </style>
</head>
<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-4 text-primary">🛡️ VulnShop Laboratory</h1>
            <p class="lead">Môi trường giả lập các lỗ hổng Web phổ biến nhất.</p>
            <div class="badge bg-<?php echo $conn ? 'success' : 'danger'; ?> p-2">
                Database Status: <?php echo $conn ? 'CONNECTED' : 'DISCONNECTED'; ?>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-md-4">
                <div class="card h-100 vuln-card border-danger">
                    <div class="card-header bg-danger text-white">1. SQL Injection</div>
                    <div class="card-body">
                        <h5 class="card-title">Bypass Đăng nhập</h5>
                        <p class="card-text">Lỗi kinh điển cho phép hacker đăng nhập mà không cần mật khẩu.</p>
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="login.php" class="btn btn-outline-danger">🔴 Demo Lỗi (Vulnerable)</a>
                            <a href="login_secure.php" class="btn btn-outline-success">🟢 Demo Vá (Secure)</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 vuln-card border-warning">
                    <div class="card-header bg-warning text-dark">2. Reflected XSS</div>
                    <div class="card-body">
                        <h5 class="card-title">Thanh Tìm kiếm</h5>
                        <p class="card-text">Mã độc JavaScript phản xạ lại ngay lập tức từ input của người dùng.</p>
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="search.php" class="btn btn-outline-danger">🔴 Demo Lỗi (Vulnerable)</a>
                            <a href="search_secure.php" class="btn btn-outline-success">🟢 Demo Vá (Secure)</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 vuln-card border-warning">
                    <div class="card-header bg-warning text-dark">3. Stored XSS</div>
                    <div class="card-body">
                        <h5 class="card-title">Bình luận Sản phẩm</h5>
                        <p class="card-text">Mã độc được lưu vĩnh viễn vào Database, ảnh hưởng mọi người xem.</p>
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="product.php" class="btn btn-outline-danger">🔴 Demo Lỗi (Vulnerable)</a>
                            <a href="product_secure.php" class="btn btn-outline-success">🟢 Demo Vá (Secure)</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 vuln-card border-info">
                    <div class="card-header bg-info text-dark">4. IDOR</div>
                    <div class="card-body">
                        <h5 class="card-title">Xem trộm Đơn hàng</h5>
                        <p class="card-text">Tham chiếu đối tượng không an toàn. Đổi ID trên URL để xem dữ liệu người khác.</p>
                        <p class="small text-muted">*Yêu cầu: Phải đăng nhập trước.</p>
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="order.php" class="btn btn-outline-danger">🔴 Demo Lỗi (Vulnerable)</a>
                            <a href="order_secure.php" class="btn btn-outline-success">🟢 Demo Vá (Secure)</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 vuln-card border-dark">
                    <div class="card-header bg-dark text-white">5. File Upload (RCE)</div>
                    <div class="card-body">
                        <h5 class="card-title">Upload Avatar</h5>
                        <p class="card-text">Upload file Web Shell (.php) để chiếm quyền điều khiển Server.</p>
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="profile.php" class="btn btn-outline-danger">🔴 Demo Lỗi (Vulnerable)</a>
                            <a href="profile_secure.php" class="btn btn-outline-success">🟢 Demo Vá (Secure)</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 vuln-card border-secondary">
                    <div class="card-header bg-secondary text-white">6. Local File Inclusion (LFI)</div>
                    <div class="card-body">
                        <h5 class="card-title">Include file động</h5>
                        <p class="card-text">Lợi dụng hàm include để đọc file hệ thống hoặc file config nhạy cảm.</p>
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="help.php?page=intro.php" class="btn btn-outline-danger">🔴 Demo Lỗi</a>
                            <a href="help_secure.php?page=intro" class="btn btn-outline-success">🟢 Demo Vá</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 vuln-card border-danger">
                    <div class="card-header bg-danger text-white">7. PHP Object Injection</div>
                    <div class="card-body">
                        <h5 class="card-title">Insecure Deserialization</h5>
                        <p class="card-text">Lợi dụng Magic Methods của Class có sẵn để ghi file shell.</p>
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="promo.php" class="btn btn-outline-danger">🔴 Demo Lỗi</a>
                            <a href="promo_secure.php" class="btn btn-outline-success">🟢 Demo Vá</a>
                        </div>
                    </div>
                </div>
            </div>

        </div> <footer class="mt-5 text-center text-muted">
            <p>&copy; 2024 VulnShop Project. Built for Educational Purpose.</p>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>