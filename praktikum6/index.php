<?php
// index.php - Halaman depan
require_once 'config.php';

// Jika sudah login, redirect ke home
if (isset($_SESSION['username'])) {
    header("Location: home.php");
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'login';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Login Facebook</title>
    <style>
        /* CSS Simple */
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 400px;
        }
        .logo {
            text-align: center;
            color: #1877f2;
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #1c1e21;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #dddfe2;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-login {
            background: #1877f2;
            color: white;
        }
        .btn-login:hover {
            background: #166fe5;
        }
        .btn-signup {
            background: #42b72a;
            color: white;
        }
        .btn-signup:hover {
            background: #36a420;
        }
        .gender-group {
            margin: 15px 0;
        }
        .gender-group label {
            display: inline-block;
            margin-right: 15px;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            text-align: center;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .switch-link {
            text-align: center;
            margin-top: 15px;
        }
        .switch-link a {
            color: #1877f2;
            text-decoration: none;
        }
        .switch-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">facebook</div>
        
        <div class="form-box">
            <?php if ($page == 'login'): ?>
                <!-- FORM LOGIN -->
                <h2>Login ke Facebook</h2>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="message <?php echo $_SESSION['message_type']; ?>">
                        <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php 
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                    ?>
                <?php endif; ?>
                
                <form action="login_process.php" method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="btn btn-login">Login</button>
                </form>
                
                <div class="switch-link">
                    <a href="?page=register">Buat Akun Baru</a>
                </div>
                
            <?php else: ?>
                <!-- FORM REGISTER -->
                <h2>Buat Akun Baru</h2>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="message <?php echo $_SESSION['message_type']; ?>">
                        <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php 
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                    ?>
                <?php endif; ?>
                
                <form action="register_process.php" method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <input type="password" name="repassword" id="repassword" placeholder="Re-type Password" required>
                    
                    <div class="gender-group">
                        <label>Gender:</label><br>
                        <label><input type="radio" name="gender" value="L" required> Laki-laki</label>
                        <label><input type="radio" name="gender" value="P"> Perempuan</label>
                    </div>
                    
                    <button type="submit" class="btn btn-signup">Sign Up</button>
                </form>
                
                <div class="switch-link">
                    <a href="?page=login">Sudah punya akun? Login</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        // Validasi password sama
        document.querySelector('form')?.addEventListener('submit', function(e) {
            var password = document.getElementById('password');
            var repassword = document.getElementById('repassword');
            
            if (password && repassword && password.value !== repassword.value) {
                alert('Password dan Re-type Password tidak sama!');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
