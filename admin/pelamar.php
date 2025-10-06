<?php 
include "config.php"; 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['karir_id'])) {
    header("Location: karir.php");
    exit();
}

$karir_id = intval($_GET['karir_id']);

// Ambil nama lowongan untuk judul
$karir_result = mysqli_query($conn, "SELECT title FROM karir WHERE id=$karir_id");
$karir_data = mysqli_fetch_assoc($karir_result);
$karir_title = $karir_data ? $karir_data['title'] : 'Lowongan Tidak Ditemukan';

// Handle perubahan status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $applicant_id = intval($_POST['applicant_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update_sql = "UPDATE applicants SET status = '$new_status' WHERE id = $applicant_id";
    mysqli_query($conn, $update_sql);
    header("Location: pelamar.php?karir_id=$karir_id");
    exit();
}

// Handle penghapusan pelamar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_applicant'])) {
    $applicant_id_to_delete = intval($_POST['applicant_id']);

    // 1. Ambil path CV sebelum menghapus data dari database
    $cv_query = mysqli_query($conn, "SELECT cv_path FROM applicants WHERE id = $applicant_id_to_delete");
    if ($cv_data = mysqli_fetch_assoc($cv_query)) {
        $cv_file_path = '../' . $cv_data['cv_path'];
        
        // 2. Hapus file CV jika ada
        if (file_exists($cv_file_path)) {
            unlink($cv_file_path);
        }
    }

    // 3. Hapus data dari database
    $delete_sql = "DELETE FROM applicants WHERE id = $applicant_id_to_delete";
    mysqli_query($conn, $delete_sql);

    header("Location: pelamar.php?karir_id=$karir_id");
    exit();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Pelamar - <?php echo htmlspecialchars($karir_title); ?></title>
  <link rel="icon" type="image/png" href="../assets/img/logo.png">
  <style>
  body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
  header { background: #2c3e50; color: white; padding: 15px 30px; text-align: center; }
  .container { max-width: 1300px; margin: 30px auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
  h2 { margin-bottom: 20px; color: #2c3e50; }
  .back-link { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #2980b9; }
  .back-link:hover { text-decoration: underline; }
  table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
  table th, table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; vertical-align: middle; }
  table th { background: #34495e; color: white; text-align: center; }
  table tr:hover { background: #f1f1f1; }
  .cv-link { text-decoration: none; color: #2980b9; font-weight: bold; }
  .cv-link:hover { text-decoration: underline; }
  select { padding: 6px 10px; border-radius: 5px; border: 1px solid #ccc; }
  .btn-update { background: #27ae60; color: white; border: none; padding: 6px 12px; border-radius: 5px; cursor: pointer; width: 100%; }
  .btn-update:hover { background: #219150; }
  .btn-delete { background: #e74c3c; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; width: 100%; }
  .btn-delete:hover { background: #c0392b; }
  .status-text-Baru { color: #3498db; font-weight: bold; }
  .status-text-Ditinjau { color: #f39c12; font-weight: bold; }
  .status-text-Lolos { color: #27ae60; font-weight: bold; }
  .status-text-Ditolak { color: #e74c3c; font-weight: bold; }
  .status-text-Diterima { color: #9b59b6; font-weight: bold; }
  </style>
</head>
<body>
  <header>
    <h1>Kelola Pelamar</h1>
  </header>

  <div class="container">
    <a href="karir.php" class="back-link">← Kembali ke Daftar Lowongan</a>
    <h2>Daftar Pelamar untuk: <u><?php echo htmlspecialchars($karir_title); ?></u></h2>
    
    <table>
      <tr>
        <th>Nama Pelamar</th>
        <th>Kontak</th>
        <th>Tanggal Melamar</th>
        <th>Download CV</th>
        <th style="width: 120px;">Status Saat Ini</th>
        <th style="width: 200px;">Ubah Status</th>
        <th style="width: 100px;">Aksi</th>
      </tr>
      <?php
      $sql = "SELECT * FROM applicants WHERE karir_id = $karir_id ORDER BY apply_date DESC";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)){
            $status_class = 'status-text-' . str_replace(' ', '-', $row['status']);
            echo "<tr>
              <td>".htmlspecialchars($row['name'])."</td>
              <td>".htmlspecialchars($row['email'])."<br>".htmlspecialchars($row['phone'])."</td>
              <td>".date('d M Y, H:i', strtotime($row['apply_date']))."</td>
              <td style='text-align: center;'><a href='../".$row['cv_path']."' target='_blank' class='cv-link'>Unduh CV</a></td>
              <td style='text-align: center;' class='$status_class'>".htmlspecialchars($row['status'])."</td>
              <td>
                <form action='' method='POST' style='display: flex; gap: 5px;'>
                  <input type='hidden' name='applicant_id' value='".$row['id']."'>
                  <select name='status'>
                    <option value='Baru' ".($row['status'] == 'Baru' ? 'selected' : '').">Baru</option>
                    <option value='Ditinjau' ".($row['status'] == 'Ditinjau' ? 'selected' : '').">Ditinjau</option>
                    <option value='Lolos Seleksi Awal' ".($row['status'] == 'Lolos Seleksi Awal' ? 'selected' : '').">Lolos Seleksi Awal</option>
                    <option value='Ditolak' ".($row['status'] == 'Ditolak' ? 'selected' : '').">Ditolak</option>
                    <option value='Diterima' ".($row['status'] == 'Diterima' ? 'selected' : '').">Diterima</option>
                  </select>
                  <button type='submit' name='update_status' class='btn-update'>Update</button>
                </form>
              </td>
              <td style='text-align: center;'>
                <form action='' method='POST' onsubmit=\"return confirm('Apakah Anda yakin ingin menghapus data pelamar ini? Tindakan ini tidak dapat diurungkan dan akan menghapus file CV yang terlampir.');\">
                  <input type='hidden' name='applicant_id' value='".$row['id']."'>
                  <button type='submit' name='delete_applicant' class='btn-delete'>Hapus</button>
                </form>
              </td>
            </tr>";
          }
      } else {
          echo "<tr><td colspan='7' style='text-align: center; padding: 20px;'>Belum ada pelamar untuk lowongan ini.</td></tr>";
      }
      ?>
    </table>
  </div>
</body>
</html>
