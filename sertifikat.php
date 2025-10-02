<?php
include "admin/config.php";

// --- Pagination ---
$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Hitung total data
$result_count = mysqli_query($conn, "SELECT COUNT(*) AS total FROM sertifikat");
$row_count = mysqli_fetch_assoc($result_count);
$total = $row_count['total'];
$pages = ceil($total / $limit);

// Ambil data sertifikat
$data = mysqli_query($conn, "SELECT * FROM sertifikat ORDER BY tahun_terbit DESC, created_at DESC LIMIT $start, $limit");

// --- Ambil data footer ---
$footerQuery = "SELECT * FROM contact WHERE section='footer'";
$footerResult = $conn->query($footerQuery);
$footerData = [];
while ($rowFooter = $footerResult->fetch_assoc()) {
    $footerData[$rowFooter['type']] = $rowFooter['value'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title> Sertifikat - PT. ISMA</title>

  <link href="assets/img/logo.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Amatic+SC:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet" />
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />
  <link href="assets/css/main.css" rel="stylesheet" />

  <style>
    .card-img-top, .pdf-placeholder {
      height: 220px;
      object-fit: cover;
      cursor: pointer; /* Add pointer cursor */
    }
    .pdf-placeholder {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa;
    }
    .card {
      display: flex;
      flex-direction: column;
      height: 100%;
    }
    .card-body {
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }
    .card-body .btn {
      margin-top: auto;   /* paksa tombol ke bawah */
      width: 100%;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header id="header" class="header fixed-top bg-white shadow-sm">
      <div class="container d-flex align-items-center justify-content-between py-2">
        <!-- Logo -->
        <a href="index.php" class="d-inline-flex align-items-center">
          <img src="assets/img/logoisma.png" alt="Logo" class="img-fluid" style="height: 60px" />
        </a>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-md">
          <ul class="navbar-nav ms-auto fw-bold">
            <!-- Dropdown Home -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="index.php" data-bs-toggle="dropdown" onclick="window.location='index.php';"> Beranda </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="sub1.php">Aspek Hukum</a></li>
                <li><a class="dropdown-item" href="sub2.php">Susunan Pemegang Saham dan Organisasi</a></li>
                <li><a class="dropdown-item" href="sub3.php">Bisnis Proses dan Layanan</a></li>
                <li><a class="dropdown-item" href="sub4.php">Sebaran Tenaga Kerja</a></li>
                <li><a class="dropdown-item" href="sub5.php">Mitra</a></li>
              </ul>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="index.php" data-bs-toggle="dropdown" onclick="window.location='index.php#about';">Tentang Kami</a>
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
              <li class="nav-item"><a class="nav-link" href="admin/login.php">Masuk</a></li>
              <!-- Dropdown Bahasa -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://flagcdn.com/w20/id.png" class="me-1"> ID
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="#" onclick="translatePage('id','ID')">
                    <img src="https://flagcdn.com/w20/id.png" class="me-2"> Indonesia
                  </a>
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="#" onclick="translatePage('en','EN')">
                    <img src="https://flagcdn.com/w20/us.png" class="me-2"> English
                  </a>
                </li>
              </ul>
            </li>

            <!-- Google Translate (disembunyikan) -->
            <div id="google_translate_element" style="display:none;"></div>
            <script type="text/javascript">
              function googleTranslateElementInit() {
                new google.translate.TranslateElement(
                  {
                    pageLanguage: 'id',
                    includedLanguages: 'id,en',
                    autoDisplay: false
                  },
                  'google_translate_element'
                );
              }

              function translatePage(lang, label) {
                // ganti isi dropdown header
                document.getElementById("languageDropdown").innerHTML =
                  '<img src="https://flagcdn.com/w20/' + (lang === 'id' ? 'id' : 'us') + '.png" class="me-1"> ' + label;

                // trigger translate
                var select = document.querySelector(".goog-te-combo");
                if (select) {
                  select.value = lang;
                  select.dispatchEvent(new Event("change"));
                }
              }
            </script>
            <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
          </ul>
        </nav>
      </div>
    </header>


  <!-- Main -->
  <main id="main">
    <section class="container my-5">
      <div class="row g-4" id="news-container" style="margin-top: 50px;">
        <div class="container" data-aos="fade-up">
          <div class="row align-items-center g-4">
            <div class="col-lg-12 text-center" data-aos="fade-up" data-aos-delay="100">
              <div class="container my-4 flex-grow-1">
                <div class="card-custom">
                <div class="row">
                    <?php if(mysqli_num_rows($data) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($data)): ?>
                        <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php 
                            $ext = strtolower(pathinfo($row['file_sertifikat'], PATHINFO_EXTENSION));
                            $filePath = "assets/img/sertifikat/" . htmlspecialchars($row['file_sertifikat']);
                            
                            $glightbox_attrs = 'href="'. $filePath .'" class="glightbox" data-gallery="sertifikat-gallery" data-title="'. htmlspecialchars($row['nama_sertifikat']) .' ('. $row['tahun_terbit'] .')"';

                            if($ext === 'pdf'): 
                                // For PDF, specify iframe type
                                $glightbox_attrs .= ' data-type="iframe"';
                            ?>
                                <a <?= $glightbox_attrs ?>>
                                    <div class="pdf-placeholder">
                                        <i class="bi bi-filetype-pdf" style="font-size: 80px; color: #dc3545;"></i>
                                    </div>
                                </a>
                            <?php else: ?>
                                <a <?= $glightbox_attrs ?>>
                                  <img src="<?= $filePath ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama_sertifikat']) ?>">
                                </a>
                            <?php endif; ?>
                            <div class="card-body text-center">
                            <h6 class="fw-bold"><?= htmlspecialchars($row['nama_perusahaan']) ?></h6>
                            <p class="small"><?= htmlspecialchars($row['nama_sertifikat']) ?> (<?= $row['tahun_terbit'] ?>)</p>
                            </div>
                        </div>
                        </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="fw-bold mt-4">Belum ada data sertifikat.</p>
                    </div>
                    <?php endif; ?>
                </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php
      // Ambil data footer
      $footerQuery = "SELECT * FROM contact WHERE section='footer'";
      $footerResult = mysqli_query($conn, $footerQuery);

      // Simpan di array biar gampang dipanggil
      $footerData = [];
      while ($row = mysqli_fetch_assoc($footerResult)) {
        $footerData[$row['type']] = $row['value'];
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
              <p class="mb-0"><?php echo $footerData['Alamat']; ?></p>
            </div>
          </div>

          <!-- Hubungi -->
          <div class="col-md-4 d-flex flex-column align-items-center">
            <i class="bi bi-telephone fs-3 mb-2"></i>
            <div>
              <h5 class="fw-bold">Hubungi</h5>
              <p class="mb-0">
                <strong>Email:</strong> <br /><?php echo $footerData['Email']; ?> <br />
                <strong>Whatsapp:</strong> <br /><a href="https://wa.me/<?php echo $footerData['Nomor']; ?>"><?php echo $footerData['Nomor']; ?></a>
              </p>
            </div>
          </div>

          <!-- Tersedia -->
          <div class="col-md-4 d-flex flex-column align-items-center">
            <i class="bi bi-clock fs-3 mb-2"></i>
            <div>
              <h5 class="fw-bold">Tersedia</h5>
              <p class="mb-0">
                <strong>Senin - Jumat:</strong> <br /><?php echo $footerData['Waktu']; ?><br />
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
  <script src="assets/vendor/aos/aos.js"></script> 
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>

  <!-- Initialize GLightbox -->
  <script>
    const lightbox = GLightbox({
      selector: '.glightbox',
      width: '85vw', // Set width for all lightboxes
      height: '90vh' // Set height for all lightboxes
    });
  </script>
</body>
</html>
