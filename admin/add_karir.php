<?php 
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Lowongan Karir - PT. ISMA</title>
  <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 0;
    }
    header {
      background: #2c3e50;
      color: white;
      padding: 15px 30px;
      text-align: center;
    }
    .container {
      max-width: 700px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    h2 {
      margin-bottom: 25px;
      color: #2c3e50;
      text-align: center;
    }
    label {
      font-weight: bold;
      display: block;
      margin-bottom: 8px;
      margin-top: 15px;
    }
    input[type="text"], input[type="date"], textarea, input[type="file"] {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
      box-sizing: border-box;
    }
    textarea { height: 150px; resize: vertical; }
    button {
      margin-top: 20px;
      background: #27ae60;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
      width: 100%;
    }
    button:hover { background: #219150; }
    .back-link {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #2980b9;
    }
    .back-link:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <header>
    <h1>Tambah Lowongan Karir</h1>
  </header>

  <div class="container">
    <h2>Tambah Lowongan Baru</h2>
    <form action="" method="POST" enctype="multipart/form-data">
      <label>Judul</label>
      <input type="text" name="title" required>

      <label>Deskripsi</label>
      <textarea name="description" required></textarea>

      <label>Tanggal Posting</label>
      <input type="date" name="date_posted" required>

      <label>Gambar</label>
      <input type="file" name="image" accept="image/*" required>

      <button type="submit" name="save">💾 Simpan</button>
    </form>

    <a href="karir.php" class="back-link">← Kembali ke Daftar Lowongan</a>
  </div>

  <?php
  if(isset($_POST['save'])){
    $title       = mysqli_real_escape_string($conn,$_POST['title']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $date_posted = $_POST['date_posted'];

    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];

    $image_path = "../assets/img/karir/";
    if(!is_dir($image_path)) mkdir($image_path, 0755, true);
    move_uploaded_file($tmp, $image_path . $image);

    $sql = "INSERT INTO karir (title, description, date_posted, image) 
            VALUES ('$title','$description','$date_posted','$image')";
    if(mysqli_query($conn,$sql)){
      header("Location: karir.php");
      exit;
    } else {
      echo "<p style='color:red;text-align:center;'>Gagal menyimpan lowongan!</p>";
    }
  }
  ?>
</body>
</html>
