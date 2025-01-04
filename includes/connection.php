<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'if0_37790928_hotel_management';

// MySQLi connection
$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("MySQLi Connection failed: " . mysqli_connect_error());
}

// PDO connection
try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions on errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Fetch results as associative arrays
    ]);
} catch (PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}
?>
