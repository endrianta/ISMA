<?php
include "config.php";
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['save'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $jabatan = mysqli_real_escape_string($conn,$_POST['jabatan']);
    $urutan = intval($_POST['urutan']);
    $deskripsi = mysqli_real_escape_string($conn,$_POST['deskripsi'] ?? '');
    
    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];
    if(!is_dir("../assets/img/structure/")) mkdir("../assets/img/structure/",0777,true);
    move_uploaded_file($tmp,"../assets/img/structure/".$image);
    
    $sql = "INSERT INTO struktur_jabatan (nama, jabatan, urutan, deskripsi, foto)
            VALUES ('$name','$jabatan','$urutan','$deskripsi','$image')";
    if(mysqli_query($conn,$sql)){
        header("Location: structure.php");
        exit();
    } else {
        $error = "Gagal menambahkan anggota!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Anggota Struktur</title>
<link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
<style>
body {font-family: Arial; background:#f4f6f9; margin:0; padding:0;}
header {background:#2c3e50; color:white; padding:15px 30px; text-align:center;}
.container {max-width:700px; margin:40px auto; background:white; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h2 {text-align:center; color:#2c3e50; margin-bottom:25px;}
label {display:block; margin-top:15px; font-weight:bold;}
input[type=text], input[type=number], textarea, input[type=file] {width:100%; padding:10px; border-radius:6px; border:1px solid #ccc; box-sizing:border-box;}
textarea {height:120px; resize:vertical;}
button {margin-top:20px; background:#27ae60; color:white; border:none; padding:12px 20px; font-size:16px; border-radius:8px; cursor:pointer; width:100%;}
button:hover {background:#219150;}
.back-link {display:inline-block; margin-top:20px; text-decoration:none; color:#2980b9;}
.back-link:hover {text-decoration:underline;}
.alert-error {background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; padding:10px; margin-bottom:15px; border-radius:6px; text-align:center;}
</style>
</head>
<body>
<header><h1>Tambah Anggota Struktur</h1></header>
<div class="container">
    <h2>Tambah Anggota Baru</h2>
    <?php if(isset($error)) echo "<div class='alert-error'>❌ $error</div>"; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nama</label>
        <input type="text" name="name" required>

        <label>Jabatan</label>
        <input type="text" name="jabatan" required>

        <label>Urutan</label>
        <input type="number" name="urutan" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi"></textarea>

        <label>Foto</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit" name="save">💾 Simpan</button>
    </form>
    <a href="structure.php" class="back-link">← Kembali</a>
</div>
</body>
</html>
