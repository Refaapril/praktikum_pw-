<?php
// form_registrasi.php - VERSI PERBAIKAN
// TAMBAHKAN ERROR REPORTING DI AWAL FILE
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Mahasiswa Baru</title>
    <style>
        * { font-family: Arial; }
        body { padding: 30px; background: #f0f8ff; }
        .container { 
            background: white; 
            padding: 25px; 
            border-radius: 10px; 
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h2 { 
            color: #2c3e50; 
            text-align: center; 
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        table { width: 100%; }
        td { padding: 10px; }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .btn {
            background: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px 5px;
        }
        .btn:hover { background: #2980b9; }
        .status {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .debug { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; font-size: 12px; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // TEST KONEKSI DATABASE
        include 'koneksi.php';
        
        echo "<div class='status info'>";
        echo "🔄 Testing koneksi...<br>";
        if ($koneksi) {
            echo "✅ Database <b>market_refa</b> terkoneksi";
            
            // Cek tabel mahasiswa
            $check = mysqli_query($koneksi, "SHOW TABLES LIKE 'mahasiswa'");
            if (mysqli_num_rows($check) > 0) {
                echo "<br>✅ Tabel <b>mahasiswa</b> tersedia";
            } else {
                echo "<br>⚠️ Tabel <b>mahasiswa</b> belum ada. 
                      <a href='buat_tabel.php' style='color:red;'>Buat sekarang</a>";
            }
        } else {
            echo "❌ Database tidak terkoneksi";
        }
        echo "</div>";
        
        // Debug POST data jika ada
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "<div class='debug'>";
            echo "<strong>DEBUG POST Data:</strong><br>";
            print_r($_POST);
            echo "</div>";
        }
        ?>
        
        <h2>📝 FORM REGISTRASI MAHASISWA BARU</h2>
        
        <!-- FORM YANG SUDAH DIPERBAIKI -->
        <form action="proses_registrasi.php" method="POST" id="formRegistrasi">
            <table border="0" cellpadding="5">
                <tr>
                    <td width="150">NIM *</td>
                    <td width="10">:</td>
                    <td><input type="text" name="nim" required placeholder="Contoh: 2402068"></td>
                </tr>
                <tr>
                    <td>Nama Lengkap *</td>
                    <td>:</td>
                    <td><input type="text" name="nama" required value="Refa Apriliani"></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin *</td>
                    <td>:</td>
                    <td>
                        <label><input type="radio" name="jenis_kelamin" value="L"> Laki-laki</label>
                        <label><input type="radio" name="jenis_kelamin" value="P" checked> Perempuan</label>
                    </td>
                </tr>
                <tr>
                    <td>Jurusan *</td>
                    <td>:</td>
                    <td>
                        <select name="jurusan" required>
                            <option value="">-- Pilih Jurusan --</option>
                            <option value="Teknik Informatika" selected>Teknik Informatika</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Manajemen">Manajemen</option>
                            <option value="Akuntansi">Akuntansi</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Alamat *</td>
                    <td>:</td>
                    <td><textarea name="alamat" rows="3" required>SURADADI</textarea></td>
                </tr>
                <tr>
                    <td>Email *</td>
                    <td>:</td>
                    <td><input type="email" name="email" required value="refaapriliani87@gmail.com"></td>
                </tr>
                <tr>
                    <td>No. Telepon *</td>
                    <td>:</td>
                    <td><input type="text" name="telepon" required value="0888987588"></td>
                </tr>
                <tr>
                    <td>Password *</td>
                    <td>:</td>
                    <td><input type="password" name="password" required value="123456"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center; padding-top: 20px;">
                        <button type="submit" class="btn">✅ DAFTAR SEKARANG</button>
                        <button type="reset" class="btn" style="background: #e74c3c;">🔄 RESET</button>
                    </td>
                </tr>
            </table>
        </form>
        
        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px dashed #ddd;">
            <p><strong>Link Penting:</strong></p>
            <a href="buat_tabel.php" style="color: #27ae60; margin: 0 10px;">⚙️ Buat Tabel Database</a> |
            <a href="test_koneksi.php" style="color: #3498db; margin: 0 10px;">🔗 Test Koneksi</a> |
            <a href="lihat_data.php" style="color: #9b59b6; margin: 0 10px;">📊 Lihat Data</a>
        </div>
    </div>
    
    <script>
    // JavaScript untuk debugging
    document.getElementById('formRegistrasi').addEventListener('submit', function(e) {
        console.log('Form disubmit!');
        console.log('Aksi form:', this.action);
        
        // Tampilkan data yang akan dikirim
        var formData = new FormData(this);
        console.log('Data yang dikirim:');
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
    });
    </script>
</body>
</html>
