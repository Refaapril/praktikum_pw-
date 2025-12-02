<?php
// data_handler.php
function data_handler($root) {
    if (isset($_GET['act']) && $_GET['act'] == 'add') {
        data_editor($root);
        return;
    }

    if (isset($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])) {
        data_editor($root, $_GET['id']);
        return;
    }

    if (isset($_GET['act']) && $_GET['act'] == 'del' && isset($_GET['id'])) {
        data_delete($root, $_GET['id']);
        return;
    }

    show_admin_data($root);
}

function show_admin_data($root) {
    global $conn;

    echo "<h2>Administrasi Data Mahasiswa</h2>";
    echo "<a href='{$root}&act=add'>Tambah Data</a><br><br>";

    $sql = "SELECT * FROM mahasiswa ORDER BY nim";
    $res = mysqli_query($conn, $sql);

    if (!$res) {
        die("Error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($res) == 0) {
        echo "Belum ada data. <a href='{$root}&act=add'>Tambah Data</a>";
        return;
    }

    echo "<table border='1' cellpadding='6' style='border-collapse: collapse; width: 100%;'>
            <tr style='background-color: #f2f2f2;'>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Menu</th>
            </tr>";

    $i = 1;
    while ($row = mysqli_fetch_assoc($res)) {
        $bg_color = ($i % 2 == 0) ? '#f9f9f9' : '#ffffff';
        echo "<tr style='background-color: {$bg_color};'>
                <td align='center'>{$i}</td>
                <td>{$row['nim']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['alamat']}</td>
                <td align='center'>
                    <a href='{$root}&act=edit&id={$row['id']}'>Edit</a> |
                    <a href='{$root}&act=del&id={$row['id']}'
                       onclick='return confirm(\"Hapus data {$row['nama']}?\")'>
                       Hapus
                    </a>
                </td>
              </tr>";
        $i++;
    }

    echo "</table>";
    echo "<br><strong>Done</strong>";
}

function data_editor($root, $id = '') {
    global $conn;

    // Jika disubmit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nim = mysqli_real_escape_string($conn, $_POST['nim']);
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

        if ($id == '') {
            // INSERT data baru
            $sql = "INSERT INTO mahasiswa (nim, nama, alamat)
                    VALUES ('$nim', '$nama', '$alamat')";
        } else {
            // UPDATE data existing
            $sql = "UPDATE mahasiswa SET nim='$nim', nama='$nama', alamat='$alamat'
                    WHERE id='$id'";
        }

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Data berhasil disimpan');</script>";
            echo "<script>document.location.href='{$root}';</script>";
            return;
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }

    // Jika edit: ambil data lama
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

    echo "<h2>" . ($id ? 'Edit Data' : 'Tambah Data') . "</h2>
        <form method='post'>
        <table>
            <tr>
                <td>NIM*</td>
                <td><input type='text' name='nim' value='{$nim}' required style='width: 300px;'></td>
            </tr>
            <tr>
                <td>Nama*</td>
                <td><input type='text' name='nama' value='{$nama}' required style='width: 300px;'></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><textarea name='alamat' rows='3' cols='40' style='width: 300px;'>{$alamat}</textarea></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Simpan' style='padding: 5px 15px;'>
                    <button type='button' onclick='location.href=\"{$root}\"' style='padding: 5px 15px;'>Kembali</button>
                </td>
            </tr>
        </table>
        </form>";

    echo "<p>Ket : * Harus diisi</p>";
}

function data_delete($root, $id) {
    global $conn;

    $sql = "DELETE FROM mahasiswa WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil dihapus');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
    echo "<script>document.location.href='{$root}';</script>";
}
?>
