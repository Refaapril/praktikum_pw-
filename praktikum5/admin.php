<?php
// admin.php - Semua dalam satu file
session_start();

// Koneksi Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "administrasi_data";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

// Fungsi-fungsi handler
function show_admin_data($root) {
    global $conn;

    echo "<div style='padding: 20px;'>";
    echo "<h2>Administrasi Data</h2>";
    echo "<a href='{$root}&act=add' style='background: #4CAF50; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;'>Tambah Data</a>";
    echo "<br><br>";

    $sql = "SELECT * FROM mahasiswa ORDER BY nim";
    $res = mysqli_query($conn, $sql);

    if (!$res) {
        die("Error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($res) == 0) {
        echo "<p>Belum ada data. <a href='{$root}&act=add'>Tambah Data</a></p>";
        return;
    }

    echo "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 100%;'>
            <tr style='background-color: #2c3e50; color: white;'>
                <th width='5%'>#</th>
                <th width='15%'>NIM</th>
                <th width='25%'>Nama</th>
                <th width='35%'>Alamat</th>
                <th width='20%'>Menu</th>
            </tr>";

    $i = 1;
    while ($row = mysqli_fetch_assoc($res)) {
        $bg_color = ($i % 2 == 0) ? '#f2f2f2' : '#ffffff';
        echo "<tr style='background-color: {$bg_color};'>
                <td align='center'>{$i}</td>
                <td>{$row['nim']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['alamat']}</td>
                <td align='center'>
                    <a href='{$root}&act=edit&id={$row['id']}' style='color: #e67e22;'>Edit</a> | 
                    <a href='{$root}&act=del&id={$row['id']}' 
                       onclick='return confirm(\"Hapus data {$row['nama']}?\")'
                       style='color: #e74c3c;'>Hapus</a>
                </td>
              </tr>";
        $i++;
    }

    echo "</table>";
    echo "<br><strong>Done</strong>";
    echo "</div>";
}

function data_editor($root, $id = '') {
    global $conn;

    // Jika disubmit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nim = mysqli_real_escape_string($conn, $_POST['nim']);
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

        if ($id == '') {
            $sql = "INSERT INTO mahasiswa (nim, nama, alamat) VALUES ('$nim', '$nama', '$alamat')";
        } else {
            $sql = "UPDATE mahasiswa SET nim='$nim', nama='$nama', alamat='$alamat' WHERE id='$id'";
        }

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Data berhasil disimpan');</script>";
            echo "<script>window.location.href='{$root}';</script>";
            return;
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }

    // Ambil data jika edit
    $nim = $nama = $alamat = "";
    if ($id != '') {
        $sql = "SELECT * FROM mahasiswa WHERE id='$id'";
        $res = mysqli_query($conn, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
            $data = mysqli_fetch_assoc($res);
            $nim = htmlspecialchars($data['nim']);
            $nama = htmlspecialchars($data['nama']);
            $alamat = htmlspecialchars($data['alamat']);
        }
    }

    echo "<div style='padding: 20px;'>
            <h2>" . ($id ? 'Edit Data' : 'Tambah Data') . "</h2>
            <form method='post' style='max-width: 500px;'>
            <div style='margin-bottom: 15px;'>
                <label style='display: block; margin-bottom: 5px; font-weight: bold;'>NIM*</label>
                <input type='text' name='nim' value='{$nim}' required style='width: 100%; padding: 8px;'>
            </div>
            <div style='margin-bottom: 15px;'>
                <label style='display: block; margin-bottom: 5px; font-weight: bold;'>Nama*</label>
                <input type='text' name='nama' value='{$nama}' required style='width: 100%; padding: 8px;'>
            </div>
            <div style='margin-bottom: 15px;'>
                <label style='display: block; margin-bottom: 5px; font-weight: bold;'>Alamat</label>
                <textarea name='alamat' rows='4' style='width: 100%; padding: 8px;'>{$alamat}</textarea>
            </div>
            <div>
                <input type='submit' value='Simpan' style='background: #4CAF50; color: white; border: none; padding: 10px 20px; cursor: pointer;'>
                <button type='button' onclick='location.href=\"{$root}\"' style='background: #95a5a6; color: white; border: none; padding: 10px 20px; cursor: pointer;'>Kembali</button>
            </div>
            </form>
            <p style='margin-top: 10px; color: #666;'>Ket: * Harus diisi</p>
          </div>";
}

function data_delete($root, $id) {
    global $conn;

    $sql = "DELETE FROM mahasiswa WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil dihapus');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
    echo "<script>window.location.href='{$root}';</script>";
}

// Main handler
$root = basename($_SERVER['PHP_SELF']) . "?m=data";

if (isset($_GET['act']) && $_GET['act'] == 'add') {
    data_editor($root);
} elseif (isset($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])) {
    data_editor($root, $_GET['id']);
} elseif (isset($_GET['act']) && $_GET['act'] == 'del' && isset($_GET['id'])) {
    data_delete($root, $_GET['id']);
} else {
    show_admin_data($root);
}
?>
