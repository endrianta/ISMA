<?php
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: sertifikat.php");
    exit();
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM sertifikat WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if(!$row){
    echo "Data sertifikat tidak ditemukan.";
    exit();
}

$error = '';
$success = false;

if(isset($_POST['update'])){
    $nama_perusahaan = mysqli_real_escape_string($conn,$_POST['nama_perusahaan']);
    $nama_sertifikat = mysqli_real_escape_string($conn,$_POST['nama_sertifikat']);
    $tanggal_terbit = mysqli_real_escape_string($conn,$_POST['tanggal_terbit']);
    $file_name = $row['file_sertifikat'];

    // Validasi tanggal tidak boleh lebih dari hari ini
    if ($tanggal_terbit > date('Y-m-d')) {
        $error = "Tanggal terbit tidak boleh lebih dari hari ini.";
    }

    if(empty($error)){
        if(!empty($_FILES['file_sertifikat']['name'])){
            $uploadDir = "../assets/img/sertifikat/";
            if(!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $new_file_name = time().'_'.basename($_FILES['file_sertifikat']['name']);
            $targetFile = $uploadDir.$new_file_name;

            // hapus file lama
            if(!empty($row['file_sertifikat']) && file_exists($uploadDir.$row['file_sertifikat'])){
                unlink($uploadDir.$row['file_sertifikat']);
            }

            // upload file baru
            if(move_uploaded_file($_FILES['file_sertifikat']['tmp_name'], $targetFile)){
                $file_name = $new_file_name;
            } else {
                $error = "Gagal upload file baru.";
            }
        }

        if(empty($error)){
            $sql = "UPDATE sertifikat SET 
                    nama_perusahaan='$nama_perusahaan', 
                    nama_sertifikat='$nama_sertifikat', 
                    tahun_terbit='$tanggal_terbit',
                    file_sertifikat='$file_name' 
                    WHERE id=$id";
            if(mysqli_query($conn,$sql)){
                $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM sertifikat WHERE id=$id"));
                $success = true;
            } else {
                $error = "Gagal update sertifikat: ".mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Sertifikat</title>
<link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<style>
body { font-family: Arial, sans-serif; background:#f4f6f9; margin:0; padding:0;}
header { background:#2c3e50; color:white; padding:15px 30px; text-align:center;}
.container { max-width:700px; margin:40px auto; background:white; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h2{text-align:center; margin-bottom:25px;}
label{font-weight:bold; display:block; margin-bottom:8px; margin-top:15px;}
input[type="text"], input[type="file"]{ width:100%; padding:10px; border-radius:6px; border:1px solid #ccc; font-size:15px;}
button{margin-top:20px; background:#27ae60; color:white; border:none; padding:12px 20px; font-size:16px; border-radius:8px; cursor:pointer; width:100%;}
button:hover{background:#219150;}
.back-link{display:inline-block; margin-top:20px; text-decoration:none; color:#2980b9;}
.back-link:hover{text-decoration:underline;}
.preview{margin-top:10px;text-align:center;}
.preview a{color:#2c3e50;}
.alert-success{background:#d4edda;color:#155724;border:1px solid #c3e6cb;padding:10px;margin-bottom:15px;border-radius:6px;text-align:center;}
.alert-error{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;padding:10px;margin-bottom:15px;border-radius:6px;text-align:center;}
</style>
</head>
<body>
<header><h1>Edit Sertifikat</h1></header>
<div class="container">
<h2>Edit Sertifikat</h2>

<?php if($success): ?>
<div class="alert-success">✅ Data berhasil diperbarui!</div>
<?php endif; ?>

<?php if(!empty($error)): ?>
<div class="alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data" id="editForm">
    <label>Nama Perusahaan</label>
    <input type="text" name="nama_perusahaan" value="<?= htmlspecialchars($row['nama_perusahaan']) ?>" required>

    <label>Nama Sertifikat</label>
    <input type="text" name="nama_sertifikat" value="<?= htmlspecialchars($row['nama_sertifikat']) ?>" required>

    <label>Tanggal Terbit</label>
    <input type="text" id="tanggalTerbit" name="tanggal_terbit" 
           value="<?= htmlspecialchars($row['tahun_terbit']) ?>" required>
    <div id="dateError" class="text-danger mt-1" style="display:none;"></div>

    <div class="preview">
        <p>File Sertifikat Saat Ini:</p>
        <?php if(!empty($row['file_sertifikat']) && file_exists("../assets/img/sertifikat/".$row['file_sertifikat'])): ?>
            <?php 
                $ext = strtolower(pathinfo($row['file_sertifikat'], PATHINFO_EXTENSION));
                if(in_array($ext, ['jpg','jpeg','png','gif','webp'])): 
            ?>
                <img src="../assets/img/sertifikat/<?= htmlspecialchars($row['file_sertifikat']) ?>" alt="File Sertifikat" style="max-width:200px;border:1px solid #ccc;padding:5px;border-radius:8px;">
            <?php else: ?>
                <a href="../assets/img/sertifikat/<?= htmlspecialchars($row['file_sertifikat']) ?>" target="_blank"><?= htmlspecialchars($row['file_sertifikat']) ?></a>
            <?php endif; ?>
        <?php else: ?>
            <p><i>Tidak ada file</i></p>
        <?php endif; ?>
    </div>

    <label>Ganti File Sertifikat (PDF/JPG/PNG)</label>
    <input type="file" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png">

    <button type="submit" name="update">💾 Update</button>
</form>

<a href="sertifikat.php" class="back-link">← Kembali ke Daftar Sertifikat</a>
</div>

<!-- Flatpickr JS + Locale Indonesia -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
flatpickr("#tanggalTerbit", {
  dateFormat: "Y-m-d",
  maxDate: "today",
  minDate: "1900-01-01",
  locale: "id"
});

// Validasi client-side
document.getElementById("editForm").addEventListener("submit", function(e) {
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
