<?php
// login_process.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    // Cari user di database
    $sql = "SELECT * FROM login WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // SET SESSION (ini yang penting!)
            $_SESSION['username'] = $user['username'];
            $_SESSION['gender'] = $user['gender'];
            $_SESSION['login_time'] = time();
            
            // Redirect ke halaman home
            header("Location: home.php");
            exit();
        } else {
            $_SESSION['message'] = "Password salah!";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Username '$username' tidak ditemukan!";
        $_SESSION['message_type'] = "error";
    }
    
    header("Location: index.php");
    exit();
}

// Jika bukan POST, redirect
header("Location: index.php");
exit();
?>
