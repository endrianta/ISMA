<?php
include "config.php";
session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Pastikan ID permintaan ada dan valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: pembelajaran.php?status=invalid_request_id");
    exit;
}

$request_id = (int)$_GET['id'];

// Update status permintaan menjadi 'approved' dan catat waktunya
$sql = "UPDATE permintaan_akses SET status = 'approved', updated_at = NOW() WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $request_id);

if ($stmt->execute()) {
    // Jika berhasil, kembali ke halaman pembelajaran
    header("Location: pembelajaran.php?status=approved_success#permintaan");
} else {
    // Jika gagal, kembali dengan pesan error
    header("Location: pembelajaran.php?status=update_error#permintaan");
}

$stmt->close();
$conn->close();
?>
