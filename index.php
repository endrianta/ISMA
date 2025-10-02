<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>PT. INTAN SEJAHTERA UTAMA</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Amatic+SC:wght@400;700&family=Inter:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Main CSS -->
    <link href="assets/css/main.css" rel="stylesheet" />

    <!-- Page-level CSS overrides (pindahkan ke assets/css/main.css jika perlu) -->
    <style>
      /* Header */
      #header.header {
        transition: background-color 0.2s ease;
      }
      .nav-link.active {
        color: dodgerblue !important;
      }

      /* Carousel */
      .carousel-item img {
        max-height: 640px; /* Batas tinggi gambar */
        object-fit: cover; /* Proporsional dan crop rapi */
      }

      /* Section generic spacing */
      section { padding: 60px 0; }

      /* About */
      .about .section-header h2 { color: #000; }

      /* Why-Us (Visi Misi, Corporate Strategy, Key Enablers) */
      .why-box {
        border-radius: 15px;
        background: #2b6fdf; /* royalblue serupa */
        color: #fff;
      }
      .why-box h3 { color: #fff; }

      .icon-box {
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        text-align: center;
        height: 100%;
      }
      .icon-box i {
        font-size: 2rem;
        width: 64px;
        height: 64px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        margin-bottom: 12px;
        color: #1e90ff; /* dodgerblue */
        background: #b0e0e6; /* powderblue */
      }

      /* News */
      #news .section-header h2 { color: #000; }
      .news-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
      }
      .menu-item {
        background-color: white;
        border-radius: 15px;
        padding: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        display: inline-block;   
        width: auto;         
        max-width: 380px;
        margin-left: 120px;
      }

      .menu-img {
        width: auto;
        max-width: 350px;
        height: auto;
        max-height: 350px;
        object-fit: contain;
        display: block;
        border-radius: 10px;
        margin: 0 auto;
      }

      /* Structure (Organisasi) */
      .chef-container { display: flex; flex-direction: column; gap: 40px; }
      .chef-member { display: flex; align-items: flex-start; gap: 20px; }
      .member-img img { width: 180px; height: auto; border-radius: 50px; }
      .member-info { color: #fff; }
      .member-info h3 { margin: 0 0 5px; }
      .member-info h4 { margin: 0 0 12px; font-weight: 500; color: #fff; }

      .staff-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        justify-items: center;
        margin-top: 30px;
      }
      .staff-card { text-align: center; background: transparent; padding: 20px; max-width: 400px; color: #fff; }
      .staff-card img { width: 180px; height: auto; border-radius: 50px; }
      .staff-card h3, .staff-card h4, .staff-card p { color: #fff; }

      @media (max-width: 768px) {
        .chef-member { flex-direction: column; align-items: center; text-align: center; }
        .staff-container { grid-template-columns: 1fr; }
      }

      /* Contact */
      .info-item {
        border-radius: 50px;
        padding: 16px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        gap: 12px;
      }
      .info-item .icon { font-size: 1.5rem; margin-right: 12px; }

      /* Footer */
      #footer .bi { line-height: 1; }
    </style>
  </head>

  <body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="70" tabindex="0">
    <header id="header" class="header bg-white shadow-sm" 
        style="padding-top: 25px; padding-bottom: 80px; position: fixed; top: 0; left: 0; right: 0; z-index: 1030;">
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
          <a class="nav-link dropdown-toggle" href="index.php" data-bs-toggle="dropdown" onclick="window.location='#about';">Tentang Kami</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="sertifikat.php">Sertifikat</a></li>
            <li><a class="dropdown-item" href="karir.php">Karir</a></li> 
            <li><a class="dropdown-item" href="pembelajaran.php">Materi Pembelajaran</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="#news">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="#structure">Struktur</a></li>
        <li class="nav-item"><a class="nav-link" href="#moment">Momen</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://flagcdn.com/w20/id.png" class="me-1">
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#" onclick="changeLang('id'); return false;">
                <img src="https://flagcdn.com/w20/id.png" class="me-2"> Indonesia
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#" onclick="changeLang('en'); return false;">
                <img src="https://flagcdn.com/w20/us.png" class="me-2"> English
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="admin/login.php">Admin</a></li>

        <div id="google_translate_element" style="display:none"></div>

        <style>
          /* sembunyikan banner dan widget google */
          .goog-te-banner-frame.skiptranslate,
          .goog-te-gadget-icon,
          .goog-logo-link,
          .goog-te-gadget {
            display: none !important;
            visibility: hidden !important;
          }
          body { 
            top: 0 !important; 
            padding-top: 120px; /* tambahkan padding biar konten tidak ketimpa header */
          }
          .goog-te-menu-frame { display: none !important; }

          /* biar header turun smooth */
          #header {
            transition: margin-top 0.3s ease;
          }
        </style>

        <!-- Inisialisasi Google Translate -->
        <script type="text/javascript">
          function googleTranslateElementInit() {
            new google.translate.TranslateElement({
              pageLanguage: 'id',
              includedLanguages: 'id,en',
              autoDisplay: false
            }, 'google_translate_element');
            window._gt_ready = true;
          }
        </script>
        <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

        <script>
          function changeLang(lang) {
            var dd = document.getElementById('languageDropdown');
            if (dd) {
              dd.innerHTML = '<img src="https://flagcdn.com/w20/' + (lang === 'id' ? 'id' : 'us') + '.png" class="me-1"> ' + (lang === 'id' ? '' : '');
            }

            var attempts = 0;
            var maxAttempts = 40;
            var interval = 200;

            var tryTranslate = function() {
              attempts++;
              var combo = document.querySelector('.goog-te-combo');
              if (combo) {
                try {
                  combo.value = (lang === 'en') ? 'en' : 'id';
                  combo.dispatchEvent(new Event('change'));
                  clearInterval(timer);
                  return;
                } catch (e) {}
              }
              if (attempts >= maxAttempts) clearInterval(timer);
            };
            var timer = setInterval(tryTranslate, interval);
            tryTranslate();
          }

          document.addEventListener('DOMContentLoaded', function() {
            var last = localStorage.getItem('site_lang');
            if (last) {
              var dd = document.getElementById('languageDropdown');
              if (dd) dd.innerHTML = '<img src="https://flagcdn.com/w20/' + (last === 'id' ? 'id' : 'us') + '.png" class="me-1"> ' + (last === 'id' ? '' : '');
            }
            var originalChangeLang = changeLang;
            changeLang = function(lang) {
              localStorage.setItem('site_lang', lang);
              originalChangeLang(lang);
            };
          });

          // ==== FUNGSI UNTUK TURUNKAN HEADER KALO TOOLBAR GOOGLE MUNCUL ====
          function adjustForTranslateToolbar() {
            let banner = document.querySelector("iframe.goog-te-banner-frame");
            let header = document.getElementById("header");
            if (banner && banner.offsetHeight > 0) {
              header.style.marginTop = banner.offsetHeight + "px";
            } else {
              header.style.marginTop = "0px";
            }
          }
          window.addEventListener("load", function () {
            setInterval(adjustForTranslateToolbar, 500);
          });
        </script>
      </ul>
    </nav>
  </div>
</header>


    <main id="main">
      <!-- Hero / Carousel -->
      <?php
      include "admin/config.php";
      ?>

      <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
              <!-- Ganti gambar carousel dengan video -->
              <div class="carousel-item active">
                  <video autoplay muted loop playsinline style="width:100%; height:90vh; object-fit:cover;">
                      <source src="assets/img/isma.mp4" type="video/mp4">
                      Your browser does not support the video tag.
                  </video>

                  <!-- Caption tetap di atas video -->
                  <div class="carousel-caption d-flex flex-column justify-content-center align-items-center">
                      <h1 class="text-white fw-bold display-1">PT. INTAN SEJAHTERA UTAMA</h1>
                  </div>
              </div>
          </div>
      </div>

      <style>
      .carousel-item {
          height: 90vh;
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
      }
      .carousel-caption {
          height: 100%;
          top: 0;
          bottom: 0;
          left: 0;
          right: 0;
          text-align: center;
          background: rgba(0, 0, 0, 0.3);
      }
      .carousel-caption h1 {
          font-size: 3rem;
          border-radius: 10px;
          padding: 10px;
      }
      </style>

      <!-- About Section -->
      <section id="about" class="about" style="background-image: url('assets/img/bg4.jpg'); background-size: cover;">
        <div class="container" data-aos="fade-up">
          <div class="section-header text-center">
            <h2 class="text-dark">Tentang kami</h2>
            <p>PT. <span class="text-primary">INTAN SEJAHTERA UTAMA</span></p>
          </div>
          <div class="row align-items-center g-4">
            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
              <p class="fst-italic">
                PT Intan Sejahtera Utama adalah perusahaan yang bergerak di bidang manning agency (perekrutan dan penempatan awak kapal) berdasarkan SIUPPAK Nomor 232.35 Tahun 2022 yang berbadan hukum Indonesia dengan akta pendirian Nomor 09 pada tanggal 29 November 2018 dan telah mendapatkan pengesahan dari Kementerian Hukum & HAM pada tanggal 30 November 2018 dengan Nomor AHU 0057261.AH.01.01 Tahun 2018 serta Nomor Induk Berusaha 8120213230436.
              </p>
              <p>
                Keberadaan PT Intan Sejahtera Utama sesuai dengan komitmen PT Pelabuhan Indonesia (Persero) dalam melaksanakan fungsi BUMN dalam penyediaan tenaga kerja sebagaimana yang tertuang dalam surat Direktur Utama PT PELINDO No. PD.02/13/2/3PBAP/UTMA/PLND-23, Perihal Pelaksanaan Pemurnian Bisnis PELINDO Group tanggal 13 Februari 2023.
              </p>
            </div>
            <div class="col-lg-5 text-center">
              <img src="assets/img/ISMA.png" class="img-fluid" alt="About Image" />
            </div>
          </div>
        </div>
      </section>

      <!-- Why Us / RJPP -->
      <section id="about" class="about section-bg" style="background-image: url('assets/img/bg.png'); background-size: cover; background-position: center;">
        <div class="container" data-aos="fade-up">
          <div class="row gy-4">
            <!-- Visi & Misi -->
            <div class="col-lg-12 d-flex align-items-center" data-aos="fade-up" data-aos-delay="100">
              <div class="row gx-4 gy-4 w-100">
                <div class="col-md-6">
                  <div class="why-box p-4 d-flex flex-column" style="height: 270px">
                    <h3>VISI</h3>
                    <div class="flex-grow-1 d-flex align-items-center">
                      <p class="mb-0">
                        Menjadi perusahaan agen perekrutan dan penempatan awak kapal terkemuka dalam memberikan solusi dan kualitas terbaik untuk industri maritim.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="why-box p-4" style="height: 270px">
                    <h3 class="text-end">MISI</h3>
                    <ol class="mb-0 ps-3">
                      <li>Penyediaan Jasa Tenaga Kerja Berkualitas</li>
                      <li>Peningkatan Kualitas Pelatihan</li>
                      <li>Keamanan dan Kesejahteraan</li>
                      <li>Meningkatkan Kepuasan Klien</li>
                      <li>Memenuhi Standar Regulasi Nasional &amp; Internasional</li>
                      <li>Inovasi dan Pengembangan</li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>

            <!-- Corporate Strategy -->
            <div class="col-lg-12 d-flex align-items-center flex-column">
              <h2 class="text-center text-light mb-4" style="margin-top: 20px;">CORPORATE STRATEGY</h2>
            
              <div class="row gx-4 gy-4 w-100">
            
                <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                  <div class="icon-box d-flex flex-column justify-content-center align-items-center p-4" style="border-radius: 15px;">
                    <i class="bi bi-lightbulb-fill" style="color: dodgerblue; background-color: #B0E0E6;"></i>
                    <h4>A. Innovation</h4>
                    <p>Menghadirkan inovasi produk atau layanan baru yang memenuhi kebutuhan dan harapan pelanggan</p>
                  </div>
                </div>
            
                <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                  <div class="icon-box d-flex flex-column justify-content-center align-items-center p-4" style="border-radius: 15px;">
                    <i class="bi bi-clipboard-data" style="color: dodgerblue; background-color: #B0E0E6;"></i>
                    <h4>B. Operational Excellence</h4>
                    <p>Meningkatkan produktivitas, mengurangi biaya operasional, dan memperkuat rantai pasokan</p>
                  </div>
                </div>
            
                <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                  <div class="icon-box d-flex flex-column justify-content-center align-items-center p-4" style="border-radius: 15px;">
                    <i class="bi bi-shop" style="color: dodgerblue; background-color: #B0E0E6;"></i>
                    <h4>C. Market Expansion</h4>
                    <p>Ekspansi ke pasar baru dan peningkatan pangsa pasar di pasar yang ada</p>
                  </div>
                </div>
            
                <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                  <div class="icon-box d-flex flex-column justify-content-center align-items-center p-4" style="border-radius: 15px;">
                    <i class="bi bi-person-arms-up" style="color: dodgerblue; background-color: #B0E0E6;"></i>
                    <h4>D. Customer Focus</h4>
                    <p>Meningkatkan kepuasan pelanggan dan loyalitas melalui pelayanan yang unggul dan penawaran yang tepat</p>
                  </div>
                </div>
            
              </div>
            </div>
            
            <div class="container" data-aos="fade-up" data-aos-delay="100">
              <!-- Judul di tengah dengan jarak atas -->
              <h2 class="text-center text-light mt-5 mb-4">KEY ENABLES</h2>
            
              <!-- Wrapper untuk box -->
              <div class="d-flex flex-column align-items-center gap-3">
                
                <!-- Box 1 -->
                <div class="why-box p-4" style="border-radius: 15px; background-color: dodgerblue; display: inline-block; height: 70px;">
                  <p>Digital Transformation: Pengembangan Aplikasi dan sistem informasi yang terintegrasi</p>
                </div>
            
                <!-- Box 2 -->
                <div class="why-box p-4" style="border-radius: 15px; background-color: dodgerblue; display: inline-block; height: 70px;">
                  <p>Strategic Financing: Pengembangan strategi keuangan yang optimal dan berkelanjutan</p>
                </div>
            
                <!-- Box 3 -->
                <div class="why-box p-4" style="border-radius: 15px; background-color: dodgerblue; display: inline-block; height: 70px;">
                  <p>Talent Development: Peningkatan kapasitas dan kapabilitas Crewing serta kesejahteraan Crew</p>
                </div>
            
                <!-- Box 4 -->
                <div class="why-box p-4" style="border-radius: 15px; background-color: dodgerblue; display: inline-block; height: 70px;">
                  <p>Sustainability Program: Pengembangan program keberlanjutan pada penggunaan sumber daya dan peningkatan efisiensi</p>
                </div>
            
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- News Section -->
      <section id="news" class="news" style="background-image: url('assets/img/bg4.jpg'); background-size: cover; background-position: center;">
        <div class="container" data-aos="fade-up">
          <div class="section-header">
            <h2 style="color: black;">Berita</h2>
            <p style="color: black;">PT. <span style="color: primary;">ISMA</span></p>
          </div>
          <main id="main">
            <section class="container my-2">
              <div class="row g-4" id="news-container">

                <?php
                // Ambil hanya 4 berita terbaru
                $query = "SELECT * FROM news ORDER BY date DESC LIMIT 4";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) : ?>
                  <div class="col-md-6 col-lg-3 news-item" data-aos="fade-up">
                    <div class="card shadow-sm border-0 h-100">
                      <a href="assets/img/news/<?php echo $row['image']; ?>" class="glightbox">
                        <img src="assets/img/news/<?php echo $row['image']; ?>" 
                            class="card-img-top img-fluid" 
                            alt="<?php echo $row['title']; ?>" 
                            style="height:200px; object-fit:cover;" />
                      </a>
                      <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <p class="card-text">
                          <?php echo substr(strip_tags($row['content']), 0, 80); ?>...
                        </p>
                        <small class="text-muted d-block mb-2">
                          <?php echo $row['date']; ?> | <?php echo $row['author']; ?>
                        </small>
                        
                        <!-- tombol di bawah -->
                        <div class="mt-auto">
                          <a href="detail_news.php?id=<?php echo $row['id']; ?>" 
                            class="btn btn-primary btn-sm w-100" target="_blank">
                            Baca Selengkapnya
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endwhile; ?>
              </div>
            </section>
          </main>

          <!-- Tombol menuju halaman baru -->
          <div class="text-center mt-4">
            <a href="news.php" class="btn btn-primary px-4 py-2">
              Berita Lainnya
            </a>
          </div>
        </div>
      </section>

      <!-- Structure Section -->
      <?php
        include "admin/config.php"; // koneksi database

        // Ambil struktur jabatan (jika masih dipakai)
        $result_jabatan = mysqli_query($conn, "SELECT * FROM struktur_jabatan ORDER BY urutan ASC");
        $members = [];
        while($row = mysqli_fetch_assoc($result_jabatan)){
            $members[] = $row;
        }

        // Ambil semua moment dari database
        $result_moment = mysqli_query($conn, "SELECT * FROM moment ORDER BY id DESC");
        $moments = [];
        while($row = mysqli_fetch_assoc($result_moment)){
            $moments[] = $row;
        }
        ?>

        <section id="structure" class="structure section-bg" style="background-image: url('assets/img/bg.png'); background-size: cover; background-position: center">
            <div class="container" data-aos="fade-up">
                <div class="section-header text-center">
                    <h2 class="text-dark">Struktur</h2>
                    <p><span class="text-white">Jabatan</span></p>
                </div>

              <div class="container">
            <!-- Direktur Utama & Direktur -->
            <div class="row gy-4 justify-content-center" style="max-width:780px; margin:auto;">
            <div class="col-12 d-flex flex-column align-items-center">
                <?php foreach($members as $member): ?>
                    <?php if($member['urutan'] == 1 || $member['urutan'] == 2): ?>
                        <div class="d-flex justify-content-center mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="chef-container">
                                <div class="chef-member">
                                    <div class="member-img">
                                        <?php if(!empty($member['foto'])): ?>
                                            <img src="assets/img/structure/<?= htmlspecialchars($member['foto']) ?>" 
                                                alt="<?= htmlspecialchars($member['jabatan']) ?>" 
                                                style="height:260px; width:190px; object-fit:cover; border-radius:8px;">
                                        <?php else: ?>
                                            <img src="assets/img/structure/default.jpg" 
                                                alt="Kosong" 
                                                style="height:260px; width:190px; opacity:0.3; border-radius:8px;">
                                        <?php endif; ?>
                                    </div>
                                    <div class="member-info text-center">
                                        <h4><strong><?= htmlspecialchars($member['nama']) ?: 'Kosong' ?></strong></h4>
                                        <h5><?= htmlspecialchars($member['jabatan']) ?></h5>
                                        <p style="margin-top:7px;"><?= htmlspecialchars($member['deskripsi']) ?: '-' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

            <!-- Staff / Manager -->
            <div class="row gy-4 justify-content-center" style="max-width:1000px; margin:auto;">
                <?php foreach($members as $member): ?>
                    <?php if($member['urutan'] > 2): ?>
                        <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="chef-container">
                                <div class="chef-member d-flex align-items-start">
                                    <!-- Foto -->
                                    <div class="member-img" style="margin-right:20px;">
                                        <?php if(!empty($member['foto'])): ?>
                                            <img src="assets/img/structure/<?= htmlspecialchars($member['foto']) ?>" 
                                                alt="<?= htmlspecialchars($member['jabatan']) ?>" 
                                                style="height:260px; width:190px; object-fit:cover; border-radius:8px;">
                                        <?php else: ?>
                                            <img src="assets/img/structure/default.jpg" 
                                                alt="Kosong" 
                                                style="height:260px; width:190px; opacity:0.3; border-radius:8px;">
                                        <?php endif; ?>
                                    </div>

                                    <!-- Info -->
                                    <div class="member-info">
                                        <h4><strong><?= htmlspecialchars($member['nama']) ?: 'Kosong' ?></strong></h4>
                                        <h5><?= htmlspecialchars($member['jabatan']) ?></h5>
                                        <p style="margin-top:7px;"><?= htmlspecialchars($member['deskripsi']) ?: '-' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>       
        </div>
            </div>
        </section>

        <?php
        include "admin/config.php"; // sesuaikan path

        $result_moment = mysqli_query($conn, "SELECT * FROM moment ORDER BY id DESC");
        $moments = [];
        if($result_moment){
            while($row = mysqli_fetch_assoc($result_moment)){
                $moments[] = $row;
            }
        }
        ?>

      <section id="moment" class="moment section-bg" style="background-image: url('assets/img/bg4.jpg'); background-size: cover; background-position: center;">
        <div class="container" data-aos="fade-up">
          <div class="section-header text-center">
            <h2 class="text-dark">MOMENT</h2>
            <p><span class="text-primary">Aktivitas</span></p>
          </div>

          <div class="gallery-slider swiper">
            <div class="swiper-wrapper align-items-center">
              <?php if(count($moments)>0): ?>
                  <?php foreach($moments as $moment): ?>
                  <div class="swiper-slide">
                      <a class="glightbox" data-gallery="images-moment" href="assets/img/moment/<?= htmlspecialchars($moment['image']) ?>">
                          <img src="assets/img/moment/<?= htmlspecialchars($moment['image']) ?>" class="img-fluid" alt="..." style="border-radius: 15px;">
                      </a>
                  </div>
                  <?php endforeach; ?>
              <?php else: ?>
              <p class="text-center">Belum ada moment</p>
              <?php endif; ?>
              </div>
            <div class="mt-5"><div class="swiper-pagination"></div></div>
          </div>
        </div>
      </section>

      <!-- Contact Section -->
      <?php
        include "admin/config.php";

        // Ambil data contact (sosial media)
        $contactQuery = "SELECT * FROM contact WHERE section='contact'";
        $contactResult = mysqli_query($conn, $contactQuery);
      ?>

      <section id="contact" class="contact" style="background-image: url('assets/img/bg.png'); background-size: cover; background-position: center">
        <div class="container" data-aos="fade-up">
          <div class="section-header text-center">
            <h2 class="text-dark">Kontak</h2>
            <p class="text-dark">Butuh Bantuan? <span class="text-white">Hubungi Kami</span></p>
          </div>

          <!-- MAP -->
          <div class="mb-3" style="max-width: 2000px; margin: 0 auto">
            <iframe
              src="https://www.google.com/maps?q=PT.+Intan+Sejahtera+Utama,+Jl.+H.I.A.+Saleh+Daeng+Tompo+No.+11,+Losari,+Ujung+Pandang,+Makassar,+Sulawesi+Selatan&hl=id&z=18&output=embed"
              width="100%" height="450"
              style="border: 0; border-radius: 20px; overflow: hidden"
              allowfullscreen loading="lazy"
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>

          <div class="row gy-4 mt-3">
            <?php while ($row = mysqli_fetch_assoc($contactResult)) : ?>
              <div class="col-md-6">
                <div class="info-item d-flex align-items-center">
                  <?php
                    // mapping icon
                    $icons = [
                      "Youtube"   => "bi-youtube",
                      "Instagram" => "bi-instagram",
                      "Facebook"  => "bi-facebook",
                      "X"         => "bi-twitter-x"
                    ];
                    $icon = isset($icons[$row['type']]) ? $icons[$row['type']] : "bi-link";

                    // mapping link base
                    $baseUrls = [
                      "Youtube"   => "https://youtube.com/",
                      "Instagram" => "https://instagram.com/",
                      "Facebook"  => "https://facebook.com/",
                      "X"         => "https://x.com/"
                    ];

                    // ambil base url sesuai type, kalau tidak ada langsung pakai value mentah
                    $link = isset($baseUrls[$row['type']]) 
                      ? $baseUrls[$row['type']] . ltrim($row['value'], "/") 
                      : $row['value'];
                  ?>
                  <i class="icon bi <?php echo $icon; ?> flex-shrink-0"></i>
                  <div>
                    <h3 class="mb-1"><?php echo $row['label']; ?></h3>
                    <strong>
                      <a href="<?php echo $link; ?>" target="_blank" rel="noopener">
                        <?php echo $row['value']; ?>
                      </a>
                    </strong>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
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

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
  </body>
</html>