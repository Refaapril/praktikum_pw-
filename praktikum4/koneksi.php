<?php
// Konfigurasi database
$host = 'localhost';        // Host
$user = 'root';             // Username MySQL
$password = '';             // Password MySQL
$database = 'market_refa';  // Nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $program = $_POST['program'];

    // Validasi sederhana
    if (!empty($nama) && !empty($email) && !empty($tanggal_lahir) && !empty($alamat) && !empty($program)) {
        // Query untuk menyimpan data ke tabel pendaftaran
        $sql = "INSERT INTO pendaftaran (nama, email, tanggal_lahir, alamat, program)
                VALUES ('$nama', '$email', '$tanggal_lahir', '$alamat', '$program')";

        if ($conn->query($sql) === TRUE) {
            echo "✅ Data pendaftaran berhasil disimpan!<br>";
            echo "<a href='pendaftaran.php'>Kembali ke Formulir</a>";
        } else {
            echo "❌ Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "⚠️ Semua field harus diisi!";
    }
}

// Menutup koneksi
$conn->close();
?>
