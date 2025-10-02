<?php
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM sub5 ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Sub5 (Mitra)</title>
  <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/logo.png" rel="apple-touch-icon">

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
    table th, table td {
      text-align: center;
      vertical-align: middle;
    }
    .btn-sm {
      margin: 0 3px;
    }
  </style>
</head>
<body style="background:#f5f7fa;">

  <!-- Header Atas -->
  <div class="header-admin">
    Kelola Sub5 (Mitra)
  </div>

  <div class="container my-4">
    <div class="card-custom">
      <a href="admin.php" class="text-decoration-none">&larr; Kembali</a>
      <h3 class="mt-3"></h3>

      <a href="sub5_add.php" class="btn btn-success mb-3">+ Tambah Mitra</a>

      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><img src="../<?= $row['gambar'] ?>" alt="<?= $row['nama'] ?>" style="height:60px;"></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['kategori']) ?></td>
            <td>
              <a href="sub5_edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
              <a href="sub5_delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>