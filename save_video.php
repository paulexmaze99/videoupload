<?php
require_once 'conn.php';

if (isset($_POST['save'])) {
    $file_name = $_FILES['video']['name'];
    $file_temp = $_FILES['video']['tmp_name'];
    $file_size = $_FILES['video']['size'];

    $max_size = 50 * 1024 * 1024; // 50MB max
    $allowed_ext = ['mp4', 'mov', 'avi', 'flv', 'wmv'];

    $file_info = pathinfo($file_name);
    $extension = strtolower($file_info['extension']);

    if ($file_size > $max_size) {
        echo "<script>alert('❌ File too large. Max 50MB allowed.'); window.location='videos.php';</script>";
        exit;
    }

    if (!in_array($extension, $allowed_ext)) {
        echo "<script>alert('❌ Invalid file type. Allowed: mp4, mov, avi, flv, wmv'); window.location='videos.php';</script>";
        exit;
    }

    $unique_name = date("Ymd") . "_" . time();
    $upload_dir = 'video/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $location = $upload_dir . $unique_name . "." . $extension;

    if (move_uploaded_file($file_temp, $location)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO video (video_name, location) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $unique_name, $location);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "<script>alert('✅ Video uploaded successfully!'); window.location='videos.php';</script>";
    } else {
        echo "<script>alert('❌ Failed to move uploaded file.'); window.location='videos.php';</script>";
    }
} else {
    echo "<script>window.location='videos.php';</script>";
}
?>
