<?php
session_start();
include 'config.php';

// --- CLASS LỖI (VULNERABLE GADGET) ---
class LogFile {
    public $filename = 'logs.txt';
    public $content = 'Log access';

    public function __destruct() {
        // Tạo file khi object bị hủy
        file_put_contents($this->filename, $this->content);
    }
}

$message = "";
if (isset($_GET['data'])) {
    // LỖI: Unserialize dữ liệu không tin cậy
    $obj = unserialize($_GET['data']);
    $message = "<div class='alert alert-success'>Dữ liệu đã được xử lý (Object đã được tạo)! Kiểm tra folder code xem có file lạ không.</div>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Promo - VulnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow border-danger">
            <div class="card-header bg-danger text-white">
                <h4>Kiểm tra Mã Khuyến Mãi (PHP Object Injection)</h4>
            </div>
            <div class="card-body">
                <p>Hệ thống này sử dụng Class <code>LogFile</code> để ghi log tự động.</p>
                <div class="alert alert-warning">
                    <strong>Nhiệm vụ:</strong> Hãy tạo ra một file <code>shell.php</code> bằng cách gửi một Object độc hại.
                </div>
                
                <?php echo $message; ?>

                <hr>
                <p>Payload mẫu (Tạo file test.txt):</p>
                <code>?data=O:7:"LogFile":2:{s:8:"filename";s:8:"test.txt";s:7:"content";s:12:"Hack Success";}</code>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
    <a href="promo_secure.php" class="btn btn-success">🟢 Chuyển sang bản bảo mật (Secure)</a>
</div>
</body>
</html>