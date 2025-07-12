<?php
$host = 'sqlX.freesqldatabase.com';  // Replace with your host
$port = 3306;
$user = 'sql8789664';                // From email
$pass = 'DRRxv9gR#u44.DF';             // From email
$db   = 'sql8789664';                // DB name from email

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}

echo "✅ Connected to FreeSQLDatabase.com!";
