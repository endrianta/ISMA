<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Aspek Hukum PT. ISMA</title>
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
      /* Header */
      #header.header {
        transition: background-color 0.2s ease;
      }
      .nav-link.active {
        color: dodgerblue !important;
      }
      /* Section generic spacing */
      section {
        padding: 30px 0;
      }
      /* Footer */
      #footer .bi {
        line-height: 1;
      }

      /* Aspek Hukum Styles */
      .hover-zoom {
        transition: transform 0.3s ease;
      }
      .hover-zoom:hover {
        transform: scale(1.05);
      }
      .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
      .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
      }
      .maritime-img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
        transition: transform 0.6s ease, box-shadow 0.6s ease, opacity 0.6s ease;
        opacity: 0.9;
      }
      .maritime-img:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        opacity: 1;
      }
      .fade-in {
        animation: fadeInUp 1.2s ease-in-out forwards;
      }
      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      .law-items {
        list-style: none;
        margin: 0;
        padding: 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 35px 50px;
        position: relative;
      }
      .law-items li {
        background: #f9f9f9;
        border-left: 6px solid #007bff;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
        font-size: 0.95rem;
        transition: all 0.4s ease;
      }
      .law-items li:hover {
        transform: scale(1.05);
        background: linear-gradient(135deg, #eef6ff, #ffffff);
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
      <section class="position-relative text-white">
        <img src="assets/img/kapal (1).jpg" class="img-fluid w-100" style="object-fit: cover; max-height: 400px" alt="Kapal Maritim" />
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 60, 120, 0.55); max-height: 430px"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-center">
          <h1 class="fw-bold display-5">Aspek Hukum</h1>
          <p class="lead">PT. Intan Sejahtera Utama (ISMA)</p>
        </div>
      </section>

      <section class="container my-5">
  <div class="card border-0 shadow-lg p-4" data-aos="fade-up">
  <h3 class="text-center fw-bold mb-4 text-primary">Sertifikasi & Standar</h3>
  <div class="row text-center g-4">
    <?php
    include "admin/config.php";
    $result = mysqli_query($conn, "SELECT * FROM sub1 WHERE section='sertifikasi' ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($result)):
      // Pastikan path gambar valid
      $gambar = !empty($row['gambar']) ? 'assets/img/'.$row['gambar'] : 'assets/img/default.png';
    ?>
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="p-3 bg-white rounded shadow-sm h-100 hover-zoom">
          <img src="<?= !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : 'assets/img/default.png' ?>" 
     alt="<?= htmlspecialchars($row['judul']) ?>" 
     class="img-fluid mb-2" style="max-height:120px;">


          <p class="mt-2 fw-semibold"><?= htmlspecialchars($row['judul']) ?></p>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</section>


      <section class="container my-5">
  <div class="text-center mb-5">
    <h3 class="fw-bold text-primary">Mandatory Maritime Law</h3>
    <p class="text-muted">Empat pilar utama keselamatan, lingkungan, pelatihan, dan perlindungan tenaga kerja dalam industri maritim.</p>
  </div>

  <div class="row align-items-center g-4">
    <div class="col-lg-7">
      <div class="row g-4">
        <?php
        $mandatory = mysqli_query($conn, "SELECT * FROM sub1 WHERE section='mandatory' ORDER BY id ASC");
        while($row = mysqli_fetch_assoc($mandatory)):
        ?>
          <div class="col-md-6" data-aos="zoom-in">
            <div class="card border-0 shadow-lg h-100 text-center p-4 rounded-4 hover-card">
              <div class="mb-3">
                <i class="fas fa-check-circle fa-2x text-primary"></i>
              </div>
              <h6 class="fw-bold"><?= htmlspecialchars($row['judul']) ?></h6>
              <p class="text-muted small"><?= htmlspecialchars($row['deskripsi']) ?></p>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>

    <div class="col-lg-5 text-center">
      <img src="assets/img/mandatory_maritime.png" alt="Mandatory Maritime Law" class="img-fluid maritime-img fade-in"/>
    </div>
  </div>
</section>


     <section class="container my-5">
  <div class="text-center mb-5">
    <h3 class="fw-bold text-primary">Landasan Hukum Nasional</h3>
    <p class="text-muted">Regulasi dan peraturan pemerintah yang menjadi dasar hukum PT. Intan Sejahtera Utama dalam menjalankan kegiatan operasional.</p>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-10">
      <ul class="law-items">
        <?php
        $landasan = mysqli_query($conn, "SELECT * FROM sub1 WHERE section='landasan' ORDER BY id ASC");
        $delay = 100;
        while($row = mysqli_fetch_assoc($landasan)):
        ?>
          <li data-aos="fade-up" data-aos-delay="<?= $delay ?>">
            <strong><?= htmlspecialchars($row['judul']) ?></strong><br />
            <?= htmlspecialchars($row['deskripsi']) ?>
          </li>
        <?php 
          $delay += 100; 
        endwhile; 
        ?>
      </ul>
    </div>
  </div>
</section>

    </main>

    <!-- Footer -->
  <?php
  include "admin/config.php";

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