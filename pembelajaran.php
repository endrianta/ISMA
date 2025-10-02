<?php
// Sertakan file konfigurasi database
include "admin/config.php";

// --- Logika Pencarian, Filter, & Paginasi ---
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$filter_category = isset($_GET['filter']) && in_array($_GET['filter'], ['general', 'private']) ? $_GET['filter'] : 'all';

// Bangun klausa WHERE
$conditions = [];
if (!empty($search_query)) {
    $conditions[] = "title LIKE '%$search_query%'";
}
if ($filter_category !== 'all') {
    $conditions[] = "category = '$filter_category'";
}
$where_sql = '';
if (count($conditions) > 0) {
    $where_sql = " WHERE " . implode(' AND ', $conditions);
}

// Pengaturan Paginasi
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6; // 6 materi per halaman
$offset = ($page - 1) * $perPage;

// Hitung total materi
$total_query_sql = "SELECT COUNT(id) as total FROM pembelajaran" . $where_sql;
$total_query = mysqli_query($conn, $total_query_sql);
$total_result = mysqli_fetch_assoc($total_query);
$totalPages = ceil($total_result['total'] / $perPage);

// Parameter URL untuk pagination
$url_params = [];
if (!empty($search_query)) { $url_params['search'] = $search_query; }
if ($filter_category !== 'all') { $url_params['filter'] = $filter_category; }
$pagination_url_param = !empty($url_params) ? '&' . http_build_query($url_params) : '';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Materi Pembelajaran - PT. INTAN SEJAHTERA UTAMA</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Amatic+SC:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Main CSS -->
    <link href="assets/css/main.css" rel="stylesheet" />

    <!-- Page-level CSS overrides -->
    <style>
      body { padding-top: 150px; }
      #header.header { transition: background-color 0.2s ease; }
      .nav-link.active { color: dodgerblue !important; }
      section { padding: 60px 0; }
      /* DIUBAH: Mengurangi padding atas dan bawah */
      .materi-pembelajaran { padding: 10px 0; }
      .video-card { margin-bottom: 30px; }
      .video-card .card-img-top { height: 200px; object-fit: cover; background-color: #eee; }
      .modal-body .alert { display: none; }
      .pagination .page-link { color: #0d6efd; }
      .pagination .page-item.active .page-link { background-color: #0d6efd; border-color: #0d6efd; color: white; }
      .pagination .page-item.disabled .page-link { color: #6c757d; }
      .filter-group .btn.active { background-color: #0d6efd; color: white; }
    </style>
  </head>

  <body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="70" tabindex="0">
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

<main id="main">
<section class="materi-pembelajaran">
  <div class="container">

    <div class="section-header text-center mb-5" data-aos="fade-up">
        <h2 class="text-dark">Materi Pembelajaran</h2>
    </div>
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-lg-8 mb-3 mb-lg-0">
            <form action="pembelajaran.php" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control form-control-lg" placeholder="Cari judul materi..." value="<?= htmlspecialchars($search_query) ?>">
                <?php if ($filter_category !== 'all'): ?>
                    <input type="hidden" name="filter" value="<?= htmlspecialchars($filter_category) ?>">
                <?php endif; ?>
                <button type="submit" class="btn btn-primary btn-lg ms-2">Cari</button>
            </form>
        </div>
        <div class="col-lg-4 text-lg-end">
            <div class="btn-group filter-group" role="group">
                <?php $search_param_for_filter = !empty($search_query) ? 'search=' . urlencode($search_query) . '&' : ''; ?>
                <a href="?<?= $search_param_for_filter ?>filter=all" class="btn btn-outline-primary <?= ($filter_category === 'all') ? 'active' : '' ?>">Semua</a>
                <a href="?<?= $search_param_for_filter ?>filter=general" class="btn btn-outline-primary <?= ($filter_category === 'general') ? 'active' : '' ?>">General</a>
                <a href="?<?= $search_param_for_filter ?>filter=private" class="btn btn-outline-primary <?= ($filter_category === 'private') ? 'active' : '' ?>">Private</a>
            </div>
        </div>
    </div>

    <div class="row" id="video-list">
      <?php
        $pembelajaran_query_sql = "SELECT * FROM pembelajaran" . $where_sql . " ORDER BY id DESC LIMIT $perPage OFFSET $offset";
        $pembelajaran_result = mysqli_query($conn, $pembelajaran_query_sql);

        if ($pembelajaran_result && mysqli_num_rows($pembelajaran_result) > 0) {
            while ($row = mysqli_fetch_assoc($pembelajaran_result)) {
                $image_path = "assets/img/eii.jpg";
                if (!empty($row['image']) && file_exists("assets/img/pembelajaran/" . $row['image'])) {
                    $image_path = "assets/img/pembelajaran/" . $row['image'];
                }
                $is_private = strtolower($row['category']) === 'private';
      ?>
      <div class="col-md-4 video-card">
        <div class="card h-100">
          <img src="<?= $image_path ?>" class="card-img-top" alt="<?= htmlspecialchars($row['title']) ?>">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
            <p class="card-text flex-grow-1"><?= htmlspecialchars($row['description']) ?></p>
            
            <?php if ($is_private): ?>
                <button type="button" class="btn btn-warning mt-auto" data-bs-toggle="modal" data-bs-target="#nipModal" data-pembelajaran-id="<?= $row['id'] ?>"><i class="bi bi-lock-fill"></i> Minta Akses</button>
            <?php else: 
                $video_href = "#";
                $glightbox_class = "";
                if (!empty($row['video'])) {
                    $glightbox_class = "glightbox";
                    $video_href = filter_var($row['video'], FILTER_VALIDATE_URL) ? htmlspecialchars($row['video']) : "assets/videos/pembelajaran/" . htmlspecialchars($row['video']);
                }
            ?>
                <a href="<?= $video_href ?>" class="btn btn-primary mt-auto <?= $glightbox_class ?>" <?= ($video_href == '#') ? 'disabled' : '' ?>>Tonton Video</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php
            }
        } else {
            $message = "Materi yang Anda cari tidak ditemukan.";
            if (empty($search_query) && $filter_category === 'all') {
                $message = "Belum ada materi pembelajaran yang ditambahkan.";
            }
            echo '<div class="col-12 text-center"><p class="text-muted">' . $message . '</p></div>';
        }
      ?>
    </div>

    <?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation" class="mt-5 d-flex justify-content-center">
      <ul class="pagination">
        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $page - 1 ?><?= $pagination_url_param ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?><?= $pagination_url_param ?>"><?= $i ?></a></li>
        <?php endfor; ?>
        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $page + 1 ?><?= $pagination_url_param ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
        </li>
      </ul>
    </nav>
    <?php endif; ?>

  </div>
</section>
</main>

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
        <div>
          <h5 class="fw-bold">Alamat</h5>
          <p class="mb-0"><?php echo htmlspecialchars($footerData['Alamat'] ?? ''); ?></p>
        </div>
      </div>
      <div class="col-md-4 d-flex flex-column align-items-center">
        <i class="bi bi-telephone fs-3 mb-2"></i>
        <div>
          <h5 class="fw-bold">Hubungi</h5>
          <p class="mb-0">
            <strong>Email:</strong> <br /><?php echo htmlspecialchars($footerData['Email'] ?? ''); ?> <br />
            <strong>Whatsapp:</strong> <br /><a href="https://wa.me/<?php echo htmlspecialchars($footerData['Nomor'] ?? ''); ?>"><?php echo htmlspecialchars($footerData['Nomor'] ?? ''); ?></a>
          </p>
        </div>
      </div>
      <div class="col-md-4 d-flex flex-column align-items-center">
        <i class="bi bi-clock fs-3 mb-2"></i>
        <div>
          <h5 class="fw-bold">Tersedia</h5>
          <p class="mb-0">
            <strong>Senin - Jumat:</strong> <br /><?php echo htmlspecialchars($footerData['Waktu'] ?? ''); ?><br />
            <strong>Sabtu - Minggu:</strong> <br />Tutup
          </p>
        </div>
      </div>
    </div>
    <hr class="border-secondary my-4" />
    <div class="text-center small">© Hak Cipta <strong>PT. INTAN SEJAHTERA UTAMA</strong>.</div>
  </div>
</footer>

<div class="modal fade" id="nipModal" tabindex="-1" aria-labelledby="nipModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="nipModalLabel">Akses Materi Privat</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><div class="alert alert-success" role="alert" id="modalMessage"></div><div class="alert alert-danger" role="alert" id="modalErrorMessage"></div><form id="nipForm"><p>Masukkan NIP Anda. Jika disetujui, video akan diputar.</p><div class="mb-3"><label for="nipInput" class="form-label">NIP Anda</label><input type="text" class="form-control" id="nipInput" name="nip" required><input type="hidden" id="pembelajaranIdInput" name="pembelajaran_id"></div><button type="submit" class="btn btn-primary">Lanjutkan</button></form></div></div></div></div>
<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<!-- Vendor JS, Google Translate, and Custom Scripts -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script><script src="assets/vendor/aos/aos.js"></script><script src="assets/vendor/glightbox/js/glightbox.min.js"></script><script src="assets/vendor/purecounter/purecounter_vanilla.js"></script><script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>
<script>function googleTranslateElementInit() { new google.translate.TranslateElement({pageLanguage: 'id', includedLanguages: 'id,en', autoDisplay: false}, 'google_translate_element'); } function changeLang(lang) { var iframe = document.getElementsByClassName('goog-te-menu-frame')[0]; if (!iframe) return; var innerDoc = iframe.contentDocument || iframe.contentWindow.document; var langElements = innerDoc.getElementsByClassName('goog-te-menu2-item'); for (var i = 0; i < langElements.length; i++) { if (langElements[i].getAttribute('value') == lang) { langElements[i].click(); } } }</script><script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const lightbox = GLightbox({ selector: '.glightbox' });
    const nipModal = document.getElementById('nipModal');
    if(nipModal) {
        const nipForm = document.getElementById('nipForm');
        const pembelajaranIdInput = document.getElementById('pembelajaranIdInput');
        const modalMessage = document.getElementById('modalMessage');
        const modalErrorMessage = document.getElementById('modalErrorMessage');
        nipModal.addEventListener('show.bs.modal', function (event) {
            if(!nipForm) return;
            nipForm.style.display = 'block';
            modalMessage.style.display = 'none';
            modalErrorMessage.style.display = 'none';
            nipForm.reset();
            pembelajaranIdInput.value = event.relatedTarget.getAttribute('data-pembelajaran-id');
        });
        if(nipForm) {
            nipForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const modalInstance = bootstrap.Modal.getInstance(nipModal);
                fetch('request_access.php', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.action === 'play') {
                            modalInstance.hide();
                            let videoUrl = data.video_url.startsWith('http') || data.video_url.startsWith('assets') ? data.video_url : 'assets/videos/pembelajaran/' + data.video_url;
                            const videoPlayer = GLightbox({ href: videoUrl, type: 'video', source: 'local' });
                            videoPlayer.open();
                        } else {
                            nipForm.style.display = 'none';
                            modalMessage.textContent = data.message;
                            modalMessage.style.display = 'block';
                        }
                    } else {
                        modalErrorMessage.textContent = data.message || 'Terjadi kesalahan.';
                        modalErrorMessage.style.display = 'block';
                    }
                }).catch(error => {
                    console.error('Fetch Error:', error);
                    modalErrorMessage.textContent = 'Gagal terhubung ke server.';
                    modalErrorMessage.style.display = 'block';
                });
            });
        }
    }
  });
</script>
</body>
</html>