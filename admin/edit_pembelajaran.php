<?php
include "config.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: pembelajaran.php");
    exit;
}
$id = (int)$_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM pembelajaran WHERE id=$id");
if (mysqli_num_rows($result) == 0) {
    header("Location: pembelajaran.php");
    exit;
}
$row = mysqli_fetch_assoc($result);

// Menentukan tipe video: link atau file upload
$video_type = 'none';
if (!empty($row['video'])) {
    if (filter_var($row['video'], FILTER_VALIDATE_URL)) {
        $video_type = 'youtube';
    } else {
        $video_type = 'upload';
    }
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $source_type = $_POST['source_type'];

    $video_path = $row['video']; // Simpan nilai lama

    // Logika untuk YouTube
    if ($source_type === 'youtube') {
        if ($video_type == 'upload' && !empty($video_path) && file_exists("../assets/videos/pembelajaran/" . $video_path)) {
            unlink("../assets/videos/pembelajaran/" . $video_path); // Hapus file video lama
        }
        $video_path = mysqli_real_escape_string($conn, $_POST['video_link']);
    } 
    // Logika untuk Upload File
    elseif ($source_type === 'upload') {
        if (isset($_FILES["video_file"]) && $_FILES["video_file"]["error"] == 0) {
            if ($video_type == 'upload' && !empty($video_path) && file_exists("../assets/videos/pembelajaran/" . $video_path)) {
                unlink("../assets/videos/pembelajaran/" . $video_path); // Hapus file video lama jika ada
            }
            $target_dir = "../assets/videos/pembelajaran/";
            $video_filename = time() . '_' . basename($_FILES["video_file"]["name"]);
            $target_file = $target_dir . $video_filename;
            if (move_uploaded_file($_FILES["video_file"]["tmp_name"], $target_file)) {
                $video_path = $video_filename;
            } else {
                $message = "<p class='message-error'>Gagal mengunggah video baru.</p>";
            }
        }
    }

    // Logika untuk gambar thumbnail
    $image_path = $row['image'];
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        if (!empty($image_path) && file_exists("../assets/img/pembelajaran/" . $image_path)) {
            unlink("../assets/img/pembelajaran/" . $image_path);
        }
        $img_target_dir = "../assets/img/pembelajaran/";
        $image_filename = time() . '_' . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $img_target_dir . $image_filename)) {
            $image_path = $image_filename;
        }
    }

    if (empty($message)) {
        $sql = "UPDATE pembelajaran SET title='$title', description='$description', category='$category', image='$image_path', video='$video_path' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            header("Location: pembelajaran.php?status=edited");
            exit();
        } else {
            $message = "<p class='message-error'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Materi Pembelajaran - PT. ISMA</title>
    <link rel="icon" type="image/png" href="../assets/img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lato', Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
        header { background: #2c3e50; color: white; padding: 15px 30px; text-align: center; }
        .container { max-width: 800px; margin: 30px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
        h2 { margin-bottom: 25px; color: #2c3e50; font-weight: 700; border-bottom: 2px solid #f0f2f5; padding-bottom: 15px; }
        .back-link { display: inline-block; margin-bottom: 25px; color: #2c3e50; text-decoration: none; font-weight: bold; }
        .back-link:hover { text-decoration: underline; }
        
        /* Form Styles */
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 8px; color: #555; }
        input[type='text'], input[type='url'], textarea, select { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; transition: border-color 0.2s; }
        input[type='text']:focus, textarea:focus, select:focus { border-color: #2980b9; outline: none; }
        textarea { resize: vertical; min-height: 100px; }
        .form-buttons { margin-top: 30px; text-align: right; }
        .btn { padding: 12px 24px; border: none; border-radius: 6px; text-decoration: none; font-weight: bold; cursor: pointer; transition: opacity 0.2s; }
        .btn-primary { background-color: #2980b9; color: white; }
        .btn-secondary { background-color: #bdc3c7; color: #2c3e50; margin-left: 10px; }
        .btn:hover { opacity: 0.85; }

        /* Custom Controls for Video Source */
        .source-choice { display: flex; gap: 20px; margin-bottom: 15px; }
        .radio-label { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .current-media { background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 20px; }
        .current-media p { margin: 0 0 10px 0; font-weight: bold; }
        .message-error, .message-success { padding: 15px; border-radius: 6px; margin-bottom: 20px; color: white; }
        .message-error { background-color: #e74c3c; }
    </style>
</head>
<body>
    <header><h1>Ubah Materi Pembelajaran</h1></header>
    <div class="container">
        <a href="pembelajaran.php" class="back-link">← Kembali ke Daftar Materi</a>
        <h2>Edit Detail Materi</h2>
        <?= $message ?>
        <form action="edit_pembelajaran.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="title">Judul Materi</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="4"><?= htmlspecialchars($row['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <select id="category" name="category">
                    <option value="general" <?= ($row['category'] == 'general') ? 'selected' : '' ?>>General (Publik)</option>
                    <option value="private" <?= ($row['category'] == 'private') ? 'selected' : '' ?>>Private (Internal)</option>
                </select>
            </div>

            <div class="current-media">
                <p>Media Saat Ini:</p>
                <?php if ($video_type == 'youtube'): ?>
                    Link YouTube: <a href="<?= htmlspecialchars($row['video']) ?>" target="_blank">Lihat Video</a>
                <?php elseif ($video_type == 'upload'): ?>
                    <video src="../assets/videos/pembelajaran/<?= htmlspecialchars($row['video']) ?>" width="300" controls></video>
                <?php else: ?>
                    <span>Tidak ada video.</span>
                <?php endif; ?>
                <br><br>
                <?php if (!empty($row['image']) && file_exists("../assets/img/pembelajaran/" . $row['image'])): ?>
                    <p style="margin-top:10px;">Thumbnail:</p>
                    <img src="../assets/img/pembelajaran/<?= htmlspecialchars($row['image']) ?>" alt="Thumbnail" style="max-width: 200px; border-radius: 6px;">
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Ubah Sumber Video</label>
                <div class="source-choice">
                    <label class="radio-label"><input type="radio" name="source_type" value="youtube" <?= ($video_type == 'youtube') ? 'checked' : '' ?>> Link YouTube</label>
                    <label class="radio-label"><input type="radio" name="source_type" value="upload" <?= ($video_type == 'upload' || $video_type == 'none') ? 'checked' : '' ?>> Unggah File Video</label>
                </div>
            </div>

            <div id="youtube_input" class="form-group">
                <label for="video_link">Link Video YouTube</label>
                <input type="url" id="video_link" name="video_link" placeholder="Contoh: https://www.youtube.com/watch?v=..." value="<?= ($video_type == 'youtube') ? htmlspecialchars($row['video']) : '' ?>">
            </div>

            <div id="upload_input" class="form-group">
                <label for="video_file">File Video (MP4, WebM)</label>
                <input type="file" id="video_file" name="video_file" accept="video/mp4,video/webm,video/ogg">
                <small style="display:block; margin-top:5px; color:#777;">Pilih file hanya jika ingin mengganti video yang sudah ada.</small>
            </div>

            <div class="form-group">
                <label for="image">Ganti Thumbnail (JPG, PNG)</label>
                <input type="file" id="image" name="image" accept="image/*">
                <small style="display:block; margin-top:5px; color:#777;">Pilih file hanya jika ingin mengganti thumbnail.</small>
            </div>

            <div class="form-buttons">
                <a href="pembelajaran.php" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
            
            // Run on page load
            toggleVideoInputs();
        });
    </script>
</body>
</html>