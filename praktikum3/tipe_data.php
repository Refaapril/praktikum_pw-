<?php
// 1. Variabel string
$angka = "12345678910";

// 2. Cek apakah string?
echo is_string($angka); // true

// 3. Cast ke integer
$angka_int = (int)$angka;

// 4. Cek lagi
echo is_int($angka_int); // true
?>
