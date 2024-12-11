<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'fourseasons';

$con = mysqli_connect($host, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: ");
}
echo "Connected successfully!";

