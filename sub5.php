<?php
include "admin/config.php";

// Ambil semua data mitra dari database
$result = mysqli_query($conn, "SELECT * FROM sub5 ORDER BY id DESC");

// Kelompokkan berdasarkan kategori
$mitra = [];
while ($row = mysqli_fetch_assoc($result)) {
    $mitra[$row['kategori']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Mitra PT. ISMA</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <link href="assets/img/logo.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Amatic+SC:wght@400;700&family=Inter:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <link href="assets/css/main.css" rel="stylesheet" />

    <style>
      #header.header {
        transition: background-color 0.2s ease;
      }
      .nav-link.active {
        color: dodgerblue !important;
      }
      section {
        padding: 30px 0;
      }
      #footer .bi {
        line-height: 1;
      }
      .hover-zoom {
        transition: transform 0.3s ease;
      }
      .hover-zoom:hover {
        transform: scale(1.05);
      }

      /* === Perbaikan ukuran box mitra === */
      .mitra-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        padding: 12px;
        height: 200px; /* tinggi seragam */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
      }
      .mitra-card img {
        max-width: 100%;
        max-height: 120px; /* biar logo fit */
        object-fit: contain;
        margin-bottom: 8px;
      }
      .mitra-card p {
        font-size: 14px;
        font-weight: 600;
        margin: 0;
      }
    </style>
  </head>

  <body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="70" tabindex="0">
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
                <!-- INI YANG SAYA TAMBAHKAN -->
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


    <main id="main">
      <!-- Hero -->
      <section class="position-relative text-white">
        <img src="assets/img/kapal (1).jpg" class="img-fluid w-100" style="object-fit: cover; max-height: 400px" alt="Kapal Maritim" />
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 60, 120, 0.55); max-height: 430px"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-center">
          <h1 class="fw-bold display-5">Mitra</h1>
          <p class="lead">PT. Intan Sejahtera Utama (ISMA)</p>
        </div>
      </section>

      <!-- Sertifikasi -->
      <section class="container my-5">
        <div class="card border-0 shadow-lg p-4" data-aos="fade-up">
          <h3 class="text-center fw-bold mb-4 text-primary">Sertifikasi & Standar</h3>
          <div class="row text-center g-4">
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
              <div class="p-3 bg-white rounded shadow-sm h-100 hover-zoom">
                <img src="assets/img/iso.png" alt="ISO" class="img-fluid" style="max-height: 120px" />
                <p class="mt-2 fw-semibold">ISO 9001:2015</p>
              </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
              <div class="p-3 bg-white rounded shadow-sm h-100 hover-zoom">
                <img src="assets/img/ukas.png" alt="UKAS" class="img-fluid" style="max-height: 120px" />
                <p class="mt-2 fw-semibold">UKAS Management Systems</p>
              </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
              <div class="p-3 bg-white rounded shadow-sm h-100 hover-zoom">
                <img src="assets/img/qr.png" alt="QR Code" class="img-fluid" style="max-height: 120px" />
                <p class="mt-2 fw-semibold">Registrasi QR</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Mitra -->
      <!-- Mitra -->
<section class="container my-5">
  <div class="card border-0 shadow-lg p-4" data-aos="fade-up">
    <div class="d-flex align-items-center mb-4">
      <div class="flex-grow-1"></div>
      <h3 class="text-center fw-bold text-primary mb-0" style="margin-left: 150px;">Mitra Kami</h3>
      <div class="flex-grow-1 text-end">
        <img src="assets/img/logoisma.png" alt="Logo ISMA" class="img-fluid" style="height: 60px; object-fit: contain;">
      </div>
    </div>

    <?php 
      // Tampilkan Pelindo Group paling atas
      if (isset($mitra['Pelindo Group'])): ?>
        <h5 class="fw-semibold mb-3 text-secondary">Pelindo Group</h5>
        <div class="row text-center g-4 mb-4">
          <?php foreach ($mitra['Pelindo Group'] as $m): ?>
            <div class="col-6 col-md-2">
              <div class="mitra-card hover-zoom">
                <img src="<?= htmlspecialchars($m['gambar']) ?>" alt="<?= htmlspecialchars($m['nama']) ?>">
                <p><?= htmlspecialchars($m['nama']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php 
      // Tampilkan kategori lain (selain Pelindo Group & Organisasi)
      foreach ($mitra as $kategori => $items): 
        if (!in_array($kategori, ['Pelindo Group', 'Organisasi'])): ?>
          <h5 class="fw-semibold mb-3 text-secondary"><?= htmlspecialchars($kategori) ?></h5>
          <div class="row text-center g-4 mb-4">
            <?php foreach ($items as $m): ?>
              <div class="col-6 col-md-2">
                <div class="mitra-card hover-zoom">
                  <img src="<?= htmlspecialchars($m['gambar']) ?>" alt="<?= htmlspecialchars($m['nama']) ?>">
                  <p><?= htmlspecialchars($m['nama']) ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
    <?php 
        endif;
      endforeach; 
    ?>

    <?php 
      // Tampilkan Organisasi paling bawah
      if (isset($mitra['Organisasi'])): ?>
        <h5 class="fw-semibold mb-3 text-secondary">Organisasi</h5>
        <div class="row text-center g-4 mb-4">
          <?php foreach ($mitra['Organisasi'] as $m): ?>
            <div class="col-6 col-md-2">
              <div class="mitra-card hover-zoom">
                <img src="<?= htmlspecialchars($m['gambar']) ?>" alt="<?= htmlspecialchars($m['nama']) ?>">
                <p><?= htmlspecialchars($m['nama']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
    <?php endif; ?>
  </div>
</section>

    </main>

    <!-- Footer -->
    <?php
      // Ambil data footer
      $footerQuery = "SELECT * FROM contact WHERE section='footer'";
      $footerResult = $conn->query($footerQuery);

      $footerData = [];
      while ($row = $footerResult->fetch_assoc()) {
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

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
