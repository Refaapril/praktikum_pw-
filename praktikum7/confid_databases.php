<?php
session_start();

$host = 'localhost';
$user = 'upload_user';
$pass = 'SecurePass123!';
$dbname = 'file_upload_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");
?>
