<?php
include 'config.php';

// 1. Tambah kolom pada tabel 'karir'
$sql_alter_karir = "
ALTER TABLE `karir`
ADD COLUMN `location` VARCHAR(100) NOT NULL AFTER `description`,
ADD COLUMN `job_type` VARCHAR(50) NOT NULL AFTER `location`,
ADD COLUMN `closing_date` DATE DEFAULT NULL AFTER `job_type`,
ADD COLUMN `status` ENUM('Dibuka', 'Ditutup') NOT NULL DEFAULT 'Dibuka' AFTER `closing_date`;
";

if (mysqli_query($conn, $sql_alter_karir)) {
    echo "Tabel 'karir' berhasil diupdate.<br>";
} else {
    echo "Error saat update tabel 'karir': " . mysqli_error($conn) . "<br>";
}

// 2. Buat tabel baru 'applicants' (pelamar)
$sql_create_applicants = "
CREATE TABLE IF NOT EXISTS `applicants` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `karir_id` INT NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `cv_path` VARCHAR(255) NOT NULL,
  `apply_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('Baru', 'Ditinjau', 'Lolos Seleksi Awal', 'Ditolak', 'Diterima') NOT NULL DEFAULT 'Baru',
  FOREIGN KEY (`karir_id`) REFERENCES `karir`(`id`) ON DELETE CASCADE
);
";

if (mysqli_query($conn, $sql_create_applicants)) {
    echo "Tabel 'applicants' berhasil dibuat.<br>";
} else {
    echo "Error saat membuat tabel 'applicants': " . mysqli_error($conn) . "<br>";
}

mysqli_close($conn);
?>