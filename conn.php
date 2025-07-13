<?php
$host = '127.0.0.1';
$port = '3308'; // Default DBngin port
$user = 'root';
$pass = '';     // Add password if set in DBngin
$dbname = 'db_video';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
