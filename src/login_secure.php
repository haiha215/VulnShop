<?php
session_start();
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // --- ĐÂY LÀ CODE AN TOÀN (SECURE CODE) ---
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");

    // In câu lệnh SQL và parameters ra màn hình để dễ hình dung (Debug only)
    echo "<div class='alert alert-info'>Query đang chạy: SELECT * FROM users WHERE username = ? AND password = ?<br>";
    echo "<strong>Parameters:</strong> username='$username', password='$password'</div>";

    // Bind dữ liệu vào dấu ? (s = string)
    // Database sẽ hiểu đây là DỮ LIỆU thuần túy, không phải LỆNH SQL
    $stmt->bind_param("ss", $username, $password);
    
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $message = "<div class='alert alert-success'>Đăng nhập AN TOÀN thành công! Xin chào <b>" . $row['username'] . "</b></div>";
    } else {
        $message = "<div class='alert alert-danger'>Sai tài khoản hoặc mật khẩu!</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Login Secure - VulnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="text-center mb-4 text-success">Đăng nhập (Đã vá lỗi)</h2>
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
                    <button type="submit" class="btn btn-success w-100">Đăng nhập an toàn</button>
                </form>
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="login.php" class="text-danger">Quay lại bản lỗi (Vulnerable)</a>
        </div>
    </div>
</body>
</html>