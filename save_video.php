<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'conn.php';

// Simple alert + redirect helper
function redirectWithAlert($message) {
    echo "<script>alert(" . json_encode($message) . "); window.location = 'index.php';</script>";
    exit;
}

// Check if file is submitted
if (!isset($_POST['save'], $_FILES['video'])) {
    redirectWithAlert('No file submitted.');
}

$file = $_FILES['video'];
$fileName = $file['name'];
$fileTemp = $file['tmp_name'];
$fileSize = $file['size'];

// 50MB limit
$maxSize = 50 * 1024 * 1024;
if ($fileSize > $maxSize) {
    redirectWithAlert('File too large to upload (max 50MB).');
}

// Extract extension safely
$extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$allowedExtensions = ['avi', 'flv', 'wmv', 'mov', 'mp4'];

if (!in_array($extension, $allowedExtensions)) {
    redirectWithAlert("Wrong video format. Allowed: " . implode(', ', $allowedExtensions));
}

// MIME type check for security
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $fileTemp);
finfo_close($finfo);

if (strpos($mime, 'video') !== 0) {
    redirectWithAlert("Invalid file type ($mime). Upload video files only.");
}

// Ensure upload directory exists
$uploadDir = 'videos/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Save video
$uniqueName = date("Ymd_His") . '_' . uniqid();
$targetPath = $uploadDir . $uniqueName . '.' . $extension;

if (!move_uploaded_file($fileTemp, $targetPath)) {
    redirectWithAlert('Upload failed. Check write permissions on /videos folder.');
}

// Sanitize before DB insert
$videoName = mysqli_real_escape_string($conn, $uniqueName);
$videoPath = mysqli_real_escape_string($conn, $targetPath);

$query = "INSERT INTO `video` (`video_name`, `location`) VALUES('$videoName', '$videoPath')";
if (mysqli_query($conn, $query)) {
    redirectWithAlert('Video uploaded successfully!');
} else {
    redirectWithAlert('Database insert failed: ' . mysqli_error($conn));
}
?>
