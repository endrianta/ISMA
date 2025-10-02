<?php
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // ambil file sertifikat lama
    $result = mysqli_query($conn, "SELECT file_sertifikat FROM sertifikat WHERE id=$id");
    $row = mysqli_fetch_assoc($result);

    if ($row && !empty($row['file_sertifikat']) && file_exists("../assets/img/sertifikat/" . $row['file_sertifikat'])) {
        // hapus file dari folder
        unlink("../assets/img/sertifikat/" . $row['file_sertifikat']);
    }

    // hapus data dari DB
    mysqli_query($conn, "DELETE FROM sertifikat WHERE id=$id");

    // redirect ke halaman manage
    header("Location: sertifikat.php?msg=✅ Sertifikat berhasil dihapus!");
    exit();
}
?>