<?php
session_start();
include 'config.php';

// 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    die("Vui lòng <a href='login.php'>đăng nhập</a> trước!");
}

// 2. Tự động tạo dữ liệu giả (Chạy 1 lần là có data)
$conn->query("CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_name VARCHAR(100),
    amount DECIMAL(10,2),
    shipping_address VARCHAR(255)
)");

// Kiểm tra nếu bảng rỗng thì thêm 2 đơn hàng mẫu
$conn->query("CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_name VARCHAR(100),
    amount DECIMAL(10,2),
    shipping_address VARCHAR(255)
)");
$check = $conn->query("SELECT count(*) as total FROM orders");
if ($check->fetch_assoc()['total'] == 0) {
    $conn->query("INSERT INTO orders (user_id, product_name, amount, shipping_address) VALUES (1, 'Bí mật Quốc gia', 999999, 'Tòa Bạch Ốc, USA')");
    $conn->query("INSERT INTO orders (user_id, product_name, amount, shipping_address) VALUES (2, 'Ốp lưng điện thoại', 50, '123 Đường Láng, Hà Nội')");
}

// XỬ LÝ HIỂN THỊ CHI TIẾT ĐƠN HÀNG (LỖI IDOR)
$order_html = "";
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    // LỖI: Không check user_id
    $sql = "SELECT * FROM orders WHERE id = $order_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $order_html = "<div class='card border-danger'>
                        <div class='card-header bg-danger text-white'>Chi tiết đơn hàng #{$data['id']}</div>
                        <div class='card-body'>
                            <p><strong>Sản phẩm:</strong> {$data['product_name']}</p>
                            <p><strong>Giá tiền:</strong> {$data['amount']} $</p>
                            <p><strong>Địa chỉ:</strong> {$data['shipping_address']}</p>
                            <p class='text-muted'>(Owner ID: {$data['user_id']})</p>
                        </div>
                       </div>";
    } else {
        $order_html = "<div class='alert alert-warning'>Không tìm thấy đơn hàng!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Order - VulnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>
    
    <h2>Đơn hàng của tôi</h2>
    <div class="alert alert-info">
        Xin chào <strong><?php echo $_SESSION['username'] ?? 'User'; ?></strong> (ID: <?php echo $_SESSION['user_id']; ?>)
    </div>

    <div class="card mb-4">
        <div class="card-header">Danh sách đơn hàng của bạn:</div>
        <ul class="list-group list-group-flush">
            <?php
            // HIỂN THỊ ĐÚNG ĐƠN HÀNG CỦA USER ---
            $my_id = $_SESSION['user_id'];
            $sql_list = "SELECT * FROM orders WHERE user_id = $my_id";
            $res_list = $conn->query($sql_list);

            if ($res_list->num_rows > 0) {
                while($row = $res_list->fetch_assoc()) {
                    echo "<li class='list-group-item'>
                            <a href='?id={$row['id']}'>Đơn hàng #{$row['id']} - {$row['product_name']}</a>
                          </li>";
                }
            } else {
                echo "<li class='list-group-item text-muted'>Bạn chưa có đơn hàng nào.</li>";
            }
            ?>
        </ul>
    </div>

    <?php echo $order_html; ?>
    
    <div class="mt-3 p-3 bg-light border">
        <strong>Thử thách:</strong> Bạn hãy thử đổi số ID trên URL để xem đơn của người khác. 
        (Ví dụ: Admin có đơn hàng số 1).
    </div>
    
    <div class="text-center mt-4">
        <a href="order_secure.php" class="btn btn-success">🟢 Chuyển sang bản bảo mật (Secure)</a>
    </div>
</body>
</html>