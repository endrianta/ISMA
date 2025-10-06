<?php include "admin/config.php"; ?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Informasi Onboarding - PT. ISMA</title>
  <link href="assets/img/logo.png" rel="icon" />
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/css/main.css" rel="stylesheet" />
  <style>
    body { background-color: #f4f6f9; }
    .header-onboarding { background-color: #0d6efd; color: white; padding: 3rem 0; text-align: center; }
    .list-group-item i { color: #0d6efd; margin-right: 10px; }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="bg-white text-black py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="index.php"><img src="assets/img/logoisma.png" alt="Logo" style="height: 50px;"></a>
      <a href="karir.php" class="btn btn-outline-primary">← Kembali ke Daftar Karir</a>
    </div>
  </header>

  <div class="header-onboarding">
      <div class="container">
          <h1 class="display-5 fw-bold">Selamat Datang di PT. ISMA!</h1>
          <p class="lead">Kami senang Anda akan segera bergabung. Berikut adalah panduan untuk proses selanjutnya.</p>
      </div>
  </div>

  <main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-5">
                    
                    <div class="row g-5">
                        <!-- Kiri: Proses Selanjutnya -->
                        <div class="col-md-6">
                            <h3 class="mb-4"><i class="bi bi-arrow-down-short"></i> Alur Proses Selanjutnya</h3>
                            <ol class="list-group list-group-numbered">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Penawaran Resmi (Offering Letter)</div>
                                        Tim HR akan mengirimkan surat penawaran resmi ke email Anda dalam 1-3 hari kerja.
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Penandatanganan Kontrak</div>
                                        Jadwal akan diatur setelah Anda menyetujui penawaran yang kami berikan.
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Hari Pertama & Orientasi</div>
                                        Informasi detail mengenai jadwal dan agenda hari pertama Anda akan diberikan menjelang tanggal bergabung.
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <!-- Kanan: Checklist Dokumen -->
                        <div class="col-md-6">
                            <h3 class="mb-4"><i class="bi bi-card-checklist"></i> Checklist Dokumen</h3>
                            <p>Mohon siapkan dokumen-dokumen berikut (dalam bentuk digital/scan dan/atau fisik sesuai instruksi pada email penawaran):</p>
                            <ul class="list-group">
                                <li class="list-group-item"><i class="bi bi-person-badge-fill"></i> Fotokopi/Scan KTP</li>
                                <li class="list-group-item"><i class="bi bi-card-heading"></i> Fotokopi/Scan Kartu Keluarga</li>
                                <li class="list-group-item"><i class="bi bi-file-earmark-text-fill"></i> Fotokopi/Scan Ijazah Terakhir</li>
                                <li class="list-group-item"><i class="bi bi-file-earmark-text-fill"></i> Fotokopi/Scan Transkrip Nilai</li>
                                <li class="list-group-item"><i class="bi bi-person-vcard-fill"></i> Curriculum Vitae (CV) Terbaru</li>
                                <li class="list-group-item"><i class="bi bi-image-fill"></i> Pas Foto (Ukuran 4x6)</li>
                                <li class="list-group-item"><i class="bi bi-credit-card-2-front-fill"></i> Fotokopi/Scan NPWP (jika ada)</li>
                                <li class="list-group-item"><i class="bi bi-shield-lock-fill"></i> Fotokopi/Scan BPJS Kesehatan & Ketenagakerjaan (jika ada)</li>
                                <li class="list-group-item"><i class="bi bi-award-fill"></i> Fotokopi/Scan Sertifikat Keahlian (contoh: Buku Pelaut, BST, dll.)</li>
                            </ul>
                        </div>
                    </div>

                    <hr class="my-5">

                    <!-- Kontak HR -->
                    <div class="text-center bg-light p-4 rounded-3">
                        <h4>Punya Pertanyaan?</h4>
                        <p>Jangan ragu untuk menghubungi tim Human Resources kami jika Anda memiliki pertanyaan lebih lanjut mengenai proses ini.</p>
                        <?php
                            $footerQuery = "SELECT value FROM contact WHERE section='footer' AND type='Nomor'";
                            $footerResult = mysqli_query($conn, $footerQuery);
                            $footerData = mysqli_fetch_assoc($footerResult);
                            $wa_number_raw = $footerData['value'] ?? '';
                            
                            $emailQuery = "SELECT value FROM contact WHERE section='footer' AND type='Email'";
                            $emailResult = mysqli_query($conn, $emailQuery);
                            $emailData = mysqli_fetch_assoc($emailResult);
                            $email = $emailData['value'] ?? '';
                        ?>
                        <p class="fs-5 mb-0">
                            <i class="bi bi-envelope-fill"></i> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                        </p>
                        <p class="fs-5">
                             <i class="bi bi-telephone-fill"></i> <?php echo $wa_number_raw; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </main>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
