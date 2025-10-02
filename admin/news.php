<?php 
include "config.php"; 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// fungsi untuk perbaiki path gambar di konten Froala
function fixImagePath($html) {
    return preg_replace_callback('/src="([^"]+)"/', function($matches) {
        $path = str_replace('../', '', $matches[1]); // hilangkan ../
        $dirname = dirname($path);
        $basename = basename($path);
        return 'src="'.$dirname.'/'.rawurlencode($basename).'"';
    }, $html);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Berita - PT. ISMA</title>
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
    vertical-align: top;
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
  .edit { background: #2980b9; }
  .edit:hover { background: #1f6693; }

  .delete { background: #e74c3c; }
  .delete:hover { background: #c0392b; }
  </style>
</head>
<body>
  <header>
    <h1>Kelola Berita</h1>
  </header>

  <div class="container">
    <a href="admin.php" class="back-link">← Kembali</a>
    <h2>Daftar Berita</h2>
    <a href="add_news.php" class="btn-add">+ Tambah Berita</a>
    
    <table>
      <tr>
        <th>Gambar</th>
        <th>Judul</th>
        <th>Tanggal</th>
        <th>Penulis</th>
        <th>Isi Singkat</th>
        <th>Aksi</th>
      </tr>
      <?php
      $result = mysqli_query($conn, "SELECT * FROM news ORDER BY id DESC");
      while($row = mysqli_fetch_assoc($result)){
        // potong isi berita agar tidak terlalu panjang
        $contentPreview = strip_tags(fixImagePath($row['content']));
        $contentPreview = mb_strimwidth($contentPreview, 0, 100, "...");
        
        echo "<tr>
          <td><img src='../assets/img/news/".htmlspecialchars($row['image'])."' alt=''></td>
          <td>".htmlspecialchars($row['title'])."</td>
          <td>".htmlspecialchars($row['date'])."</td>
          <td>".htmlspecialchars($row['author'])."</td>
          <td style='text-align:left'>".$contentPreview."</td>
          <td class='action'>
            <a href='edit_news.php?id=".$row['id']."' class='edit'>Edit</a>
            <a href='delete_news.php?id=".$row['id']."' class='delete' onclick='return confirm(\"Hapus berita ini?\")'>Hapus</a>
          </td>
        </tr>";
      }
      ?>
    </table>
  </div>
</body>
</html>
