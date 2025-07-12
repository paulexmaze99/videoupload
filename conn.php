<?php
$host = 'localhost';     // Try this!
$port = 3306;            // Or 3308 if it worked before
$user = 'root';
$pass = '';
$db   = 'db_video';

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}

echo "✅ Connected to MySQL successfully!";
