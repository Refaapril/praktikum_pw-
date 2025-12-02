<?php
echo "a. Deret: 4, 6, 9, 13, 18, ";
// Pola: tambah 2,3,4,5,6,7...
$deret_a = [4];
$tambah = 2;
for ($i = 1; $i < 7; $i++) {
    if ($i > 0) {
        $deret_a[$i] = $deret_a[$i-1] + $tambah;
        $tambah++;
    }
}
// Tampilkan dua angka berikutnya
echo $deret_a[5] . ", " . $deret_a[6];
echo "<br>";

echo "b. Deret: 2, 2, 3, 3, 4, ";
// Pola: ulang 2 kali lalu naik 1
$deret_b = [];
$num = 2;
for ($i = 0; $i < 7; $i++) {
    if ($i % 2 == 0 && $i > 0) $num++;
    $deret_b[$i] = $num;
}
echo $deret_b[5] . ", " . $deret_b[6];
echo "<br>";

echo "c. Deret: 1, 9, 2, 10, 3, ";
// Pola selang-seling
$ganjil = 1;
$genap = 9;
$deret_c = [];
for ($i = 0; $i < 7; $i++) {
    if ($i % 2 == 0) {
        $deret_c[$i] = $ganjil;
        $ganjil++;
    } else {
        $deret_c[$i] = $genap;
        $genap++;
    }
}
echo $deret_c[5] . ", " . $deret_c[6];
?>
