<?php
// Koneksi database
function connectDB() {
    $conn = new mysqli('localhost', 'root', '', 'file_upload_db');
    if ($conn->connect_error) die("Error: " . $conn->connect_error);
    return $conn;
}

$conn = connectDB();
$result = $conn->query("SELECT * FROM uploaded_files ORDER BY upload_date DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Files</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>📂 File Terupload</h2>
    <a href="index.php" class="btn btn-primary mb-3">← Kembali</a>
    
    <?php if ($result->num_rows > 0): ?>
        <div class="row">
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h6><?= $row['file_name'] ?></h6>
                        <small class="text-muted">
                            <?= date('d/m/Y H:i', strtotime($row['upload_date'])) ?>
                        </small><br>
                        <a href="<?= $row['file_path'] ?>" class="btn btn-sm btn-success" download>Download</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Belum ada file</div>
    <?php endif; ?>
</body>
</html>
<?php $conn->close(); ?>
