<?php 
include "config.php"; 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if(isset($_POST['save'])){
    $section = $_POST['section'];
    $type    = $_POST['type'];
    $label   = $_POST['label'];
    $value   = $_POST['value'];

    $sql = "INSERT INTO contact (section, type, label, value) VALUES ('$section','$type','$label','$value')";
    if(mysqli_query($conn,$sql)){
        header("Location: contact.php");
        exit;
    } else {
        $error = "Gagal menyimpan data!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kontak - PT. ISMA</title>
    <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
    <style>
        body{font-family:Arial,sans-serif;background:#f4f6f9;margin:0;padding:0;}
        header{background:#2c3e50;color:white;padding:15px 30px;text-align:center;}
        .container{max-width:700px;margin:40px auto;background:white;padding:30px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
        h2{text-align:center;margin-bottom:25px;}
        label{font-weight:bold;display:block;margin-bottom:8px;margin-top:15px;}
        input[type="text"], textarea, select{width:100%;padding:10px;border-radius:6px;border:1px solid #ccc;font-size:15px;}
        button{margin-top:20px;background:#27ae60;color:white;border:none;padding:12px 20px;font-size:16px;border-radius:8px;cursor:pointer;width:100%;}
        button:hover{background:#219150;}
        .back-link{display:inline-block;margin-top:20px;text-decoration:none;color:#2980b9;}
        .back-link:hover{text-decoration:underline;}
    </style>
</head>
<body>
    <header><h1>Tambah Kontak</h1></header>
    <div class="container">
        <h2>Tambah Data Kontak</h2>
        <?php if(isset($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>
        <form method="POST">
            <label>Section</label>
            <select name="section" required>
                <option value="contact">Contact</option>
                <option value="footer">Footer</option>
            </select>

            <label>Type</label>
            <input type="text" name="type" placeholder="contoh: youtube, instagram, email" required>

            <label>Label</label>
            <input type="text" name="label" placeholder="contoh: Instagram" required>

            <label>Value</label>
            <textarea name="value" rows="3" required></textarea>

            <button type="submit" name="save">💾 Simpan</button>
        </form>
        <a href="contact.php" class="back-link">← Kembali ke Daftar Kontak</a>
    </div>
</body>
</html>
