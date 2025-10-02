<?php
session_start();
include "config.php";

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil semua data sub1
$result = mysqli_query($conn, "SELECT * FROM sub1 ORDER BY section, id");
$data = [];
while($row = mysqli_fetch_assoc($result)) {
    $data[$row['section']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Sub1 - PT. ISMA</title>
    <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
    <style>
        body{font-family:Arial,sans-serif;background:#f4f6f9;margin:0;padding:0;}
        header{background:#2c3e50;color:white;padding:15px 30px;text-align:center;}
        .container{max-width:1100px;margin:30px auto;background:white;padding:25px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
        h2{margin-bottom:20px;color:#2c3e50;}
        .btn-add{display:inline-block;padding:10px 16px;background:#27ae60;color:white;border-radius:6px;text-decoration:none;font-weight:bold;margin-bottom:15px;}
        .btn-add:hover{background:#219150;}
        table{width:100%;border-collapse:collapse;margin-top:20px;}
        table th, table td{padding:12px;text-align:center;border-bottom:1px solid #ddd;}
        table th{background:#2c3e50;color:white;}
        table tr:hover{background:#f1f1f1;}
        img{border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.2);max-width:80px;}
        .action{display:flex;flex-direction:column;gap:8px;justify-content:center;align-items:center;}
        .action a{padding:6px 12px;border-radius:5px;font-size:14px;text-decoration:none;color:white;width:80px;text-align:center;}
        .edit{background:#2980b9;} .edit:hover{background:#1f6693;}
        .delete{background:#e74c3c;} .delete:hover{background:#c0392b;}
    </style>
</head>
<body>
    <header><h1>Kelola Sub1 (Aspek Hukum)</h1></header>
    <div class="container">
        <a href="admin.php" class="back-link">← Kembali</a>
        
        <!-- Sertifikasi -->
        <h2 id="sertifikasi">Sertifikasi</h2>
        <a href="sub1_form.php?section=sertifikasi" class="btn-add">+ Tambah Sertifikasi</a>
        <table>
            <tr>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Aksi</th>
            </tr>
            <?php foreach($data['sertifikasi'] ?? [] as $row): ?>
            <tr>
                <td><img src="../<?= $row['gambar'] ?>" alt=""></td>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td class="action">
                    <a href="sub1_form.php?id=<?= $row['id'] ?>" class="edit">Edit</a>
                    <a href="sub1_delete.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Mandatory -->
        <h2 id="mandatory">Mandatory</h2>
        <a href="sub1_form.php?section=mandatory" class="btn-add">+ Tambah Mandatory</a>
        <table>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
            <?php foreach($data['mandatory'] ?? [] as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                <td class="action">
                    <a href="sub1_form.php?id=<?= $row['id'] ?>" class="edit">Edit</a>
                    <a href="sub1_delete.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Landasan -->
        <h2 id="landasan">Landasan</h2>
        <a href="sub1_form.php?section=landasan" class="btn-add">+ Tambah Landasan</a>
        <table>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
            <?php foreach($data['landasan'] ?? [] as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                <td class="action">
                    <a href="sub1_form.php?id=<?= $row['id'] ?>" class="edit">Edit</a>
                    <a href="sub1_delete.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
