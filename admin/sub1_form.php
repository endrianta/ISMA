<?php
session_start();
include "config.php";

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil section atau id jika edit
$section = $_GET['section'] ?? '';
$id = $_GET['id'] ?? '';

$judul = "";
$deskripsi = "";
$gambar = "";
$isEdit = false;

// Jika edit data
if (!empty($id)) {
    $isEdit = true;
    $res = mysqli_query($conn, "SELECT * FROM sub1 WHERE id='$id'");
    $row = mysqli_fetch_assoc($res);
    if ($row) {
        $section = $row['section'];
        $judul = $row['judul'];
        $deskripsi = $row['deskripsi'];
        $gambar = $row['gambar'];
    }
}

// Simpan data ketika submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);

    // Upload gambar jika ada
    if (!empty($_FILES['gambar']['name'])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_" . basename($_FILES["gambar"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
            $gambar = "uploads/" . $fileName;
        }
    }

    if ($isEdit) {
        // Update
        $sql = "UPDATE sub1 SET judul='$judul', deskripsi='$deskripsi', gambar='$gambar' WHERE id='$id'";
    } else {
        // Insert
        $sql = "INSERT INTO sub1 (section, judul, deskripsi, gambar) VALUES ('$section', '$judul', '$deskripsi', '$gambar')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_sub1.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $isEdit ? "Edit" : "Tambah" ?> <?= ucfirst($section) ?> - Sub1</title>
    <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
    <style>
        body{font-family:Arial;background:#f4f6f9;margin:0;padding:0;}
        .container{max-width:700px;margin:40px auto;background:white;padding:25px;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,0.1);}
        h2{color:#2c3e50;}
        label{display:block;margin:10px 0 5px;}
        input,textarea{width:100%;padding:10px;margin-bottom:15px;border:1px solid #ccc;border-radius:6px;}
        .btn{padding:10px 20px;background:#27ae60;color:white;border:none;border-radius:6px;cursor:pointer;}
        .btn:hover{background:#219150;}
        .back{margin-top:10px;display:inline-block;text-decoration:none;color:#2980b9;}
        img{max-width:150px;margin-bottom:10px;}
    </style>
</head>
<body>
<div class="container">
    <h2><?= $isEdit ? "Edit" : "Tambah" ?> <?= ucfirst($section) ?></h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="section" value="<?= htmlspecialchars($section) ?>">
        
        <label>Judul</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($judul) ?>" required>

        <?php if ($section != "sertifikasi"): ?>
        <label>Deskripsi</label>
        <textarea name="deskripsi" rows="4"><?= htmlspecialchars($deskripsi) ?></textarea>
        <?php endif; ?>

        <?php if ($section == "sertifikasi"): ?>
        <label>Gambar</label>
        <?php if ($gambar): ?>
            <img src="../<?= $gambar ?>" alt="">
        <?php endif; ?>
        <input type="file" name="gambar">
        <?php endif; ?>

        <button type="submit" class="btn"><?= $isEdit ? "Update" : "Simpan" ?></button>
    </form>
    <a href="admin_sub1.php" class="back">← Kembali</a>
</div>
</body>
</html>
