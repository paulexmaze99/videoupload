<?php
$host = 'db.pxxl.pro';
$port = 40796;
$user = 'user_be284063';
$pass = '04f62ad14e6aa7f49d7f8bc15c566f2e';
$dbname = 'db_6ed624af';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
