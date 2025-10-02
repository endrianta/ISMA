<?php
include "config.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Ambil semua data pembelajaran
$pembelajaran_result = mysqli_query($conn, "SELECT * FROM pembelajaran ORDER BY id DESC");

// Ambil permintaan akses yang masih PENDING
$pending_requests_sql = "
    SELECT pr.id, pr.nip, pr.created_at, p.title 
    FROM permintaan_akses pr
    JOIN pembelajaran p ON pr.pembelajaran_id = p.id
    WHERE pr.status = 'pending' 
    ORDER BY pr.created_at ASC";
$pending_requests_result = mysqli_query($conn, $pending_requests_sql);

// Ambil riwayat permintaan yang sudah diproses (APPROVED atau REJECTED)
$history_requests_sql = "
    SELECT pr.id, pr.nip, pr.created_at, pr.status, pr.updated_at, p.title
    FROM permintaan_akses pr
    JOIN pembelajaran p ON pr.pembelajaran_id = p.id
    WHERE pr.status IN ('approved', 'rejected')
    ORDER BY pr.updated_at DESC";
$history_requests_result = mysqli_query($conn, $history_requests_sql);

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Materi Pembelajaran - PT. ISMA</title>
  <link rel="icon" type="image/png" href="../assets/img/logo.png">
  <style>
    body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
    .container { max-width: 1200px; margin: 30px auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    h1, h2 { color: #2c3e50; }
    .btn-add { display: inline-block; padding: 10px 16px; background: #27ae60; color: white; border-radius: 6px; text-decoration: none; font-weight: bold; transition: 0.3s; margin-bottom: 20px; }
    .btn-add:hover { background: #219150; }
    .back-link { display: inline-block; margin-bottom: 20px; color: #3498db; text-decoration: none; }
    .back-link:hover { text-decoration: underline; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    table th, table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
    table th { background: #2c3e50; color: white; }
    table tr:hover { background: #f1f1f1; }
    .badge { padding: 5px 10px; border-radius: 12px; color: white; font-size: 0.8em; }
    .bg-info { background-color: #3498db; }
    .bg-warning { background-color: #f39c12; }
    .bg-success { background-color: #27ae60; }
    .bg-danger { background-color: #e74c3c; }
    .action-btn { padding: 6px 12px; border-radius: 5px; font-size: 14px; text-decoration: none; color: white; border: none; cursor: pointer; margin-right: 5px; display: inline-block;}
    .btn-edit { background: #2980b9; }
    .btn-delete { background: #e74c3c; }
    .btn-outline-success { border: 1px solid #27ae60; color: #27ae60; background: transparent; }
    .btn-outline-success:hover { background: #27ae60; color: white; }
    .btn-outline-danger { border: 1px solid #e74c3c; color: #e74c3c; background: transparent; }
    .btn-outline-danger:hover { background: #e74c3c; color: white; }
    .card { border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 30px; }
    .card-header { background-color: #f7f7f7; padding: 15px; border-bottom: 1px solid #e0e0e0; font-weight: bold; }
    .card-body { padding: 20px; }
    .action-group { display: flex; align-items: center; }
  </style>
</head>
<body>
  <div class="container">
    <a href="admin.php" class="back-link">← Kembali ke Dashboard</a>
    <h1>Manajemen Materi Pembelajaran</h1>

    <!-- Daftar Materi -->
    <div class="card">
        <div class="card-header">Daftar Materi</div>
        <div class="card-body">
            <a href="add_pembelajaran.php" class="btn-add">+ Tambah Materi Baru</a>
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($pembelajaran_result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><span class="badge <?= strtolower($row['category']) == 'private' ? 'bg-warning' : 'bg-info' ?>"><?= htmlspecialchars($row['category']) ?></span></td>
                        <td>
                            <a href="edit_pembelajaran.php?id=<?= $row['id'] ?>" class="action-btn btn-edit">Edit</a>
                            <a href="delete_pembelajaran.php?id=<?= $row['id'] ?>" class="action-btn btn-delete" onclick="return confirm('Anda yakin ingin menghapus materi ini beserta file terkait?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Anchor -->
    <div id="permintaan"></div>

    <!-- Permintaan Akses Tertunda -->
    <h2>Permintaan Akses Tertunda</h2>
    <div class="card">
        <div class="card-header">Perlu Persetujuan</div>
        <div class="card-body">
             <table>
                <thead>
                    <tr>
                        <th>Judul Materi</th>
                        <th>NIP Pemohon</th>
                        <th>Waktu Permintaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($pending_requests_result) > 0): ?>
                        <?php while ($req = mysqli_fetch_assoc($pending_requests_result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($req['title']) ?></td>
                            <td><?= htmlspecialchars($req['nip']) ?></td>
                            <td><?= date('d M Y, H:i', strtotime($req['created_at'])) ?></td>
                            <td>
                                <a href="approve_request.php?id=<?= $req['id'] ?>" class="action-btn bg-success">Setujui</a>
                                <a href="reject_request.php?id=<?= $req['id'] ?>" class="action-btn bg-danger">Tolak</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align:center;">Tidak ada permintaan tertunda saat ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Riwayat Permintaan -->
    <h2>Riwayat Permintaan</h2>
    <div class="card">
        <div class="card-header">Disetujui & Ditolak</div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>Judul Materi</th>
                        <th>NIP Pemohon</th>
                        <th>Status</th>
                        <th>Terakhir Diperbarui</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($history_requests_result) > 0): ?>
                        <?php while ($req = mysqli_fetch_assoc($history_requests_result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($req['title']) ?></td>
                            <td><?= htmlspecialchars($req['nip']) ?></td>
                            <td>
                                <?php if ($req['status'] == 'approved'): ?>
                                    <span class="badge bg-success">Disetujui</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d M Y, H:i', strtotime($req['updated_at'])) ?></td>
                            <td>
                                <div class="action-group">
                                    <?php if ($req['status'] == 'approved'): ?>
                                        <a href="reject_request.php?id=<?= $req['id'] ?>" class="action-btn btn-outline-danger">Batalkan</a>
                                    <?php else: ?>
                                        <a href="approve_request.php?id=<?= $req['id'] ?>" class="action-btn btn-outline-success">Setujui Ulang</a>
                                    <?php endif; ?>
                                    <a href="delete_request_history.php?id=<?= $req['id'] ?>" class="action-btn btn-delete" onclick="return confirm('Anda yakin ingin menghapus riwayat permintaan ini secara permanen?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center;">Belum ada riwayat permintaan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

  </div>
</body>
</html>
