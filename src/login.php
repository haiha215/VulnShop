<?php
session_start();
include 'config.php'; // Gọi file kết nối CSDL

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // --- ĐÂY LÀ ĐOẠN CODE LỖI (VULNERABLE CODE) ---
    // Lỗi: Nối chuỗi trực tiếp mà không kiểm tra đầu vào
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    
    // In câu lệnh SQL ra màn hình để dễ hình dung (Debug only)
    echo "<div class='alert alert-info'>Query đang chạy: " . $sql . "</div>";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $message = "<div class='alert alert-success'>Đăng nhập thành công! Chào mừng <b>" . $row['username'] . "</b> (Quyền: " . $row['role'] . ")</div>";
    } else {
        $message = "<div class='alert alert-danger'>Sai tài khoản hoặc mật khẩu!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Login - VulnShop (SQLi)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="text-center mb-4">Đăng nhập (Có lỗi SQLi)</h2>
        <?php echo $message; ?>
        
        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="login_secure.php">Chuyển sang bản bảo mật (Secure)</a>
        </div>
    </div>
</body>
</html>