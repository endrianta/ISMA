<?php 
include "config.php"; 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Karir - PT. ISMA</title>
  <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
  <style> 
  body {
  font-family: Arial, sans-serif;
  background: #f4f6f9;
  margin: 0;
  padding: 0;
}

header {
  background: #2c3e50;
  color: white;
  padding: 15px 30px;
  text-align: center;
}

.container {
  max-width: 1100px;
  margin: 30px auto;
  background: white;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

h2 {
  margin-bottom: 20px;
  color: #2c3e50;
}

.btn-add {
  display: inline-block;
  padding: 10px 16px;
  background: #27ae60;
  color: white;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  transition: 0.3s;
  margin-bottom: 15px; /* beri jarak dari tabel */
}
.btn-add:hover { background: #219150; }

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

table th, table td {
  padding: 12px;
  text-align: center;
  border-bottom: 1px solid #ddd;
}

table th {
  background: #2c3e50;
  color: white;
}

table tr:hover {
  background: #f1f1f1;
}

img {
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  max-width: 80px;
}

/* Action buttons container */
.action {
  display: flex;
  gap: 8px;               /* jarak antar tombol */
  justify-content: flex-start; /* rata kiri */
  align-items: center;    /* vertikal: tengah teks */
  height: 100%;           /* pakai tinggi sel */
  padding-top: 40px;       /* geser sedikit ke bawah */
}

.action a {
  padding: 6px 12px;
  border-radius: 5px;
  font-size: 14px;
  text-decoration: none;
  color: white;
}



/* Warna tombol */
.edit {
  background: #2980b9;
}
.edit:hover {
  background: #1f6693;
}

.delete {
  background: #e74c3c;
}
.delete:hover {
  background: #c0392b;
}
</style>
</head>
<body>
  <header>
    <h1>Kelola Karir</h1>
  </header>

  <div class="container">
    <a href="admin.php" class="back-link">← Kembali</a>
    <h2>Daftar Lowongan Karir</h2>
    <a href="add_karir.php" class="btn-add">+ Tambah Lowongan</a>
    
    <table>
      <tr>
        <th>Gambar</th>
        <th>Judul</th>
        <th>Tanggal Posting</th>
        <th>Aksi</th>
      </tr>
      <?php
      $result = mysqli_query($conn, "SELECT * FROM karir ORDER BY id DESC");
      while($row = mysqli_fetch_assoc($result)){
        echo "<tr>
          <td><img src='../assets/img/karir/".$row['image']."' width='80'></td>
          <td>".$row['title']."</td>
          <td>".$row['date_posted']."</td>
          <td class='action'>
            <a href='edit_karir.php?id=".$row['id']."' class='edit'>Edit</a>
            <a href='delete_karir.php?id=".$row['id']."' class='delete' onclick='return confirm(\"Hapus lowongan ini?\")'>Hapus</a>
          </td>
        </tr>";
      }
      ?>
    </table>
  </div>
</body>
</html>
