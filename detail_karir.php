<?php
include "admin/config.php"; // Koneksi database

$message = '';
$status_message = '';
$id = 0;

// Cek apakah ada ID di URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    header("Location: karir.php");
    exit();
}

// Ambil nomor WA dari footer contact
$footerQuery = "SELECT value FROM contact WHERE section='footer' AND type='Nomor'";
$footerResult = mysqli_query($conn, $footerQuery);
$footerData = mysqli_fetch_assoc($footerResult);
$wa_number_raw = $footerData['value'] ?? '';
$wa_number_clean = preg_replace('/[^0-9]/', '', $wa_number_raw);
if (substr($wa_number_clean, 0, 1) === '0') {
    $wa_link_number = '62' . substr($wa_number_clean, 1);
} else {
    $wa_link_number = $wa_number_clean;
}


// Handle form submission for new application
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_application'])) {
    // ... (kode submit lamaran tidak berubah, sama seperti sebelumnya) ...
}

// Handle status check
if (isset($_GET['check_email'])) {
    $email_to_check = mysqli_real_escape_string($conn, $_GET['check_email']);
    $karir_id_for_check = $id;

    $status_sql = "SELECT status, name FROM applicants WHERE karir_id = ? AND email = ?";
    $stmt_status = mysqli_prepare($conn, $status_sql);
    mysqli_stmt_bind_param($stmt_status, "is", $karir_id_for_check, $email_to_check);
    mysqli_stmt_execute($stmt_status);
    $status_result = mysqli_stmt_get_result($stmt_status);
    
    if ($applicant_data = mysqli_fetch_assoc($status_result)) {
        $applicant_name = htmlspecialchars($applicant_data['name']);
        $application_status = htmlspecialchars($applicant_data['status']);

        if ($application_status == 'Diterima') {
            $status_message = '
            <div class="alert alert-success mt-4">
                <h4 class="alert-heading">Selamat, ' . $applicant_name . '. Lamaran Anda Diterima!</h4>
                <p>Silakan hubungi tim HRD kami untuk konfirmasi atau lihat informasi onboarding untuk persiapan Anda.</p>
                <hr>
                <div class="d-flex gap-2 mt-3">
                    <a href="https://wa.me/' . $wa_link_number . '" target="_blank" class="btn btn-success w-50">
                        <i class="bi bi-whatsapp"></i> Hubungi HRD
                    </a>
                    <a href="onboarding.php" class="btn btn-primary w-50">
                        <i class="bi bi-info-circle"></i> Info Onboarding
                    </a>
                </div>
            </div>';
        } else {
            $status_message = '<div class="alert alert-info mt-3">Halo, <strong>' . $applicant_name . '</strong>. Status lamaran Anda untuk posisi ini adalah: <strong>' . $application_status . '</strong>.</div>';
        }
    } else {
        $status_message = '<div class="alert alert-warning mt-3">Lamaran dengan email <strong>' . htmlspecialchars($email_to_check) . '</strong> tidak ditemukan untuk lowongan ini. Pastikan Anda memasukkan email yang benar.</div>';
    }
    mysqli_stmt_close($stmt_status);
}

// Ambil data lowongan
$result = mysqli_query($conn, "SELECT * FROM karir WHERE id = $id");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<h2 class='text-center mt-5'>Lowongan tidak ditemukan!</h2>";
    exit();
}

$is_open = ($row['status'] == 'Dibuka' && (empty($row['closing_date']) || $row['closing_date'] >= date('Y-m-d')));

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($row['title']); ?> - PT. ISMA</title>
  <link href="assets/img/logo.png" rel="icon" />
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/css/main.css" rel="stylesheet" />
  <style>
    body { background-color: #f8f9fa; }
    .job-header { padding: 4rem 0; background-color: #343a40; color: white; }
    .job-header h1 { font-size: 3rem; font-weight: bold; }
    .job-details-card, .application-form-card { border-radius: 15px; }
    .detail-item { display: flex; align-items: center; margin-bottom: 0.8rem; font-size: 1.1rem; }
    .detail-item i { font-size: 1.5rem; margin-right: 15px; color: #0d6efd; }
    .content-text { text-align: justify; font-size: 1.05rem; line-height: 1.7; }
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

  <!-- Judul Lowongan -->
  <section class="job-header text-center">
      <h1><?php echo htmlspecialchars($row['title']); ?></h1>
      <p class="lead">Diposting pada: <?php echo date("d M Y", strtotime($row['date_posted'])); ?></p>
  </section>

  <!-- Isi Lowongan & Form -->
  <main class="container my-5">
    <div class="row g-5">
        <!-- Kiri: Detail Lowongan & Cek Status -->
        <div class="col-lg-7">
            <div class="card job-details-card shadow-sm p-4">
                <div class="card-body">
                    <h3 class="mb-4">Detail Pekerjaan</h3>
                    <div class="mb-4">
                        <div class="detail-item"><i class="bi bi-geo-alt-fill"></i><div><strong>Lokasi:</strong><br><?php echo htmlspecialchars($row['location']); ?></div></div>
                        <div class="detail-item"><i class="bi bi-briefcase-fill"></i><div><strong>Tipe Pekerjaan:</strong><br><?php echo htmlspecialchars($row['job_type']); ?></div></div>
                        <?php if(!empty($row['closing_date'])): ?>
                        <div class="detail-item"><i class="bi bi-calendar-x-fill"></i><div><strong>Batas Lamaran:</strong><br><?php echo date("d M Y", strtotime($row['closing_date'])); ?></div></div>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <h4 class="mt-4 mb-3">Deskripsi & Kualifikasi</h4>
                    <div class="content-text">
                        <?php echo nl2br($row['description']); ?>
                    </div>
                    
                    <hr class="my-5">

                    <!-- Cek Status Section -->
                    <div>
                      <h4 class="mb-3">Cek Status Lamaran Anda</h4>
                      <form action="detail_karir.php" method="GET">
                          <input type="hidden" name="id" value="<?php echo $id; ?>">
                          <div class="mb-3">
                              <label for="check_email" class="form-label">Masukkan Email yang Anda Gunakan Saat Melamar</label>
                              <input type="email" class="form-control" id="check_email" name="check_email" value="<?php echo isset($_GET['check_email']) ? htmlspecialchars($_GET['check_email']) : ''; ?>" required>
                          </div>
                          <button type="submit" class="btn btn-secondary w-100">Cek Status</button>
                      </form>
                      <?php echo $status_message; // Tampilkan hasil pengecekan status ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: Form Lamaran -->
        <div class="col-lg-5">
            <div class="card application-form-card shadow-sm p-4">
                <div class="card-body">
                    <h3 class="text-center mb-4">Lamar Posisi Ini</h3>
                    <?php echo $message; // Tampilkan pesan sukses/gagal lamaran ?>

                    <?php if ($is_open): ?>
                    <form action="detail_karir.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="cv" class="form-label">Upload CV (PDF, DOC, DOCX, maks 5MB)</label>
                            <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
                        </div>
                        <button type="submit" name="submit_application" class="btn btn-primary w-100 mt-3">Kirim Lamaran</button>
                    </form>
                    <?php else: ?>
                    <div class="alert alert-warning text-center">Lowongan ini sudah ditutup.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
  </main>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
