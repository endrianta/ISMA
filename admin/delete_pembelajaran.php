<?php
include "config.php";
session_start();

// Ensure user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Check if ID is provided and is a numeric value
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: pembelajaran.php?status=invalid_id");
    exit;
}

$id = (int)$_GET['id'];

// 1. Fetch the record to get image and video file names
// DIGANTI: Mengambil kolom 'video', bukan 'video_link'
$result = mysqli_query($conn, "SELECT image, video FROM pembelajaran WHERE id = $id");

if ($row = mysqli_fetch_assoc($result)) {
    // 2. Delete the associated image file
    if (!empty($row['image'])) {
        $image_path = "../assets/img/pembelajaran/" . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // 3. Delete the associated video file
    // DIGANTI: Menggunakan $row['video'] dan path yang benar
    $is_url = filter_var($row['video'], FILTER_VALIDATE_URL);

    // Jika bukan URL dan tidak kosong, maka itu file lokal yang harus dihapus
    if (!$is_url && !empty($row['video'])) {
        $video_path = "../assets/videos/pembelajaran/" . $row['video'];
        if (file_exists($video_path)) {
            unlink($video_path); // Perintah untuk menghapus file video
        }
    }

    // 4. Delete the record from the database
    $sql = "DELETE FROM pembelajaran WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: pembelajaran.php?status=delete_success");
    } else {
        header("Location: pembelajaran.php?status=delete_error");
    }
    exit();

} else {
    // If no record was found with that ID
    header("Location: pembelajaran.php?status=not_found");
    exit();
}
?>