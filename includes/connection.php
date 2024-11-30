<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'if0_37790928_hotel_management';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: ");
}
echo "Connected successfully!";
?>
