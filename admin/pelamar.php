<?php 
include "config.php"; 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$karir_id = filter_input(INPUT_GET, 'karir_id', FILTER_VALIDATE_INT);
if (!$karir_id) {
    header("Location: karir.php");
    exit();
}

// Ambil nama lowongan untuk judul menggunakan prepared statement
$stmt = $conn->prepare("SELECT title FROM karir WHERE id = ?");
$stmt->bind_param("i", $karir_id);
$stmt->execute();
$result = $stmt->get_result();
$karir_data = $result->fetch_assoc();
$karir_title = $karir_data ? $karir_data['title'] : 'Lowongan Tidak Ditemukan';
$stmt->close();

// Handle perubahan status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $applicant_id = filter_input(INPUT_POST, 'applicant_id', FILTER_VALIDATE_INT);
    $new_status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE applicants SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $applicant_id);
    $stmt->execute();
    $stmt->close();

    header("Location: pelamar.php?karir_id=$karir_id");
    exit();
}

// Handle penghapusan pelamar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_applicant'])) {
    $applicant_id_to_delete = filter_input(INPUT_POST, 'applicant_id', FILTER_VALIDATE_INT);

    // 1. Ambil path CV sebelum menghapus data dari database
    $stmt = $conn->prepare("SELECT cv_path FROM applicants WHERE id = ?");
    $stmt->bind_param("i", $applicant_id_to_delete);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($cv_data = $result->fetch_assoc()) {
        // Path yang benar adalah di dalam folder uploads/cv/ dari direktori admin
        $cv_file_path = __DIR__ . '/uploads/cv/' . $cv_data['cv_path'];
        
        // 2. Hapus file CV jika ada
        if (file_exists($cv_file_path)) {
            unlink($cv_file_path);
        }
    }
    $stmt->close();

    // 3. Hapus data dari database
    $stmt = $conn->prepare("DELETE FROM applicants WHERE id = ?");
    $stmt->bind_param("i", $applicant_id_to_delete);
    $stmt->execute();
    $stmt->close();

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
  body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
  header { background: #2c3e50; color: white; padding: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
  .container { max-width: 1400px; margin: 2rem auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
  h1, h2 { color: #2c3e50; }
  h2 { margin-bottom: 1.5rem; border-bottom: 2px solid #ecf0f1; padding-bottom: 0.5rem; }
  .back-link { display: inline-block; margin-bottom: 1.5rem; text-decoration: none; color: #2980b9; font-weight: 500; }
  .back-link:hover { text-decoration: underline; }
  table { width: 100%; border-collapse: collapse; font-size: 0.95em; }
  table th, table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e0e0e0; vertical-align: middle; }
  table th { background: #34495e; color: white; text-transform: uppercase; letter-spacing: 0.5px; }
  table tr:nth-child(even) { background: #f9f9f9; }
  table tr:hover { background: #f1f1f1; }
  .cv-link { text-decoration: none; color: #2980b9; font-weight: bold; }
  .cv-link:hover { text-decoration: underline; }
  select, button { padding: 8px 12px; border-radius: 5px; border: 1px solid #ccc; font-size: 1em; }
  .btn-update { background: #27ae60; color: white; border-color: #27ae60; cursor: pointer; }
  .btn-update:hover { background: #219150; }
  .btn-delete { background: #e74c3c; color: white; border-color: #e74c3c; cursor: pointer; }
  .btn-delete:hover { background: #c0392b; }
  .status-badge { padding: 4px 8px; border-radius: 12px; color: white; font-weight: 500; font-size: 0.8em; }
  .status-Pending { background-color: #3498db; }
  .status-Ditinjau { background-color: #f39c12; }
  .status-Ditolak { background-color: #e74c3c; }
  .status-Diterima { background-color: #9b59b6; }
  </style>
</head>
<body>
  <header>
    <h1 style="margin:0; text-align: center;">Kelola Pelamar</h1>
  </header>

  <div class="container">
    <a href="karir.php" class="back-link">← Kembali ke Daftar Lowongan</a>
    <h2>Daftar Pelamar untuk: <u><?php echo htmlspecialchars($karir_title); ?></u></h2>
    
    <table>
      <thead>
        <tr>
          <th>Nama Pelamar</th>
          <th>Kontak</th>
          <th>Tanggal Melamar</th>
          <th style="text-align: center;">CV</th>
          <th style="text-align: center;">Status</th>
          <th style="width: 220px; text-align: center;">Ubah Status</th>
          <th style="text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $stmt = $conn->prepare("SELECT * FROM applicants WHERE karir_id = ? ORDER BY apply_date DESC");
        $stmt->bind_param("i", $karir_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
              $status_class = 'status-' . str_replace(' ', '-', $row['status']);
              echo "<tr>
                <td>".htmlspecialchars($row['name'])."</td>
                <td>".htmlspecialchars($row['email'])."<br>".htmlspecialchars($row['phone'])."</td>
                <td>".date('d M Y, H:i', strtotime($row['apply_date']))."</td>
                <td style='text-align: center;'><a href='uploads/cv/".htmlspecialchars($row['cv_path'])."' target='_blank' class='cv-link'>Unduh</a></td>
                <td style='text-align: center;'><span class='status-badge ".$status_class."' >".htmlspecialchars($row['status'])."</span></td>
                <td>
                  <form action='pelamar.php?karir_id=$karir_id' method='POST' style='display: flex; gap: 5px;'>
                    <input type='hidden' name='applicant_id' value='".$row['id']."'>
                    <select name='status'>
                      <option value='Pending' ".($row['status'] == 'Pending' ? 'selected' : '').">Pending</option>
                      <option value='Ditinjau' ".($row['status'] == 'Ditinjau' ? 'selected' : '').">Ditinjau</option>
                      <option value='Ditolak' ".($row['status'] == 'Ditolak' ? 'selected' : '').">Ditolak</option>
                      <option value='Diterima' ".($row['status'] == 'Diterima' ? 'selected' : '').">Diterima</option>
                    </select>
                    <button type='submit' name='update_status' class='btn-update'>Update</button>
                  </form>
                </td>
                <td style='text-align: center;'>
                  <form action='pelamar.php?karir_id=$karir_id' method='POST' onsubmit=\"return confirm('Anda yakin ingin menghapus data pelamar ini? Tindakan ini akan menghapus file CV secara permanen.');\">
                    <input type='hidden' name='applicant_id' value='".$row['id']."'>
                    <button type='submit' name='delete_applicant' class='btn-delete'>Hapus</button>
                  </form>
                </td>
              </tr>";
            }
        } else {
            echo "<tr><td colspan='7' style='text-align: center; padding: 20px;'>Belum ada pelamar untuk lowongan ini.</td></tr>";
        }
        $stmt->close();
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
