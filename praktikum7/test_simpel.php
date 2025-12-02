<?php
echo "<h2>🧪 TEST SYSTEM</h2>";
echo "<pre>";

// Test 1: PHP
echo "PHP Version: " . phpversion() . "\n\n";

// Test 2: MySQL
$conn = @new mysqli('localhost', 'root', '');
if ($conn->connect_error) {
    echo "MySQL: ❌ " . $conn->connect_error . "\n";
} else {
    echo "MySQL: ✅ Connected\n";
    $conn->close();
}

// Test 3: Folder
echo "\nFolder 'uploads': " . (file_exists('uploads') ? '✅ Ada' : '❌ Tidak Ada');

// Test 4: Upload settings
echo "\n\nUpload Max: " . ini_get('upload_max_filesize');
echo "\nPost Max: " . ini_get('post_max_size');

echo "</pre>";
echo "<a href='index.php' class='btn btn-primary'>← Kembali</a>";
?>
