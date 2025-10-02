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
  <title>Tambah Berita - PT. ISMA</title>
  <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
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
      max-width: 900px;
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
    <h1>Tambah Berita</h1>
  </header>

  <div class="container">
    <h2>Tambah Berita Baru</h2>
    <form action="" method="POST" enctype="multipart/form-data">
      <label>Judul</label>
      <input type="text" name="title" required>

      <label>Isi Berita</label>
      <textarea name="content" required></textarea>

      <!-- Field baru: Penjelasan Rinci -->
      <label>Penjelasan Rinci</label>
      <textarea name="detail" placeholder="Tambahkan analisis lebih dalam, data tambahan, atau penjelasan lanjutan"></textarea>

      <label>Tanggal</label>
      <input type="date" name="date" required>

      <label>Penulis</label>
      <input type="text" name="author" required>

      <label>Gambar</label>
      <input type="file" name="image" accept="image/*" required>

      <button type="submit" name="save">💾 Simpan</button>
    </form>

    <a href="news.php" class="back-link">← Kembali ke Daftar Berita</a>
  </div>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
  <script>
    new FroalaEditor('textarea[name="content"]', {
      imageUploadURL: 'upload_image.php',
      imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif']
    });
    // new FroalaEditor('textarea[name="content"]');
    new FroalaEditor('textarea[name="detail"]');
  </script>

  <?php
  if(isset($_POST['save'])){
    $title   = mysqli_real_escape_string($conn,$_POST['title']);
    $content = mysqli_real_escape_string($conn,$_POST['content']);
    $detail  = mysqli_real_escape_string($conn,$_POST['detail'] ?? '');
    $date    = $_POST['date'];
    $author  = mysqli_real_escape_string($conn,$_POST['author']);

    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];

    if(!is_dir("../assets/img/news/")) mkdir("../assets/img/news/");
    move_uploaded_file($tmp, "../assets/img/news/".$image);

    $sql = "INSERT INTO news (title, content, detail, date, author, image) 
            VALUES ('$title','$content','$detail','$date','$author','$image')";
    if(mysqli_query($conn,$sql)){
      header("Location: news.php");
      exit;
    } else {
      echo "<p style='color:red;text-align:center;'>Gagal menyimpan berita!</p>";
    }
  }
  ?>
</body>
</html>
