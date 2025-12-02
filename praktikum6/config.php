<?php
// config.php - Koneksi ke database
session_start();

// Database configuration (SESUAIKAN DENGAN SETTING ANDA)
$host = "localhost";            // Biasanya localhost
$user = "root";                 // Username database
$pass = "";                     // Password database (kosong di XAMPP)
$dbname = "administrasi_data";  // Nama database Anda

// Buat koneksi
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set karakter set
mysqli_set_charset($conn, "utf8");

// Base URL untuk redirect
$base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
?>
