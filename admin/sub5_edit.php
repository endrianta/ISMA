<?php
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM sub5 WHERE id='$id'");
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Mitra</title>
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
    Edit Mitra
  </div>

  <div class="container my-4">
    <div class="card-custom">
      
      <h3 class="mt-3">Edit Data Mitra</h3>

      <form action="sub5_update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div class="mb-3">
          <label for="nama" class="form-label">Nama Mitra</label>
          <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>

        <div class="mb-3">
  <label for="kategori" class="form-label">Kategori</label>
  <select class="form-control" id="kategori" name="kategori" required>
    <option value="Pelindo Group" <?= ($data['kategori'] == 'Pelindo Group') ? 'selected' : '' ?>>Pelindo Group</option>
    <option value="Non Pelindo" <?= ($data['kategori'] == 'Non Pelindo') ? 'selected' : '' ?>>Non Pelindo</option>
    <option value="Organisasi" <?= ($data['kategori'] == 'Organisasi') ? 'selected' : '' ?>>Organisasi</option>
  </select>
</div>


        <div class="mb-3">
          <label for="gambar" class="form-label">Gambar</label><br>
          <img src="../<?= $data['gambar'] ?>" alt="<?= $data['nama'] ?>" style="height:80px; margin-bottom:10px;"><br>
          <input type="file" class="form-control" id="gambar" name="gambar">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="sub5_list.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>

</body>
</html>