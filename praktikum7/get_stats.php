<?php
include 'config/database.php';

$stats = [];

// Total file
$sql = "SELECT COUNT(*) as total FROM uploaded_files";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$stats['total_files'] = $row['total'];

// Total ukuran (dalam MB)
$sql = "SELECT SUM(file_size) as total_size FROM uploaded_files";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$stats['total_size'] = round(($row['total_size'] ?? 0) / 1024 / 1024, 2) . " MB";

// Upload terakhir
$sql = "SELECT upload_date FROM uploaded_files ORDER BY upload_date DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stats['last_upload'] = date('d/m/Y', strtotime($row['upload_date']));
} else {
    $stats['last_upload'] = "-";
}

header('Content-Type: application/json');
echo json_encode($stats);

$conn->close();
?>
