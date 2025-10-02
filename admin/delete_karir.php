<?php
include 'config.php';

$id = intval($_GET['id']);

// ambil gambar lama
$result = mysqli_query($conn, "SELECT image FROM karir WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if ($data['image'] && file_exists("../assets/img/karir/" . $data['image'])) {
    unlink("../assets/img/karir/" . $data['image']); // hapus file fisik
}

// hapus data dari database
mysqli_query($conn, "DELETE FROM karir WHERE id=$id");

header("Location: karir.php");
?>
