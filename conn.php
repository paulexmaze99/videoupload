<?php
$host = 'sql8.freesqldatabase.com';
$port = 3306;
$user = 'sql8789664';
$pass = 'EzAcq4CUXs';
$dbname = 'sql8789664';

$attempts = 0;
$maxAttempts = 5;

do {
    $conn = @new mysqli($host, $user, $pass, $dbname, $port);
    if ($conn && !$conn->connect_error) {
        break;
    }
    $attempts++;
    sleep(2); // Wait before retrying
} while ($attempts < $maxAttempts);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
