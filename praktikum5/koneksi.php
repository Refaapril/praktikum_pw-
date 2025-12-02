<?php
// koneksi.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "administrasi_data"; // GANTI dengan nama database Anda

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8");
?>
