<?php
include "admin/config.php"; // koneksi database
include "fungsi_track_image.php"; // koneksi database

// cek apakah ada id di URL
if (!isset($_GET['id'])) {
    header("Location: news.php");
    exit();
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM news WHERE id = $id");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<h2>Berita tidak ditemukan!</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($row['title']); ?> - PT. ISMA</title>
  <link href="assets/img/logo.png" rel="icon" />
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/main.css" rel="stylesheet" />
  <style>
    .content-text {
      text-align: justify;
      font-size: 1.05rem;
      line-height: 1.6;
    }
    .detail-section {
      margin-top: 40px;
      padding: 20px;
      background: #f8f9fa;
      border-left: 5px solid #007bff;
      border-radius: 8px;
    }
    .detail-section h4 {
      color: #007bff;
      margin-bottom: 15px;
    }
    .card-img-top {
      width: 100%;
      height: auto;
      max-height: 500px; /* Batasi tinggi gambar agar tidak terlalu besar */
      object-fit: cover; /* Agar gambar tidak gepeng */
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="bg-white text-black py-3">
    <div class="container mt-3">
      <a href="news.php" class="btn btn-primary btn-sm">← Kembali ke Berita</a>
    </div>
  </header>

  <!-- Isi Berita -->
  <main class="container my-5">
    <div class="card shadow-sm border-0">
      <img src="assets/img/news/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
      <div class="card-body">
        <h2 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h2>
        <p class="text-muted"><?php echo htmlspecialchars($row['date']); ?> | <?php echo htmlspecialchars($row['author']); ?></p>
        <hr>
        <!-- Isi utama berita -->
        <div class="content-text">
          <?php echo fixImagePath($row['content']); ?>
        </div>

        <!-- Penjelasan rinci -->
        <?php if (!empty($row['detail'])): ?>
        <div class="detail-section">
          <h4>Penjelasan Rinci</h4>
          <div class="content-text">

            <?php echo $row['detail']; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <?php
      // Ambil data footer
      $footerQuery = "SELECT * FROM contact WHERE section='footer'";
      $footerResult = mysqli_query($conn, $footerQuery);

      // Simpan di array biar gampang dipanggil
      $footerData = [];
      while ($footer_row = mysqli_fetch_assoc($footerResult)) {
        $footerData[$footer_row['type']] = $footer_row['value'];
      }
    ?>

    <footer id="footer" class="footer bg-dark pt-5 pb-3" style="background-image: url('assets/img/bg3.png'); background-size: cover; background-position: center;">
      <div class="container">
        <div class="row gy-4 justify-content-center text-center">

          <!-- Alamat -->
          <div class="col-md-4 d-flex flex-column align-items-center">
            <i class="bi bi-geo-alt fs-3 mb-2"></i>
            <div>
              <h5 class="fw-bold">Alamat</h5>
              <p class="mb-0"><?php echo htmlspecialchars($footerData['Alamat'] ?? '-'); ?></p>
            </div>
          </div>

          <!-- Hubungi -->
          <div class="col-md-4 d-flex flex-column align-items-center">
            <i class="bi bi-telephone fs-3 mb-2"></i>
            <div>
              <h5 class="fw-bold">Hubungi</h5>
              <p class="mb-0">
                <strong>Email:</strong> <br /><?php echo htmlspecialchars($footerData['Email'] ?? '-'); ?> <br />
                <strong>Whatsapp:</strong> <br /><a href="https://wa.me/<?php echo htmlspecialchars($footerData['Nomor'] ?? '#'); ?>"><?php echo htmlspecialchars($footerData['Nomor'] ?? '-'); ?></a>
              </p>
            </div>
          </div>

          <!-- Tersedia -->
          <div class="col-md-4 d-flex flex-column align-items-center">
            <i class="bi bi-clock fs-3 mb-2"></i>
            <div>
              <h5 class="fw-bold">Tersedia</h5>
              <p class="mb-0">
                <strong>Senin - Jumat:</strong> <br /><?php echo htmlspecialchars($footerData['Waktu'] ?? '-'); ?><br />
                <strong>Sabtu - Minggu:</strong> <br />Tutup
              </p>
            </div>
          </div>
        </div>

        <hr class="border-secondary my-4" />
        <div class="text-center small">© Hak Cipta <strong>PT. INTAN SEJAHTERA UTAMA</strong>.</div>
      </div>
    </footer>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>