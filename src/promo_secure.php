<?php
session_start();
include 'config.php';

// --- CLASS LOG FILE ---
// Chúng ta vẫn giữ Class này để chứng minh: 
// Dù trong hệ thống có Class nguy hiểm, nhưng nếu dùng JSON thì Hacker không thể chạm vào nó.
class LogFile {
    public $filename = 'logs.txt';
    public $content = 'Log access';
    
    public function __destruct() {
        // Trong thực tế, hàm này có thể ghi file.
        // Ở bản Secure, hàm này KHÔNG BAO GIỜ được kích hoạt bởi input của user.
        // file_put_contents($this->filename, $this->content); 
    }
}

$message = ""; // Biến chứa thông báo kết quả

if (isset($_GET['data'])) {
    // --- CODE VÁ (SECURE) ---
    // Thay vì dùng unserialize(), ta dùng json_decode()
    // json_decode chỉ phân tích cú pháp chuỗi văn bản, KHÔNG khởi tạo Object.
    $data = json_decode($_GET['data'], true); 
    
    if ($data) {
        // Nếu giải mã JSON thành công
        // Lấy dữ liệu an toàn để hiển thị (chống XSS luôn cho chắc)
        $safe_content = htmlspecialchars($data['content'] ?? 'unknown');
        
        $message = "<div class='alert alert-success'>
                        <strong>Đã xử lý chuỗi JSON an toàn!</strong><br>
                        Dữ liệu nhận được: $safe_content <br>
                        <i>(Không có Object nào được khởi tạo, Class LogFile không chạy).</i>
                    </div>";
    } else {
        // Nếu dữ liệu không phải JSON hợp lệ (ví dụ hacker gửi chuỗi serialize cũ)
        $message = "<div class='alert alert-danger'>
                        <strong>Lỗi:</strong> Dữ liệu không hợp lệ (Bắt buộc phải là định dạng JSON).
                    </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Promo (Secure) - VulnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow border-success">
            <div class="card-header bg-success text-white">
                <h4>Kiểm tra Mã Khuyến Mãi (Secure Version)</h4>
            </div>
            <div class="card-body">
                <p>Phiên bản này sử dụng <code>json_decode()</code> thay vì <code>unserialize()</code>.</p>
                <p>Hacker không thể lợi dụng lỗ hổng Object Injection để điều khiển Class <code>LogFile</code>.</p>
                
                <?php echo $message; ?>

                <hr>
                <h5>Kịch bản kiểm thử (Verification):</h5>
                
                <p><strong>1. Thử tấn công bằng Payload cũ (Serialize):</strong></p>
                <div class="bg-light p-2 border mb-2">
                    <code>?data=O:7:"LogFile"...</code>
                </div>
                <p>➔ <span class="text-success">Kết quả mong đợi:</span> Hệ thống báo lỗi "Dữ liệu không hợp lệ".</p>

                <p><strong>2. Thử nhập dữ liệu hợp lệ (JSON):</strong></p>
                <div class="bg-light p-2 border mb-2">
                    <code>?data={"content": "Hello World"}</code>
                </div>
                <p>➔ <span class="text-success">Kết quả mong đợi:</span> Hệ thống báo thành công và hiển thị nội dung.</p>
            </div>
        </div>
        
    </div>
    <div class="text-center mt-4">
    <a href="promo.php" class="btn btn-outline-danger">🔴 Quay lại bản lỗi (Vulnerable)</a>
</div>
</body>
</html>