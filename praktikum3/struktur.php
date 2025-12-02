<!DOCTYPE html>
<html>
<head>
    <title>Kalkulator PHP</title>
</head>
<body>
    <h2>Kalkulator Sederhana</h2>
    <form method="post">
        <input type="number" name="angka1" required>
        <select name="operator">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">×</option>
            <option value="/">÷</option>
        </select>
        <input type="number" name="angka2" required>
        <button type="submit">Hitung</button>
    </form>
    
    <?php
    // Kode PHP akan ditempatkan di sini
    ?>
</body>
</html>
