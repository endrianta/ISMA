<?php
include "admin/config.php"; // koneksi ke DB
$result = mysqli_query($conn, "SELECT * FROM karir ORDER BY date_posted DESC");
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

  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    #main {
      flex-grow: 1;
    }
    .card-img-top {
      height: 220px;
      object-fit: cover;
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
  <header id="header" class="header bg-white shadow-sm" 
        style="padding-top: 25px; padding-bottom: 80px; position: fixed; top: 0; left: 0; right: 0; z-index: 1030;">
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
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://flagcdn.com/w20/id.png" class="me-1">
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                <li><a class="dropdown-item d-flex align-items-center" href="#" onclick="changeLang('id'); return false;"><img src="https://flagcdn.com/w20/id.png" class="me-2"> Indonesia</a></li>
                <li><a class="dropdown-item d-flex align-items-center" href="#" onclick="changeLang('en'); return false;"><img src="https://flagcdn.com/w20/us.png" class="me-2"> English</a></li>
              </ul>
            </li>
            <div id="google_translate_element" style="display:none"></div>
          </ul>
        </nav>
      </div>
    </header>

  <!-- Main -->
  <main id="main">
    <section class="container my-5">
      <div class="row g-4" id="karir-container" style="margin-top: 30px;">

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
          <div class="col-md-6 col-lg-3 karir-item" data-aos="fade-up">
            <div class="card shadow-sm border-0 h-100">
              <img src="assets/img/karir/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>" />
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['title']; ?></h5>
                <p class="card-text">
                  <?php echo substr(strip_tags($row['description']), 0, 80); ?>...
                </p>
                <small class="text-muted d-block mb-2"><?php echo $row['date_posted']; ?></small>
                <a href="detail_karir.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>

      </div>

      <nav aria-label="Karir page navigation">
        <ul class="pagination justify-content-center mt-5" id="karir-pagination"></ul>
      </nav>
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

  <!-- Pagination script -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const itemsPerPage = 8;
      const karirItems = document.querySelectorAll('#karir-container .karir-item');
      const totalPages = Math.ceil(karirItems.length / itemsPerPage);
      const paginationContainer = document.getElementById('karir-pagination');

      function showPage(pageNumber) {
        const startIndex = (pageNumber - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        karirItems.forEach(item => item.style.display = 'none');
        for (let i = startIndex; i < endIndex; i++) {
          if (karirItems[i]) {
            karirItems[i].style.display = 'block';
          }
        }

        document.querySelectorAll('.page-item').forEach(li => li.classList.remove('active'));
        document.querySelector(`.page-item[data-page="${pageNumber}"]`).classList.add('active');
      }

      function setupPagination() {
        for (let i = 1; i <= totalPages; i++) {
          const pageItem = document.createElement('li');
          pageItem.className = 'page-item';
          pageItem.dataset.page = i;

          const pageLink = document.createElement('a');
          pageLink.className = 'page-link';
          pageLink.href = '#';
          pageLink.textContent = i;
          pageItem.appendChild(pageLink);

          pageLink.addEventListener('click', function(e) {
            e.preventDefault();
            showPage(i);
          });

          paginationContainer.appendChild(pageItem);
        }
        if (totalPages > 0) showPage(1);
      }
      setupPagination();
    });
  </script>
</body>
</html>
