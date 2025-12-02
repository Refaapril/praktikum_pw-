<?php
// index.php
require_once 'koneksi.php';
require_once 'data_handler.php';

// root URL untuk action
$root = basename($_SERVER['PHP_SELF']) . "?m=data";

// Jika ada parameter m=data, jalankan handler
if (isset($_GET['m']) && $_GET['m'] == 'data') {
    data_handler($root);
} else {
    // Default: tampilkan halaman admin data
    data_handler($root);
}
?>
