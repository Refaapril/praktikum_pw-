<?php
// File: pagination.php
include("conn.php");

// Jumlah data per halaman = 2 (sesuai gambar)
$page_rows = 2;

// Hitung total record
$query = mysqli_query($conn, "SELECT COUNT(userid) FROM user");
$row = mysqli_fetch_row($query);
$rows = $row[0];

// Hitung total halaman
$last = ceil($rows / $page_rows);
if ($last < 1) {
    $last = 1;
}

// Get current page number
$pagenum = 1;
if (isset($_GET['pn']) && is_numeric($_GET['pn'])) {
    $pagenum = (int) $_GET['pn'];
}

// Validasi page number
if ($pagenum < 1) {
    $pagenum = 1;
} else if ($pagenum > $last) {
    $pagenum = $last;
}

// LIMIT untuk query
$limit = 'LIMIT ' . ($pagenum - 1) * $page_rows . ',' . $page_rows;

// Query data dengan pagination
$nquery = mysqli_query($conn, "SELECT * FROM user ORDER BY userid ASC $limit");

// Kontrol pagination (SIMPLE VERSION seperti gambar)
$paginationCtrls = '';

// Tampilkan nomor halaman
for ($i = 1; $i <= $last; $i++) {
    if ($i == $pagenum) {
        $paginationCtrls .= '<strong>' . $i . '</strong> &nbsp; ';
    } else {
        $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $i . '">' . $i . '</a> &nbsp; ';
    }
}

// Tombol Next
if ($pagenum != $last) {
    $next = $pagenum + 1;
    $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $next . '">Next ►</a>';
}
?>
