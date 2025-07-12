<?php
if (isset($_POST['save']) && isset($_FILES['video']) && $_FILES['video']['error'] === 0) {
    $file_name = $_FILES['video']['name'];
    $file_temp = $_FILES['video']['tmp_name'];
    $file_size = $_FILES['video']['size'];

    if ($file_size < 50000000) { // 50MB
        $end = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['avi', 'flv', 'wmv', 'mov', 'mp4'];
        $allowed_mime = ['video/mp4', 'video/x-flv', 'video/x-msvideo', 'video/quicktime', 'video/x-ms-wmv'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file_temp);
        finfo_close($finfo);

        if (in_array($end, $allowed_ext) && in_array($mime, $allowed_mime)) {
            if (!is_dir('video')) {
                mkdir('video', 0777, true);
            }

            $name = uniqid('video_', true);
            $location = 'video/' . $name . '.' . $end;

            if (move_uploaded_file($file_temp, $location)) {
                $conn = new mysqli("localhost", "username", "password", "database");
                $stmt = $conn->prepare("INSERT INTO video (name, location) VALUES (?, ?)");
                $stmt->bind_param("ss", $name, $location);
                $stmt->execute();

                echo "<script>alert('Video Uploaded'); window.location = 'index.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid video format or MIME type'); window.location = 'index.php';</script>";
        }
    } else {
        echo "<script>alert('File too large to upload'); window.location = 'index.php';</script>";
    }
}
?>
