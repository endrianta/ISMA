<?php
include "admin/config.php";

// Logika untuk filter dan pencarian
$where_clauses = ["status = 'Dibuka'"];
$search_term = '';
$location_filter = '';
$type_filter = '';

if (!empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $where_clauses[] = "(title LIKE '%$search_term%' OR description LIKE '%$search_term%')";
}
if (!empty($_GET['location'])) {
    $location_filter = mysqli_real_escape_string($conn, $_GET['location']);
    $where_clauses[] = "location = '$location_filter'";
}
if (!empty($_GET['type'])) {
    $type_filter = mysqli_real_escape_string($conn, $_GET['type']);
    $where_clauses[] = "job_type = '$type_filter'";
}

$sql = "SELECT * FROM karir WHERE " . implode(' AND ', $where_clauses) . " ORDER BY date_posted DESC";
$result = mysqli_query($conn, $sql);

// Ambil data untuk filter dropdown
$locations = mysqli_query($conn, "SELECT DISTINCT location FROM karir WHERE status = 'Dibuka' ORDER BY location");
$job_types = mysqli_query($conn, "SELECT DISTINCT job_type FROM karir WHERE status = 'Dibuka' ORDER BY job_type");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Karir - PT. ISMA</title>

  <link href="assets/img/logo.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Amatic+SC:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet" />
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />
  <link href="assets/css/main.css" rel="stylesheet" />

</head>
<body>
  <!-- Header -->
   <header id="header" class="header bg-white shadow-sm" style="padding-top: 25px; padding-bottom: 80px; position: fixed; top: 0; left: 0; right: 0; z-index: 1030;">
      <div class="container d-flex align-items-center justify-content-between py-2">
        <a href="index.php" class="d-inline-flex align-items-center">
          <img src="assets/img/logoisma.png" alt="Logo" class="img-fluid" style="height: 60px" />
        </a>
        <nav class="navbar navbar-expand-md">
          <ul class="navbar-nav ms-auto fw-bold">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="index.php" data-bs-toggle="dropdown" onclick="window.location='#';"> Beranda </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="sub1.php">Aspek Hukum</a></li>
                <li><a class="dropdown-item" href="sub2.php">Susunan Pemegang Saham dan Organisasi</a></li>
                <li><a class="dropdown-item" href="sub3.php">Bisnis Proses dan Layanan</a></li>
                <li><a class="dropdown-item" href="sub4.php">Sebaran Tenaga Kerja</a></li>
                <li><a class="dropdown-item" href="sub5.php">Mitra</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" onclick="window.location='#about';">Tentang Kami</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="sertifikat.php">Sertifikat</a></li>
                <li><a class="dropdown-item" href="karir.php">Karir</a></li> 
                <li><a class="dropdown-item" href="pembelajaran.php">Materi Pembelajaran</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="index.php#news">Berita</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php#structure">Struktur</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php#moment">Momen</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php#contact">Kontak</a></li>
          </ul>
        </nav>
      </div>
    </header>


  <!-- Main -->
  <main id="main">
    <section class="container" style="padding-top: 150px; padding-bottom: 50px;">
      <div class="section-header text-center mb-5">
          <h2>Temukan Karir Impian Anda</h2>
          <p>Bergabunglah dengan tim kami yang dinamis dan berdedikasi.</p>
      </div>

      <!-- Filter Section -->
      <div class="mb-5 p-3 bg-light rounded">
        <form action="karir.php" method="GET">
          <div class="row g-2 align-items-end">
            <div class="col-md-5">
              <label for="search" class="form-label">Kata Kunci</label>
              <input type="text" id="search" name="search" class="form-control" placeholder="Posisi, keahlian..." value="<?php echo htmlspecialchars($search_term); ?>">
            </div>
            <div class="col-md-2">
              <label for="location" class="form-label">Lokasi</label>
              <select id="location" name="location" class="form-select">
                <option value="">Semua</option>
                <?php while($loc = mysqli_fetch_assoc($locations)): ?>
                  <option value="<?php echo htmlspecialchars($loc['location']); ?>" <?php echo ($location_filter == $loc['location']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($loc['location']); ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-md-2">
              <label for="type" class="form-label">Tipe</label>
              <select id="type" name="type" class="form-select">
                <option value="">Semua</option>
                <?php while($type = mysqli_fetch_assoc($job_types)): ?>
                  <option value="<?php echo htmlspecialchars($type['job_type']); ?>" <?php echo ($type_filter == $type['job_type']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($type['job_type']); ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-md-3 d-flex">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
                <a href="karir.php" class="btn btn-outline-secondary ms-2">Reset</a>
            </div>
          </div>
        </form>
      </div>

      <!-- Karir List -->
      <div id="karir-container">
        <?php if(mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="list-group-item list-group-item-action mb-3 p-4 shadow-sm rounded-3">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 fw-bold"><a href="detail_karir.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark"><?php echo htmlspecialchars($row['title']); ?></a></h5>
                    <small class="text-muted">Posted: <?php echo date("d M Y", strtotime($row['date_posted'])); ?></small>
                </div>
                <p class="mb-1 text-muted">
                    <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['location']); ?> 
                    <span class="mx-2">|</span>
                    <i class="bi bi-briefcase"></i> <?php echo htmlspecialchars($row['job_type']); ?>
                </p>
                <a href="detail_karir.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
            <div class="text-center mt-4">
                <p>Maaf, tidak ada lowongan yang sesuai dengan kriteria Anda saat ini.</p>
            </div>
        <?php endif; ?>
      </div>

    </section>
  </main>

   <!-- Footer -->
  <?php
      $footerQuery = "SELECT * FROM contact WHERE section='footer'";
      $footerResult = mysqli_query($conn, $footerQuery);
      $footerData = [];
      while ($row = mysqli_fetch_assoc($footerResult)) {
        $footerData[$row['type']] = $row['value'];
      }
    ?>
    <footer id="footer" class="footer bg-dark pt-5 pb-3" style="background-image: url('assets/img/bg3.png'); background-size: cover; background-position: center;">
      <div class="container">
        <div class="row gy-4 justify-content-center text-center">
          <div class="col-md-4 d-flex flex-column align-items-center">
            <i class="bi bi-geo-alt fs-3 mb-2"></i>
            <div><h5 class="fw-bold">Alamat</h5><p class="mb-0"><?php echo $footerData['Alamat']; ?></p></div>
          </div>
          <div class="col-md-4 d-flex flex-column align-items-center">
            <i class="bi bi-telephone fs-3 mb-2"></i>
            <div><h5 class="fw-bold">Hubungi</h5><p class="mb-0"><strong>Email:</strong> <br /><?php echo $footerData['Email']; ?> <br /><strong>Whatsapp:</strong> <br /><a href="https://wa.me/<?php echo $footerData['Nomor']; ?>"><?php echo $footerData['Nomor']; ?></a></p></div>
          </div>
          <div class="col-md-4 d-flex flex-column align-items-center">
            <i class="bi bi-clock fs-3 mb-2"></i>
            <div><h5 class="fw-bold">Tersedia</h5><p class="mb-0"><strong>Senin - Jumat:</strong> <br /><?php echo $footerData['Waktu']; ?><br /><strong>Sabtu - Minggu:</strong> <br />Tutup</p></div>
          </div>
        </div>
        <hr class="border-secondary my-4" />
        <div class="text-center small">© Hak Cipta <strong>PT. INTAN SEJAHTERA UTAMA</strong>.</div>
      </div>
    </footer>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>

</body>
</html>
