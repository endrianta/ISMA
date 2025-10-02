<?php
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kategori = $_POST['kategori'];
    $nama = $_POST['nama'];
    $gambar = $_FILES['gambar']['name'];

    $targetDir = "../assets/img/mitra/";
    $targetFile = $targetDir . basename($gambar);

    // path yang disimpan ke database
    $dbPath = "assets/img/mitra/" . basename($gambar);

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
        $query = "INSERT INTO sub5 (kategori, nama, gambar) 
                  VALUES ('$kategori', '$nama', '$dbPath')";
        mysqli_query($conn, $query);
        header("Location: sub5_list.php?msg=✅ Mitra berhasil ditambahkan!");
        exit();
    } else {
        $error = "Gagal upload gambar.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Mitra</title>
  <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
  <link rel="icon" href="assets/img/logo.png" type="image/png">
  <link rel="apple-touch-icon" href="assets/img/logo.png">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    .header-admin {
      background-color: #2c3e50;
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 22px;
      font-weight: bold;
    }
    .card-custom {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      margin-top: -30px;
    }
  </style>
</head>
<body style="background:#f5f7fa;">

  <!-- Header Atas -->
  <div class="header-admin">
    Tambah Mitra
  </div>

  <div class="container my-4">
    <div class="card-custom">
      
      <h3 class="mt-3">Tambah Data Mitra</h3>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label>Kategori</label>
          <select name="kategori" class="form-control" required>
            <option value="Pelindo Group">Pelindo Group</option>
            <option value="Non Pelindo">Non Pelindo</option>
            <option value="Organisasi">Organisasi</option>
          </select>
        </div>
        <div class="mb-3">
          <label>Nama Mitra</label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Upload Logo</label>
          <input type="file" name="gambar" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="sub5_list.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>

</body>
</html>
