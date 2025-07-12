<?php
$host = '127.0.0.1';     // Use IP for TCP
$port = 3306;            // Or 3308 if DBngin says so
$user = 'root';
$pass = '';
$db   = 'db_video';

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}

echo "✅ Connected to MySQL successfully!";
