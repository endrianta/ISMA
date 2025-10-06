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
  <link rel="icon" type="image/png" href="../assets/img/logo.png">
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

  <style>
    body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
    header { background: #2c3e50; color: white; padding: 15px 30px; text-align: center; }
    .container { max-width: 900px; margin: 40px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    h2 { margin-bottom: 25px; color: #2c3e50; text-align: center; }
    label { font-weight: bold; display: block; margin-bottom: 8px; margin-top: 15px; }
    input[type="text"], input[type="date"], textarea, input[type="file"], select { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; font-size: 15px; box-sizing: border-box; }
    .fr-box { margin-top: 10px; }
    button { margin-top: 20px; background: #27ae60; color: white; border: none; padding: 12px 20px; font-size: 16px; border-radius: 8px; cursor: pointer; transition: 0.3s; width: 100%; }
    button:hover { background: #219150; }
    .back-link { display: inline-block; margin-top: 20px; text-decoration: none; color: #2980b9; }
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

      <label>Lokasi</label>
      <input type="text" name="location" placeholder="Contoh: Jakarta" required>

      <label>Tipe Pekerjaan</label>
      <select name="job_type" required>
        <option value="Penuh Waktu">Penuh Waktu</option>
        <option value="Magang">Magang</option>
        <option value="Kontrak">Kontrak</option>
      </select>

      <label>Tanggal Penutupan Lamaran</label>
      <input type="date" name="closing_date">

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
    $title        = mysqli_real_escape_string($conn, $_POST['title']);
    $description  = mysqli_real_escape_string($conn, $_POST['description']);
    $location     = mysqli_real_escape_string($conn, $_POST['location']);
    $job_type     = mysqli_real_escape_string($conn, $_POST['job_type']);
    $date_posted  = $_POST['date_posted'];
    $closing_date = !empty($_POST['closing_date']) ? "'" . $_POST['closing_date'] . "'" : "NULL";

    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];

    $image_path = "../assets/img/karir/";
    if(!is_dir($image_path)) mkdir($image_path, 0755, true);
    $new_name = time() . "_" . basename($image);
    move_uploaded_file($tmp, $image_path . $new_name);

    $sql = "INSERT INTO karir (title, description, location, job_type, date_posted, closing_date, image, status) 
            VALUES ('$title', '$description', '$location', '$job_type', '$date_posted', $closing_date, '$new_name', 'Dibuka')";
            
    if(mysqli_query($conn, $sql)){
      header("Location: karir.php");
      exit;
    } else {
      echo "<p style='color:red;text-align:center;'>Gagal menyimpan lowongan! Error: " . mysqli_error($conn) . "</p>";
    }
  }
  ?>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
  <script>
    new FroalaEditor('textarea[name="description"]', {
      imageUploadURL: 'upload_image.php',
      imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif', 'webp']
    });
  </script>
</body>
</html>
