<?php
// logout.php - Keluar dari sistem
require_once 'config.php';

// HAPUS SEMUA SESSION
session_unset();    // Hapus semua variabel session
session_destroy();  // Hancurkan session

// Redirect ke halaman login
header("Location: index.php");
exit();
?>
