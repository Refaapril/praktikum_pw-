<?php
// register_process.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $gender = $_POST['gender'];
    
    // Validasi
    $errors = [];
    
    // 1. Cek password sama
    if ($password !== $repassword) {
        $errors[] = "Password dan Re-type Password tidak sama!";
    }
    
    // 2. Cek username sudah ada
    $check = "SELECT username FROM login WHERE username = '$username'";
    $result = mysqli_query($conn, $check);
    
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Username '$username' sudah digunakan!";
    }
    
    // 3. Jika ada error
    if (!empty($errors)) {
        $_SESSION['message'] = implode("<br>", $errors);
        $_SESSION['message_type'] = "error";
        header("Location: index.php?page=register");
        exit();
    }
    
    // 4. Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // 5. Simpan ke database
    $sql = "INSERT INTO login (username, password, gender) 
            VALUES ('$username', '$hashed_password', '$gender')";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "User berhasil terdaftar! Silakan login.";
        $_SESSION['message_type'] = "success";
        header("Location: index.php?page=login");
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn);
        $_SESSION['message_type'] = "error";
        header("Location: index.php?page=register");
    }
    
    exit();
}

// Jika bukan POST, redirect
header("Location: index.php");
exit();
?>
