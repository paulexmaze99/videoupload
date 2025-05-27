<?php
require_once 'conn.php';

if (isset($_POST['save'])) {
    $file_name = $_FILES['video']['name'];
    $file_temp = $_FILES['video']['tmp_name'];
    $file_size = $_FILES['video']['size'];

    $max_size = 50 * 1024 * 1024; // 50MB
    $allowed_ext = array('avi', 'flv', 'wmv', 'mov', 'mp4');

    $file_info = pathinfo($file_name);
    $end = strtolower($file_info['extension']);

    if ($file_size < $max_size) {
        if (in_array($end, $allowed_ext)) {
            $name = date("Ymd") . time();
            $upload_dir = 'video/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $location = $upload_dir . $name . "." . $end;
            if (move_uploaded_file($file_temp, $location)) {
                $stmt = mysqli_prepare($conn, "INSERT INTO `video` (`video_name`, `location`) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt, "ss", $name, $location);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                echo "<script>alert('Video Uploaded'); window.location = 'index.php';</script>";
            } else {
                echo "<script>alert('Failed to upload video file.'); window.location = 'index.php';</script>";
            }
        } else {
            echo "<script>alert('Wrong video format'); window.location = 'index.php';</script>";
        }
    } else {
        echo "<script>alert('File too large to upload'); window.location = 'index.php';</script>";
    }
}
?>