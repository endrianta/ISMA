<?php
include 'config.php';

$id = intval($_GET['id']);

// ambil data lama
$result = mysqli_query($conn, "SELECT gambar FROM sub1 WHERE id=$id");
$data = mysqli_fetch_assoc($result);

// hapus file gambar kalau ada
if ($data && $data['gambar'] && file_exists("../assets/img/" . $data['gambar'])) {
    unlink("../assets/img/" . $data['gambar']);
}

// hapus data dari database
mysqli_query($conn, "DELETE FROM sub1 WHERE id=$id");

// kembali ke list
header("Location: admin_sub1.php");
exit();
?>
