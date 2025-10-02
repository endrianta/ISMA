<?php
$servername = "localhost";
$username   = "root";   // default XAMPP
$password   = "";       // default XAMPP kosong
$database   = "isma_db"; // sesuai phpMyAdmin]
$port       = 3306;

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
