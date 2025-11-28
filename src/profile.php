<?php
session_start();
include 'config.php';

$message = "";
$uploaded_file_path = "https://via.placeholder.com/150"; // Ảnh mặc định

// Xử lý Upload
if (isset($_POST['submit'])) {
    $target_dir = "uploads/";
    // Lấy tên file gốc người dùng gửi lên
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $file_name;

    // --- LỖI NGHIÊM TRỌNG (VULNERABLE) ---
    // Không kiểm tra đuôi file (extension)
    // Không kiểm tra nội dung file (MIME type)
    // Không đổi tên file (giữ nguyên tên gốc -> hacker dễ đoán đường dẫn)
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "<div class='alert alert-success'>Upload thành công! File lưu tại: <b>$target_file</b></div>";
        $uploaded_file_path = $target_file;
    } else {
        $message = "<div class='alert alert-danger'>Có lỗi khi upload file.</div>";
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
    <a href="profile_secure.php" class="btn btn-success">🟢 Chuyển sang bản bảo mật (Secure)</a>
</div>
</body>
</html>