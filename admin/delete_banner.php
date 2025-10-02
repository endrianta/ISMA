<?php
    include 'config.php';
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    $id = intval($_GET['id']);

    // ambil gambar lama
    $result = mysqli_query($conn, "SELECT image FROM banner WHERE id=$id");
    $data = mysqli_fetch_assoc($result);

    if($data['image'] && file_exists("../assets/img/banner/".$data['image'])){
        unlink("../assets/img/banner/".$data['image']);
    }

    // hapus data dari DB
    mysqli_query($conn, "DELETE FROM banner WHERE id=$id");

    header("Location: banner.php");
    exit;
?>
