<?php
$host = 'sql8.freesqldatabase.com';
$port = 3306;
$user = 'sql8789664';
$pass = 'EzAcq4CUXs';
$db   = 'sql8789664';

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
?>
