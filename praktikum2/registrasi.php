php
// proses_registrasi.php - VERSI SIMPLE DAN PASTI BEKERJA
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>🔄 PROSES REGISTRASI</h2>";

// Tampilkan data POST untuk debugging
echo "<div style='background:#fff3cd; padding:15px; border:1px solid #ffeaa7;'>";
echo "<strong>Data yang diterima:</strong><br>";
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        echo $key . " = " . htmlspecialchars($value) . "<br>";
    }
} else {
    echo "Tidak ada data POST!<br>";
    echo "Metode: " . $_SERVER['REQUEST_METHOD'] . "<br>";
}
echo "</div>";

// Jika ada data POST, proses
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['nim'])) {
    
    // Koneksi database
    include 'koneksi.php';
    
    if ($koneksi) {
        // Ambil data
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $jurusan = $_POST['jurusan'];
        $alamat = $_POST['alamat'];
        $email = $_POST['email'];
        $telepon = $_POST['telepon'];
        $password = $_POST['password'];
        
        // Query sederhana
        $sql = "INSERT INTO mahasiswa (nim, nama, jenis_kelamin, jurusan, alamat, email, telepon, password) 
                VALUES ('$nim', '$nama', '$jenis_kelamin', '$jurusan', '$alamat', '$email', '$telepon', '$password')";
        
        if (mysqli_query($koneksi, $sql)) {
            echo "<div style='background:#d4edda; color:#155724; padding:20px; border:1px solid #c3e6cb; margin:20px 0;'>";
            echo "<h3>✅ REGISTRASI BERHASIL!</h3>";
            echo "Data mahasiswa telah disimpan ke database.<br>";
            echo "ID: " . mysqli_insert_id($koneksi) . "<br>";
            echo "NIM: $nim<br>";
            echo "Nama: $nama<br>";
            echo "</div>";
        } else {
            echo "<div style='background:#f8d7da; color:#721c24; padding:20px; border:1px solid #f5c6cb; margin:20px 0;'>";
            echo "<h3>❌ ERROR DATABASE</h3>";
            echo "Pesan error: " . mysqli_error($koneksi) . "<br>";
            echo "Query: " . htmlspecialchars($sql) . "<br>";
            echo "</div>";
        }
        
        mysqli_close($koneksi);
    } else {
        echo "<div style='background:#f8d7da; color:#721c24; padding:20px;'>";
        echo "❌ Database tidak terkoneksi!<br>";
        echo "</div>";
    }
    
} else {
    echo "<div style='background:#f8d7da; color:#721c24; padding:20px; margin:20px 0;'>";
    echo "<h3>❌ FORM TIDAK LENGKAP</h3>";
    echo "Data tidak lengkap atau form tidak disubmit dengan benar.<br>";
    echo "Silakan isi semua field yang diperlukan.";
    echo "</div>";
}

// Link kembali
echo "<br><br>";
echo "<a href='form_registrasi.php' style='padding:10px 20px; background:#3498db; color:white; text-decoration:none; border-radius:5px;'>";
echo "⬅ Kembali ke Form Registrasi";
echo "</a>";
echo " | ";
echo "<a href='lihat_data.php' style='padding:10px 20px; background:#27ae60; color:white; text-decoration:none; border-radius:5px;'>";
echo "📊 Lihat Data Mahasiswa";
echo "</a>";
?>
