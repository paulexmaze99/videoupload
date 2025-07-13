<?php
require_once 'conn.php';

function redirectWithAlert($message) {
    echo "<script>alert(" . json_encode($message) . "); window.location = 'index.php';</script>";
    exit;
}

if (!isset($_POST['save'], $_FILES['video'])) {
    redirectWithAlert('No file submitted.');
}

$file = $_FILES['video'];
$fileName = $file['name'];
$fileTemp = $file['tmp_name'];
$fileSize = $file['size'];

$maxSize = 50 * 1024 * 1024;
if ($fileSize > $maxSize) {
    redirectWithAlert('File too large to upload (max 50MB).');
}

$extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$allowedExtensions = ['avi', 'flv', 'wmv', 'mov', 'mp4'];

if (!in_array($extension, $allowedExtensions)) {
    redirectWithAlert("Wrong video format. Allowed: " . implode(', ', $allowedExtensions));
}

// MIME check
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $fileTemp);
finfo_close($finfo);

if (strpos($mime, 'video') !== 0) {
    redirectWithAlert("Invalid file type ($mime). Upload video files only.");
}

// Absolute upload directory (on server)
$uploadDir = __DIR__ . '/videos/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Save file
$uniqueName = date("Ymd_His") . '_' . uniqid();
$filename = $uniqueName . '.' . $extension;
$targetPath = $uploadDir . $filename;

// Move and store
if (!move_uploaded_file($fileTemp, $targetPath)) {
    file_put_contents(__DIR__ . '/upload_error_log.txt', "Upload failed: $filename\n", FILE_APPEND);
    redirectWithAlert('Upload failed. Check write permissions on /videos folder.');
}

// Save the **public URL path** in DB (e.g., videos/filename.mp4)
$videoName = mysqli_real_escape_string($conn, $uniqueName);
$videoPath = mysqli_real_escape_string($conn, 'videos/' . $filename);

$query = "INSERT INTO `video` (`video_name`, `location`) VALUES('$videoName', '$videoPath')";
if (mysqli_query($conn, $query)) {
    redirectWithAlert('Video uploaded successfully!');
} else {
    redirectWithAlert('Database insert failed: ' . mysqli_error($conn));
}
?>
