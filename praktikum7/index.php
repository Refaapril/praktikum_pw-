<?php
// ============================================
// SEMUA KODE DALAM 1 FILE - NO CONFIG FOLDER
// ============================================

// Fungsi untuk koneksi database
function connectDB() {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'file_upload_db';
    
    // Koneksi ke MySQL
    $conn = new mysqli($host, $user, $pass);
    
    if ($conn->connect_error) {
        die("❌ Koneksi MySQL gagal: " . $conn->connect_error);
    }
    
    // Buat database jika belum ada
    $conn->query("CREATE DATABASE IF NOT EXISTS $dbname 
                  CHARACTER SET utf8mb4 
                  COLLATE utf8mb4_general_ci");
    
    // Pilih database
    $conn->select_db($dbname);
    
    // Buat tabel jika belum ada
    $conn->query("CREATE TABLE IF NOT EXISTS uploaded_files (
        id INT AUTO_INCREMENT PRIMARY KEY,
        file_name VARCHAR(255) NOT NULL,
        file_path VARCHAR(500) NOT NULL,
        file_type VARCHAR(100) NOT NULL,
        file_size BIGINT NOT NULL,
        upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        description TEXT
    )");
    
    return $conn;
}

// Buat folder uploads jika belum ada
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
    echo "<div class='alert alert-info'>Folder 'uploads' dibuat</div>";
}

// Koneksi database
$conn = connectDB();

// ============================================
// PROSES UPLOAD
// ============================================
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['file_upload']['name'];
        $file_tmp = $_FILES['file_upload']['tmp_name'];
        $file_size = $_FILES['file_upload']['size'];
        $file_type = $_FILES['file_upload']['type'];
        $description = $_POST['description'] ?? '';
        
        // Validasi ekstensi
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (!in_array($ext, $allowed)) {
            $message = "❌ Hanya file: JPG, PNG, GIF, PDF, DOC, TXT yang diizinkan";
            $message_type = 'danger';
        } elseif ($file_size > 5 * 1024 * 1024) { // 5MB
            $message = "❌ File maksimal 5MB";
            $message_type = 'danger';
        } else {
            // Nama file unik
            $new_name = time() . '_' . uniqid() . '.' . $ext;
            $upload_path = 'uploads/' . $new_name;
            
            // Upload file
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Simpan ke database
                $stmt = $conn->prepare("INSERT INTO uploaded_files (file_name, file_path, file_type, file_size, description) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssis", $file_name, $upload_path, $file_type, $file_size, $description);
                
                if ($stmt->execute()) {
                    $message = "✅ File berhasil diupload!";
                    $message_type = 'success';
                } else {
                    $message = "❌ Gagal menyimpan ke database";
                    $message_type = 'danger';
                }
                $stmt->close();
            } else {
                $message = "❌ Gagal upload. Coba lagi.";
                $message_type = 'danger';
            }
        }
    } else {
        $message = "⚠️ Pilih file terlebih dahulu";
        $message_type = 'warning';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File - Simple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; padding: 20px; }
        .container { max-width: 600px; }
        .card { box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .card-header { background: #0d6efd; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3><i class="fas fa-upload"></i> UPLOAD FILE</h3>
                <small>PRAKTIKUM 7 - PW</small>
            </div>
            <div class="card-body">
                <?php if ($message): ?>
                    <div class="alert alert-<?= $message_type ?>">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Pilih File:</label>
                        <input type="file" name="file_upload" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi:</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-cloud-upload-alt"></i> UPLOAD
                    </button>
                </form>
                
                <div class="mt-4 text-center">
                    <a href="view_simple.php" class="btn btn-success">
                        <i class="fas fa-eye"></i> Lihat File
                    </a>
                    <a href="test_simple.php" class="btn btn-info">
                        <i class="fas fa-check"></i> Test System
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-3 text-center text-muted">
            <small>Status: 
                Database: <?= $conn ? '✅ Connected' : '❌ Error' ?> | 
                Folder uploads: <?= file_exists('uploads') ? '✅ Ada' : '❌ Tidak Ada' ?>
            </small>
        </div>
    </div>
    
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
