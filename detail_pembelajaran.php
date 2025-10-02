<?php
session_start();
include __DIR__ . '/../admin/config.php';

// 1. Dapatkan ID materi dari URL
if (!isset($_GET['id'])) {
    die("Error: ID Materi tidak ditemukan.");
}
$pembelajaran_id = (int)$_GET['id'];

// 2. Verifikasi Keamanan Sesi
// Cek apakah user punya NIP di sesi & punya izin spesifik untuk video ini
if (!isset($_SESSION['user_nip']) || !isset($_SESSION['can_access_'.$pembelajaran_id]) || $_SESSION['can_access_'.$pembelajaran_id] !== true) {
    // Jika tidak ada izin sesi, coba verifikasi ulang dari database (sebagai fallback)
    if(isset($_SESSION['user_nip'])){
        $nip = $_SESSION['user_nip'];
        $check_approved_sql = "SELECT id FROM permintaan_akses WHERE nip = ? AND status = 'approved' LIMIT 1";
        $stmt = $conn->prepare($check_approved_sql);
        $stmt->bind_param("s", $nip);
        $stmt->execute();
        $approved_result = $stmt->get_result();
        if($approved_result->num_rows == 0){
            die("<h1>Akses Ditolak</h1><p>Anda tidak memiliki izin untuk melihat halaman ini. Silakan kembali dan minta akses terlebih dahulu.</p><a href='pembelajaran.php'>Kembali ke Materi</a>");
        }
    } else {
        die("<h1>Akses Ditolak</h1><p>Sesi Anda tidak valid atau telah berakhir. Silakan kembali dan masukkan NIP Anda lagi.</p><a href='pembelajaran.php'>Kembali ke Materi</a>");
    }
}

// 3. Ambil detail materi dari database
$query = "SELECT * FROM pembelajaran WHERE id = ? AND category = 'Private'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pembelajaran_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: Materi tidak ditemukan atau bukan materi privat.");
}
$materi = $result->fetch_assoc();

// Tentukan path video
$video_path = "#";
if (!empty($materi['video'])) {
    if (filter_var($materi['video'], FILTER_VALIDATE_URL)) {
        $video_path = htmlspecialchars($materi['video']);
    } else {
        // Path relatif dari root website
        $video_path = "../assets/videos/pembelajaran/" . htmlspecialchars($materi['video']);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menonton: <?= htmlspecialchars($materi['title']) ?> - PT. ISMA</title>
    <base href="../">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/main.css" rel="stylesheet" />
    <style>
        body { padding-top: 120px !important; background-color: #f4f7f6; }
        .video-container { max-width: 900px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        .video-player { position: relative; padding-bottom: 56.25%; /* 16:9 */ height: 0; overflow: hidden; max-width: 100%; background: #000; margin-bottom: 20px; border-radius: 8px; }
        .video-player video, .video-player iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
        .materi-title { color: #2c3e50; font-weight: 600; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px; }
        .materi-description { color: #555; line-height: 1.7; }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../header.php'; ?>
    <main id="main">
        <div class="container">
            <div class="video-container">
                <h2 class="materi-title"><?= htmlspecialchars($materi['title']) ?></h2>
                
                <?php if ($video_path !== "#"): ?>
                    <div class="video-player">
                        <?php if (filter_var($materi['video'], FILTER_VALIDATE_URL)): ?>
                            <iframe src="<?= $video_path ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <?php else: ?>
                            <video controls width="100%">
                                <source src="<?= $video_path ?>" type="video/mp4">
                                Browser Anda tidak mendukung pemutaran video ini.
                            </video>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">Video untuk materi ini belum tersedia.</div>
                <?php endif; ?>
                
                <div class="materi-description">
                    <p><?= nl2br(htmlspecialchars($materi['description'])) ?></p>
                </div>
                <hr>
                <a href="ISMA/pembelajaran.php" class="btn btn-primary">&larr; Kembali ke Daftar Materi</a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/../footer.php'; ?>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
