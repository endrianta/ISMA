<?php
include "config.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$message = "";
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $source_type = $_POST['source_type'];

    $video_path = ""; // Default to empty

    // Handle video source
    if ($source_type === 'youtube') {
        $video_path = mysqli_real_escape_string($conn, $_POST['video_link']);
    } elseif ($source_type === 'upload') {
        if (isset($_FILES["video_file"]) && $_FILES["video_file"]["error"] == 0) {
            $target_dir = "../assets/videos/pembelajaran/";
            // Create directory if it doesn't exist
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $video_filename = time() . '_' . basename($_FILES["video_file"]["name"]);
            $target_file = $target_dir . $video_filename;
            if (move_uploaded_file($_FILES["video_file"]["tmp_name"], $target_file)) {
                $video_path = $video_filename;
            } else {
                $message = "<p class='message-error'>Gagal mengunggah file video.</p>";
            }
        }
    }

    // Handle image thumbnail upload
    $image_path = "";
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $img_target_dir = "../assets/img/pembelajaran/";
        // Create directory if it doesn't exist
        if (!file_exists($img_target_dir)) {
            mkdir($img_target_dir, 0777, true);
        }
        $image_filename = time() . '_' . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $img_target_dir . $image_filename)) {
            $image_path = $image_filename;
        }
    }

    if (empty($message)) {
        $sql = "INSERT INTO pembelajaran (title, description, category, image, video) VALUES ('$title', '$description', '$category', '$image_path', '$video_path')";
        if (mysqli_query($conn, $sql)) {
            header("Location: pembelajaran.php?status=added");
            exit();
        } else {
            $message = "<p class='message-error'>Error saat menyimpan ke database: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Materi Pembelajaran - PT. ISMA</title>
    <link rel="icon" type="image/png" href="../assets/img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lato', Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
        header { background: #2c3e50; color: white; padding: 15px 30px; text-align: center; }
        .container { max-width: 800px; margin: 30px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
        h2 { margin-bottom: 25px; color: #2c3e50; font-weight: 700; border-bottom: 2px solid #f0f2f5; padding-bottom: 15px; }
        .back-link { display: inline-block; margin-bottom: 25px; color: #2c3e50; text-decoration: none; font-weight: bold; }
        .back-link:hover { text-decoration: underline; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 8px; color: #555; }
        input[type='text'], input[type='url'], textarea, select { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; transition: border-color 0.2s; }
        input[type='text']:focus, textarea:focus, select:focus { border-color: #2980b9; outline: none; }
        textarea { resize: vertical; min-height: 100px; }
        .form-buttons { margin-top: 30px; text-align: right; }
        .btn { padding: 12px 24px; border: none; border-radius: 6px; text-decoration: none; font-weight: bold; cursor: pointer; transition: opacity 0.2s; }
        .btn-primary { background-color: #27ae60; color: white; }
        .btn-secondary { background-color: #bdc3c7; color: #2c3e50; margin-left: 10px; }
        .btn:hover { opacity: 0.85; }
        .source-choice { display: flex; gap: 20px; margin-bottom: 15px; }
        .radio-label { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .message-error { padding: 15px; border-radius: 6px; margin-bottom: 20px; color: white; background-color: #e74c3c; }
    </style>
</head>
<body>
    <header><h1>Tambah Materi Pembelajaran Baru</h1></header>
    <div class="container">
        <a href="pembelajaran.php" class="back-link">← Kembali ke Daftar Materi</a>
        <h2>Detail Materi Baru</h2>
        <?= $message ?>
        <form action="add_pembelajaran.php" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="title">Judul Materi</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <select id="category" name="category">
                    <option value="general" selected>General (Publik)</option>
                    <option value="private">Private (Internal)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Sumber Video</label>
                <div class="source-choice">
                    <label class="radio-label"><input type="radio" name="source_type" value="upload" checked> Unggah File Video</label>
                    <label class="radio-label"><input type="radio" name="source_type" value="youtube"> Link YouTube</label>
                </div>
            </div>

            <div id="upload_input" class="form-group">
                <label for="video_file">File Video (MP4, WebM)</label>
                <input type="file" id="video_file" name="video_file" accept="video/mp4,video/webm,video/ogg">
            </div>

            <div id="youtube_input" class="form-group" style="display:none;">
                <label for="video_link">Link Video YouTube</label>
                <input type="url" id="video_link" name="video_link" placeholder="Contoh: https://www.youtube.com/watch?v=...">
            </div>

            <div class="form-group">
                <label for="image">Thumbnail (JPG, PNG)</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <div class="form-buttons">
                <a href="pembelajaran.php" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Materi</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const youtubeRadio = document.querySelector('input[name="source_type"][value="youtube"]');
            const uploadRadio = document.querySelector('input[name="source_type"][value="upload"]');
            const youtubeInput = document.getElementById('youtube_input');
            const uploadInput = document.getElementById('upload_input');
            
            function toggleVideoInputs() {
                if (youtubeRadio.checked) {
                    youtubeInput.style.display = 'block';
                    uploadInput.style.display = 'none';
                } else {
                    youtubeInput.style.display = 'none';
                    uploadInput.style.display = 'block';
                }
            }
            
            youtubeRadio.addEventListener('change', toggleVideoInputs);
            uploadRadio.addEventListener('change', toggleVideoInputs);
            
            toggleVideoInputs(); // Initial check on page load
        });
    </script>
</body>
</html>