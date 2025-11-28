<?php
// src/search.php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Search - VulnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>
    <h1>Tìm kiếm sản phẩm</h1>
    
    <form method="GET" action="">
        <div class="input-group mb-3">
            <input type="text" name="q" class="form-control" placeholder="Nhập tên sản phẩm...">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>

    <hr>

    <?php
    if (isset($_GET['q'])) {
        $query = $_GET['q'];

        // --- CODE LỖI (VULNERABLE) ---
        // In trực tiếp input của người dùng ra HTML
        echo "<h3>Kết quả tìm kiếm cho: " . $query . "</h3>";
        echo "<p>Không tìm thấy sản phẩm nào (Demo XSS).</p>";
    }
    ?>
    
    <div class="alert alert-info mt-5">
        <strong>Thử thách:</strong> Hãy làm hiện lên một hộp thoại cảnh báo (alert).
    </div>
    <div class="text-center mt-4">
    <a href="search_secure.php" class="btn btn-success">🟢 Chuyển sang bản bảo mật (Secure)</a>
</div>
</body>
</html>