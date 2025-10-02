<?php
include "config.php";
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

// pastikan ada ID
if(!isset($_GET['id'])){
    header("Location: structure.php");
    exit();
}

$id = intval($_GET['id']);

// ambil data anggota
$result = mysqli_query($conn, "SELECT * FROM struktur_jabatan WHERE id=$id");
$member = mysqli_fetch_assoc($result);

if(!$member){
    echo "Data tidak ditemukan.";
    exit();
}

// handle update
if(isset($_POST['update'])){
    $nama    = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $urutan  = intval($_POST['urutan']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $foto = $member['foto']; // default: foto lama

    if(!empty($_FILES['foto']['name'])){
        $allowed_ext = ['jpg','jpeg','png','gif','webp'];
        $file_name = $_FILES['foto']['name'];
        $file_tmp  = $_FILES['foto']['tmp_name'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if(in_array($ext, $allowed_ext)){
            $new_name = basename($file_name);
            $target = "../assets/img/structure/".$new_name;

            if(move_uploaded_file($file_tmp, $target)){
                // hapus foto lama
                if(!empty($member['foto']) && file_exists("../assets/img/structure/".$member['foto'])){
                    unlink("../assets/img/structure/".$member['foto']);
                }
                $foto = $new_name;
            }
        } else {
            echo "<p style='color:red;text-align:center;'>Format file tidak didukung!</p>";
        }
    }

    $sql = "UPDATE struktur_jabatan SET 
            nama='$nama', 
            jabatan='$jabatan', 
            urutan=$urutan, 
            deskripsi='$deskripsi', 
            foto='$foto' 
            WHERE id=$id";

    if(mysqli_query($conn, $sql)){
        header("Location: edit_structure.php?id=$id&success=1");
        exit();
    } else {
        echo "<p style='color:red;text-align:center;'>Gagal update data!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Anggota Struktur</title>
<link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
<style>
body {font-family: Arial; background:#f4f6f9; margin:0; padding:0;}
header {background:#2c3e50; color:white; padding:15px 30px; text-align:center;}
.container {max-width:700px; margin:40px auto; background:white; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h2 {text-align:center; color:#2c3e50; margin-bottom:25px;}
label {display:block; margin-top:15px; font-weight:bold;}
input[type=text], input[type=number], textarea, input[type=file] {width:100%; padding:10px; border-radius:6px; border:1px solid #ccc; box-sizing:border-box;}
textarea {height:120px; resize:vertical;}
button {margin-top:20px; background:#27ae60; color:white; border:none; padding:12px 20px; font-size:16px; border-radius:8px; cursor:pointer; width:100%;}
button:hover {background:#219150;}
.back-link {display:inline-block; margin-top:20px; text-decoration:none; color:#2980b9;}
.back-link:hover {text-decoration:underline;}
.preview {margin-top:10px; text-align:center;}
.preview img {margin-top:8px; max-width:200px; border:1px solid #ccc; border-radius:8px;}
.alert-success {background:#d4edda; color:#155724; border:1px solid #c3e6cb; padding:10px; margin-bottom:15px; border-radius:6px; text-align:center;}
</style>
</head>
<body>
<header><h1>Edit Anggota Struktur</h1></header>
<div class="container">
<h2>Edit Anggota</h2>

<?php if(isset($_GET['success'])): ?>
<div class="alert-success">✅ Data berhasil diperbarui!</div>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data">
<label>Nama</label>
<input type="text" name="nama" value="<?= htmlspecialchars($member['nama']) ?>" required>

<label>Jabatan</label>
<input type="text" name="jabatan" value="<?= htmlspecialchars($member['jabatan']) ?>" required>

<label>Urutan</label>
<input type="number" name="urutan" value="<?= $member['urutan'] ?>" required>

<label>Deskripsi</label>
<textarea name="deskripsi"><?= htmlspecialchars($member['deskripsi']) ?></textarea>

<div class="preview">
<p>Foto Saat Ini:</p>
<?php if(!empty($member['foto']) && file_exists("../assets/img/structure/".$member['foto'])): ?>
<img src="../assets/img/structure/<?= htmlspecialchars($member['foto']) ?>" alt="Foto Struktur">
<?php else: ?>
<p><i>Tidak ada foto</i></p>
<?php endif; ?>
</div>

<label>Ganti Foto (Opsional)</label>
<input type="file" name="foto" accept="image/*">

<button type="submit" name="update">💾 Update</button>
</form>
<a href="structure.php" class="back-link">← Kembali</a>
</div>
</body>
</html>
