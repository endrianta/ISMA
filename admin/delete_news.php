<?php
include 'config.php';

$id = intval($_GET['id']);

// ambil gambar lama
$result = mysqli_query($conn, "SELECT image FROM news WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if ($data['image'] && file_exists("../assets/img/news" . $data['image'])) {
    unlink("../assets/img/news/" . $data['image']); // hapus file fisik
}

// hapus data dari database
mysqli_query($conn, "DELETE FROM news WHERE id=$id");

header("Location: news.php");
?>
