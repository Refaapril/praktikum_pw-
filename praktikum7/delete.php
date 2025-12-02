<?php
include 'config/database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Ambil informasi file sebelum dihapus
    $sql = "SELECT file_path FROM uploaded_files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = $row['file_path'];
        
        // Hapus file dari folder
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        // Hapus dari database
        $delete_sql = "DELETE FROM uploaded_files WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);
        
        if ($delete_stmt->execute()) {
            header("Location: view.php?message=File berhasil dihapus&type=success");
        } else {
            header("Location: view.php?message=Gagal menghapus file&type=danger");
        }
        $delete_stmt->close();
    }
    $stmt->close();
}

header("Location: view.php");
exit();
?>
