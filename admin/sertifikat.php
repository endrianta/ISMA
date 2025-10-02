<?php
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data sertifikat, urut berdasarkan tahun terbit terbaru dulu, lalu created_at
$result = mysqli_query($conn, "SELECT * FROM sertifikat ORDER BY tahun_terbit DESC, created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Sertifikat</title>
  <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
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
    img.preview-img {
      max-width: 100px;
      max-height: 80px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
  </style>
</head>
<body style="background:#f5f7fa;">

  <!-- Header Atas -->
  <div class="header-admin">
    Kelola Sertifikat
  </div>

  <div class="container my-4">
    <div class="card-custom">
      <a href="admin.php" class="text-decoration-none">&larr; Kembali</a>
      <h3 class="mt-3 mb-3">Daftar Sertifikat</h3>

      <a href="add_sertifikat.php" class="btn btn-success mb-3">+ Tambah Sertifikat</a>

      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nama Perusahaan</th>
            <th>Nama Sertifikat</th>
            <th>Tahun Terbit</th>
            <th>File</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
            <td><?= htmlspecialchars($row['nama_sertifikat']) ?></td>
            <td><?= $row['tahun_terbit'] ?></td>
            <td>
              <?php
                $fileName = $row['file_sertifikat'];
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $filePath = "../assets/img/sertifikat/" . $fileName;

                if (in_array($ext, ['jpg','jpeg','png','gif','webp']) && file_exists($filePath)) {
                    echo '<img src="'.htmlspecialchars($filePath).'" alt="File Sertifikat" class="preview-img">';
                } elseif ($ext === 'pdf' && file_exists($filePath)) {
                    $link = '../view_pdf.php?file=' . urlencode($fileName);
                    echo '<a href="'.htmlspecialchars($link).'" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>';
                } elseif (file_exists($filePath)) {
                    echo '<a href="'.htmlspecialchars($filePath).'" target="_blank" class="btn btn-primary btn-sm">Lihat File</a>';
                } else {
                    echo '<span style="color:red;">File tidak ditemukan</span>';
                }
              ?>
            </td>
            <td>
              <a href="edit_sertifikat.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="delete_sertifikat.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>