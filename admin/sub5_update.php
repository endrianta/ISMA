<?php
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id       = $_POST['id'];
    $nama     = $_POST['nama'];
    $kategori = $_POST['kategori'];

    // Validasi kategori hanya boleh 3 pilihan
    $allowedKategori = ["Pelindo Group", "Non Pelindo", "Organisasi"];
    if (!in_array($kategori, $allowedKategori)) {
        echo "<script>alert('Kategori tidak valid!'); window.location.href='sub5_list.php';</script>";
        exit();
    }

    // ambil data lama (untuk hapus gambar jika diganti)
    $result = mysqli_query($conn, "SELECT * FROM sub5 WHERE id='$id'");
    $oldData = mysqli_fetch_assoc($result);

    $gambar = $_FILES['gambar']['name'];

    if (!empty($gambar)) {
        $targetDir  = "../assets/img/mitra/";
        $targetFile = $targetDir . basename($gambar);
        $dbPath     = "assets/img/mitra/" . basename($gambar);

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            // hapus file lama jika ada
            if (!empty($oldData['gambar']) && file_exists("../" . $oldData['gambar'])) {
                unlink("../" . $oldData['gambar']);
            }
            $update = "UPDATE sub5 SET nama='$nama', kategori='$kategori', gambar='$dbPath' WHERE id='$id'";
        } else {
            echo "<script>alert('Gagal upload gambar baru!'); window.location.href='sub5_list.php';</script>";
            exit();
        }
    } else {
        // update tanpa ganti gambar
        $update = "UPDATE sub5 SET nama='$nama', kategori='$kategori' WHERE id='$id'";
    }

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('✅ Perubahan berhasil disimpan!'); window.location.href='sub5_list.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal menyimpan perubahan!'); window.location.href='sub5_list.php';</script>";
    }
}
?>
