<?php
// Atur parameter cookie SESSION sebelum session_start
session_set_cookie_params([
    'lifetime' => 0,       // Hanya aktif selama browser terbuka
    'path' => '/',
    'domain' => '',        // Kosongkan untuk default
    'secure' => false,     // true kalau pakai HTTPS
    'httponly' => true,    // Tidak bisa diakses lewat JS
    'samesite' => 'Strict' // Cegah CSRF lintas situs
]);

session_start();

// Kalau sudah login, jangan bisa balik ke login.php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: admin.php");
    exit;
}

// Prevent cache
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache");
header("Expires: 0");

$pesan_error = "";

// Jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // User dan pass valid
    $username_valid = "ptisma";
    $password_valid = "12345";

    $username_input = $_POST['username'] ?? '';
    $password_input = $_POST['password'] ?? '';

    if ($username_input === $username_valid && $password_input === $password_valid) {
        // Regenerasi ID session biar aman
        session_regenerate_id(true);

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username_input;
        header("Location: admin.php");
        exit;
    } else {
        $pesan_error = "USERNAME ATAU PASSWORD SALAH!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perusahaan</title>
    <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #2fb6e5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-wrapper {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            text-align: center;
        }
        .login-wrapper h2 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #333;
        }
        .content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px;
        }
        .logo-container img {
            width: 180px;
            height: auto;
        }
        .login-container {
            width: 280px;
            text-align: left;
        }
        .input-group { margin-bottom: 15px; }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .input-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background: #0056b3; }
        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <h2>Login Admin</h2>
    <div class="content">
        <div class="logo-container">
            <a href="../index.php"><img src="../assets/img/logoisma.png" alt="Logo Perusahaan" style="height: 150px; width: auto;"></a>
        </div>
        <div class="login-container" style="padding-right: 30px;">
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
                <?php if (!empty($pesan_error)) : ?>
                    <p class="error"><?= $pesan_error; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>
