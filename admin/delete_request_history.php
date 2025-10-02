<?php
include "config.php";
session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Pastikan ID permintaan ada dan merupakan angka
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: pembelajaran.php?status=invalid_id#permintaan");
    exit;
}

$request_id = (int)$_GET['id'];

// Siapkan perintah DELETE untuk menghapus data dari tabel permintaan_akses
$sql = "DELETE FROM permintaan_akses WHERE id = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    header("Location: pembelajaran.php?status=prepare_failed#permintaan");
    exit();
}

$stmt->bind_param("i", $request_id);

if ($stmt->execute()) {
    // Jika penghapusan berhasil, arahkan kembali ke halaman pembelajaran
    header("Location: pembelajaran.php?status=delete_success#permintaan");
} else {
    // Jika gagal, arahkan kembali dengan pesan error
    header("Location: pembelajaran.php?status=delete_error#permintaan");
}

$stmt->close();
$conn->close();
?>
