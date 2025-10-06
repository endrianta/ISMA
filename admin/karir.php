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
  body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
  header { background: #2c3e50; color: white; padding: 15px 30px; text-align: center; }
  .container { max-width: 1200px; margin: 30px auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
  h2 { margin-bottom: 20px; color: #2c3e50; }
  .btn-add { display: inline-block; padding: 10px 16px; background: #27ae60; color: white; border-radius: 6px; text-decoration: none; font-weight: bold; transition: 0.3s; margin-bottom: 15px; }
  .btn-add:hover { background: #219150; }
  table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
  table th, table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
  table th { background: #2c3e50; color: white; text-align: center; }
  table tr:hover { background: #f1f1f1; }
  img { border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.2); max-width: 80px; }
  .action { display: flex; gap: 8px; justify-content: center; align-items: center; }
  .action a { padding: 6px 12px; border-radius: 5px; text-decoration: none; color: white; }
  .edit { background: #2980b9; }
  .edit:hover { background: #1f6693; }
  .delete { background: #e74c3c; }
  .delete:hover { background: #c0392b; }
  .status-badge { padding: 4px 8px; border-radius: 10px; color: white; font-size: 12px; font-weight: bold; }
  .status-dibuka { background: #27ae60; }
  .status-ditutup { background: #c0392b; }
  .applicant-link { text-decoration: none; color: #3498db; font-weight: bold; }
  .applicant-link:hover { text-decoration: underline; }
  .back-link { display: inline-block; margin-bottom: 15px; text-decoration: none; color: #2980b9; }
  .back-link:hover { text-decoration: underline; }
  td, th { vertical-align: middle; text-align: center; }
  </style>
</head>
<body>
  <header>
    <h1>Kelola Karir</h1>
  </header>

  <div class="container">
    <a href="admin.php" class="back-link">← Kembali ke Dashboard</a>
    <h2>Daftar Lowongan Karir</h2>
    <a href="add_karir.php" class="btn-add">+ Tambah Lowongan</a>
    
    <table>
      <tr>
        <th>Gambar</th>
        <th>Judul</th>
        <th>Lokasi</th>
        <th>Tipe</th>
        <th>Status</th>
        <th>Pelamar</th>
        <th>Aksi</th>
      </tr>
      <?php
      $sql = "SELECT k.*, (SELECT COUNT(a.id) FROM applicants a WHERE a.karir_id = k.id) as applicant_count 
              FROM karir k 
              ORDER BY k.id DESC";
      $result = mysqli_query($conn, $sql);

      while($row = mysqli_fetch_assoc($result)){
        $status_class = $row['status'] == 'Dibuka' ? 'status-dibuka' : 'status-ditutup';
        echo "<tr>
          <td><img src='../assets/img/karir/".htmlspecialchars($row['image'])."' width='80'></td>
          <td>".htmlspecialchars($row['title'])."</td>
          <td>".htmlspecialchars($row['location'])."</td>
          <td>".htmlspecialchars($row['job_type'])."</td>
          <td><span class='status-badge $status_class'>".htmlspecialchars($row['status'])."</span></td>
          <td>
            <a href='pelamar.php?karir_id=". $row['id'] ."' class='applicant-link'>
              ". $row['applicant_count'] ." Pelamar
            </a>
          </td>
          <td class='action'>
            <a href='edit_karir.php?id=". $row['id'] ."' class='edit'>Edit</a>
            <a href='delete_karir.php?id=". $row['id'] ."' class='delete' onclick='return confirm(\"Hapus lowongan ini? Menghapus lowongan juga akan menghapus semua data pelamar terkait.\")'>Hapus</a>
          </td>
        </tr>";
      }
      ?>
    </table>
  </div>
</body>
</html>
