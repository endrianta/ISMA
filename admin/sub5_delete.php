<?php
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ambil data untuk hapus gambar
    $result = mysqli_query($conn, "SELECT * FROM sub5 WHERE id=$id");
    $row = mysqli_fetch_assoc($result);

    if ($row && !empty($row['gambar']) && file_exists("../assets/img/mitra/".$row['gambar'])) {
        unlink("../assets/img/mitra/".$row['gambar']);
    }

    mysqli_query($conn, "DELETE FROM sub5 WHERE id=$id");
    header("Location: sub5_list.php?msg=✅ Mitra berhasil dihapus!");
    exit();
}
?>
