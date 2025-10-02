<?php
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_perusahaan = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $nama_sertifikat  = mysqli_real_escape_string($conn, $_POST['nama_sertifikat']);
    $tahun_terbit     = mysqli_real_escape_string($conn, $_POST['tahun_terbit']); // full tanggal

    // Validasi tanggal (server-side)
    if ($tahun_terbit > date('Y-m-d')) {
        $error = "Tanggal terbit tidak boleh lebih dari hari ini.";
    }

    if (empty($error)) {
        $file_name = $_FILES['file_sertifikat']['name'];
        $tmp_name  = $_FILES['file_sertifikat']['tmp_name'];
        $file_size = $_FILES['file_sertifikat']['size'];
        $target_dir = "../assets/img/sertifikat/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

        $max_size = 1048576; // 1MB
        $allowed_ext = ['pdf','jpg','jpeg','png'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_size > $max_size) {
            $error = "Ukuran file terlalu besar. Maksimal 1MB.";
        } elseif (!in_array($ext, $allowed_ext)) {
            $error = "File tidak diperbolehkan. Hanya PDF, JPG, JPEG, PNG.";
        } else {
            $new_file_name = time().'_'.$file_name;
            if (move_uploaded_file($tmp_name, $target_dir.$new_file_name)) {
                $sql = "INSERT INTO sertifikat (nama_perusahaan, nama_sertifikat, tahun_terbit, file_sertifikat, created_at) 
                        VALUES ('$nama_perusahaan','$nama_sertifikat','$tahun_terbit','$new_file_name', NOW())";
                if (mysqli_query($conn, $sql)) {
                    header("Location: sertifikat.php?msg=✅ Sertifikat berhasil ditambahkan!");
                    exit();
                } else {
                    $error = "Terjadi kesalahan: " . mysqli_error($conn);
                }
            } else {
                $error = "Gagal upload file.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Sertifikat</title>
  <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

  <!-- Flatpickr CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

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

  <div class="header-admin">
    Tambah Sertifikat
  </div>

  <div class="container my-4">
    <div class="card-custom">
      <h3 class="mt-3">Tambah Data Sertifikat</h3>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data" id="sertifikatForm">
        <div class="mb-3">
          <label class="form-label">Nama Perusahaan</label>
          <input type="text" name="nama_perusahaan" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Nama Sertifikat</label>
          <input type="text" name="nama_sertifikat" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Tanggal Terbit</label>
          <input type="text" id="tanggalTerbit" name="tahun_terbit" class="form-control" required>
          <div id="dateError" class="text-danger mt-1" style="display:none;"></div>
        </div>
        <div class="mb-3">
          <label class="form-label">File Sertifikat (PDF/JPG/PNG)</label>
          <input type="file" name="file_sertifikat" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="sertifikat.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>

  <!-- Flatpickr JS + Locale Indonesia -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
  <script>
    flatpickr("#tanggalTerbit", {
      dateFormat: "Y-m-d",
      maxDate: "today",
      minDate: "1900-01-01",
      defaultDate: "today",
      locale: "id"  // aktifkan bahasa Indonesia
    });

    // Validasi tambahan client-side
    document.getElementById("sertifikatForm").addEventListener("submit", function(e) {
      const dateInput = document.getElementById("tanggalTerbit");
      const errorDiv = document.getElementById("dateError");
      const today = new Date().toISOString().split("T")[0];

      if (dateInput.value > today) {
        e.preventDefault();
        errorDiv.style.display = "block";
        errorDiv.textContent = "Tanggal terbit tidak boleh lebih dari hari ini.";
        dateInput.focus();
      } else {
        errorDiv.style.display = "none";
      }
    });
  </script>

</body>
</html>
