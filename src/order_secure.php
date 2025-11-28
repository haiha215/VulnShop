<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Vui lòng <a href='login.php'>đăng nhập</a> trước!");
}

$order_html = "";
$debug_info = "";

// XỬ LÝ HIỂN THỊ CHI TIẾT (SECURE)
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $current_user_id = $_SESSION['user_id'];

    // CHECK QUYỀN SỞ HỮU
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $order_id, $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $order_html = "<div class='card border-success'>
                        <div class='card-header bg-success text-white'>Chi tiết đơn hàng #{$data['id']} (Secure)</div>
                        <div class='card-body'>
                            <p><strong>Sản phẩm:</strong> {$data['product_name']}</p>
                            <p><strong>Giá tiền:</strong> {$data['amount']} $</p>
                            <p><strong>Địa chỉ:</strong> {$data['shipping_address']}</p>
                        </div>
                       </div>";
    } else {
        $order_html = "<div class='alert alert-danger'>Truy cập bị từ chối! (Sai ID hoặc không chính chủ)</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Order Secure - VulnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>
    
    <h2>Đơn hàng của tôi (Secure)</h2>
    <div class="alert alert-info">
        Xin chào <strong><?php echo $_SESSION['username'] ?? 'User'; ?></strong> (ID: <?php echo $_SESSION['user_id']; ?>)
    </div>

    <div class="card mb-4">
        <div class="card-header">Danh sách đơn hàng của bạn:</div>
        <ul class="list-group list-group-flush">
            <?php
            // --- LOGIC MỚI: HIỂN THỊ ĐÚNG ĐƠN HÀNG CỦA USER ---
            $my_id = $_SESSION['user_id'];
            // Ở bản Secure, dùng Prepared Statement cho list luôn cho chuẩn
            $stmt_list = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
            $stmt_list->bind_param("i", $my_id);
            $stmt_list->execute();
            $res_list = $stmt_list->get_result();

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
    
    <div class="text-center mt-4">
        <a href="order.php" class="btn btn-outline-danger">🔴 Quay lại bản lỗi (Vulnerable)</a>
    </div>
</body>
</html>