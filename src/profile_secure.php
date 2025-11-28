<?php
session_start();
include 'config.php';

$message = "";
$uploaded_file_path = "https://via.placeholder.com/150"; // Ảnh mặc định

if (isset($_POST['submit'])) {
    $target_dir = "uploads/";
    
    // 1. Kiểm tra đuôi file (Extension Whitelist)
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_ext = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    
    if (!in_array($file_ext, $allowed_extensions)) {
        die("<div class='alert alert-danger'>Chỉ cho phép file ảnh (JPG, PNG, GIF)!</div>");
    }

    // 2. Kiểm tra MIME Type (Nội dung thực của file)
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check === false) {
        die("<div class='alert alert-danger'>File không phải là ảnh thật!</div>");
    }

    // 3. Đổi tên file ngẫu nhiên (Tránh bị đoán tên hoặc ghi đè, và tránh thực thi file .php)
    // Tên mới = md5(thời gian) + đuôi file gốc
    $new_filename = md5(time() . basename($_FILES["fileToUpload"]["name"])) . "." . $file_ext;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "<div class='alert alert-success'>Upload AN TOÀN thành công!</div>";
        $uploaded_file_path = $target_file;
    } else {
        $message = "<div class='alert alert-danger'>Lỗi server.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Profile - VulnShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php include 'navbar.php'; ?>
    <h2>Hồ sơ người dùng</h2>
    <div class="row">
        <div class="col-md-4 text-center">
            <img src="<?php echo $uploaded_file_path; ?>" class="img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
        </div>
        <div class="col-md-8">
            <h4>Đổi ảnh đại diện</h4>
            <?php echo $message; ?>
            
            <form action="" method="post" enctype="multipart/form-data" class="card p-4 bg-light">
                <div class="mb-3">
                    <label class="form-label">Chọn ảnh:</label>
                    <input type="file" name="fileToUpload" class="form-control" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Upload Avatar</button>
            </form>
            
            <div class="alert alert-warning mt-3">
                <strong>Thử thách Hacker:</strong> Hãy upload một file <code>shell.php</code> để chiếm quyền điều khiển server này!
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
    <a href="profile.php" class="btn btn-outline-danger">🔴 Quay lại bản lỗi (Vulnerable)</a>
</div>
</body>
</html>