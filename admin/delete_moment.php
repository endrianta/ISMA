<?php
include 'config.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);

// ambil gambar lama
$result = mysqli_query($conn, "SELECT image FROM moment WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if($data['image'] && file_exists("../assets/img/moment/".$data['image'])){
    unlink("../assets/img/moment/".$data['image']);
}

// hapus data dari DB
mysqli_query($conn, "DELETE FROM moment WHERE id=$id");

header("Location: moment.php");
exit;
?>
