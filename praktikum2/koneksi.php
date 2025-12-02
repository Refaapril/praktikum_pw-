<?php
// koneksi.php - VERSI SUPER SIMPLE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "market_refa";

// Koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Jika gagal, coba tanpa database dulu
if (!$koneksi) {
    $koneksi = mysqli_connect($host, $user, $pass);
    if ($koneksi) {
        // Buat database jika belum ada
        mysqli_query($koneksi, "CREATE DATABASE IF NOT EXISTS $db");
        mysqli_select_db($koneksi, $db);
    }
}

// Jika masih gagal, tampilkan error
if (!$koneksi) {
    die("❌ KONEKSI GAGAL: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($koneksi, "utf8");

// Pesan sukses (hanya untuk debugging, bisa dihapus nanti)
// echo "<!-- Database connected successfully -->";
?>
