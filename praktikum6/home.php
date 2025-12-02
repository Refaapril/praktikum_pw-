<?php
// home.php - Halaman setelah login
require_once 'config.php';

// CEK APAKAH SUDAH LOGIN
if (!isset($_SESSION['username'])) {
    $_SESSION['message'] = "Silakan login terlebih dahulu!";
    $_SESSION['message_type'] = "error";
    header("Location: index.php");
    exit();
}

// Data user dari session
$username = $_SESSION['username'];
$gender = $_SESSION['gender'];
$gender_text = ($gender == 'L') ? 'Laki-laki' : 'Perempuan';

// Hitung durasi login
$login_time = $_SESSION['login_time'];
$current_time = time();
$duration = $current_time - $login_time;
$hours = floor($duration / 3600);
$minutes = floor(($duration % 3600) / 60);
$seconds = $duration % 60;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - Facebook</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f0f2f5;
        }
        .header {
            background: #1877f2;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .user-info span {
            margin-right: 15px;
        }
        .logout-btn {
            background: white;
            color: #1877f2;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }
        .logout-btn:hover {
            background: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }
        .welcome-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .info-box {
            background: #e7f3ff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 6px;
            border-left: 4px solid #1877f2;
        }
        .detail-box {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 6px;
            border: 1px solid #dddfe2;
        }
        .detail-item {
            margin: 10px 0;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .label {
            font-weight: bold;
            color: #606770;
        }
        .value {
            color: #1c1e21;
        }
        .timer {
            font-size: 28px;
            color: #1877f2;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <div class="logo">facebook</div>
        <div class="user-info">
            <span>Halo, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
    
    <!-- CONTENT -->
    <div class="container">
        <div class="welcome-box">
            <h1>Selamat Datang di Facebook!</h1>
            <p>Login Anda: <strong style="color: green;">BERHASIL</strong></p>
            <p>Anda sekarang berada di halaman utama.</p>
            
            <div class="info-box">
                <h3>Anda telah login selama:</h3>
                <div class="timer" id="timer">
                    <?php printf("%02d:%02d:%02d", $hours, $minutes, $seconds); ?>
                </div>
                <p>Waktu login: <?php echo date('H:i:s', $login_time); ?></p>
            </div>
            
            <div class="detail-box">
                <h3>Informasi Akun Anda:</h3>
                <div class="detail-item">
                    <span class="label">Username:</span>
                    <span class="value"><?php echo htmlspecialchars($username); ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Gender:</span>
                    <span class="value"><?php echo $gender_text; ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Status:</span>
                    <span class="value" style="color: green;">● Online</span>
                </div>
                <div class="detail-item">
                    <span class="label">IP Address:</span>
                    <span class="value"><?php echo $_SERVER['REMOTE_ADDR']; ?></span>
                </div>
            </div>
            
            <p style="margin-top: 30px; color: #666;">
                Klik tombol <strong>Logout</strong> di atas untuk keluar dari sistem.
            </p>
        </div>
    </div>
    
    <script>
        // Timer real-time
        function updateTimer() {
            let timer = document.getElementById('timer');
            let time = timer.textContent.split(':');
            let hours = parseInt(time[0]);
            let minutes = parseInt(time[1]);
            let seconds = parseInt(time[2]);
            
            seconds++;
            if (seconds >= 60) {
                seconds = 0;
                minutes++;
                if (minutes >= 60) {
                    minutes = 0;
                    hours++;
                }
            }
            
            timer.textContent = 
                hours.toString().padStart(2, '0') + ':' +
                minutes.toString().padStart(2, '0') + ':' +
                seconds.toString().padStart(2, '0');
        }
        
        // Update setiap detik
        setInterval(updateTimer, 1000);
    </script>
</body>
</html>
