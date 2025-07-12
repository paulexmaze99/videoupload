<?php
$host = '127.0.0.1';  // NOT '127.0.0.1:3308'
$port = 3308;         // DBngin shows this in the UI
$user = 'root';
$pass = '';           // leave blank unless you set a password
$db   = 'db_video';   // or any existing DB name

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}

echo "✅ Connected successfully!";
?>
