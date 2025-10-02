<?php
include "config.php"; 
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

// Ambil semua anggota struktur
$result = mysqli_query($conn, "SELECT * FROM struktur_jabatan ORDER BY urutan ASC");
$members = [];
while($row = mysqli_fetch_assoc($result)){
    $members[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Struktur - PT. ISMA</title>
<link rel="icon" href="../assets/img/pelindo2.png">
<style>
body {font-family: Arial; background:#f4f6f9; margin:0; padding:0;}

/* header utama biar nempel */
header {
    background:#2c3e50;
    color:white;
    padding:15px 30px;
    text-align:center;
    position: fixed;   /* selalu nempel di atas */
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}

/* kasih jarak biar konten gak ketiban header */
.container {
    max-width:1100px;
    margin:100px auto 30px auto; /* jarak atas agar tidak ketiban header */
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

h2 {margin-bottom:20px; color:#2c3e50;}
.btn-add {
    display:inline-block;
    padding:10px 16px;
    background:#27ae60;
    color:white;
    border-radius:6px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
    margin-bottom:15px;
}
.btn-add:hover {background:#219150;}

/* tabel biasa */
table {width:100%; border-collapse: collapse; margin-top:20px;}
table th, table td {padding:12px; text-align:center; border-bottom:1px solid #ddd; vertical-align:middle;}
table th {background:#2c3e50; color:white;}
table tr:hover {background:#f1f1f1;}
img {border-radius:8px; max-width:80px; box-shadow:0 2px 6px rgba(0,0,0,0.2);}

/* tombol aksi */
td.action {text-align: center; vertical-align: middle;}
td.action a {
    padding:6px 12px;
    border-radius:5px;
    font-size:14px;
    text-decoration:none;
    color:white;
    margin: 0 4px;
    display: inline-block;
}
.edit {background:#2980b9;} .edit:hover {background:#1f6693;}
.delete {background:#e74c3c;} .delete:hover {background:#c0392b;}
</style>
</head>
<body>
<header>
<h1>Kelola Struktur</h1>
</header>

<div class="container">
<a href="admin.php" class="back-link">← Kembali</a>
<h2>Daftar Anggota Struktur</h2>
<a href="add_structure.php" class="btn-add">+ Tambah Anggota</a>

<table>
<tr>
<th>Foto</th>
<th>Nama</th>
<th>Jabatan</th>
<th>Deskripsi</th>
<th>Aksi</th>
</tr>

<?php foreach($members as $member): ?>
<tr>
<td>
<?php if(!empty($member['foto']) && file_exists("../assets/img/structure/".$member['foto'])): ?>
    <img src="../assets/img/structure/<?= htmlspecialchars($member['foto']) ?>" alt="<?= htmlspecialchars($member['jabatan']) ?>">
<?php else: ?>
    <img src="../assets/img/structure/default.jpg" alt="Kosong">
<?php endif; ?>
</td>
<td><?= htmlspecialchars($member['nama']) ?></td>
<td><?= htmlspecialchars($member['jabatan']) ?></td>
<td><?= htmlspecialchars($member['deskripsi']) ?></td>
<td class="action">
    <a href="edit_structure.php?id=<?= $member['id'] ?>" class="edit">Edit</a>
    <a href="delete_structure.php?id=<?= $member['id'] ?>" class="delete" onclick="return confirm('Hapus anggota ini?')">Hapus</a>
</td>
</tr>
<?php endforeach; ?>

</table>
</div>
</body>
</html>