<?php 
include "config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// pastikan ada ID
if (!isset($_GET['id'])) {
    header("Location: karir.php");
    exit();
}

$id = intval($_GET['id']);

// ambil data lama
$result = mysqli_query($conn, "SELECT * FROM karir WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit();
}

// handle update
if (isset($_POST['update'])) {
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $date_posted = $_POST['date_posted'];
    $image       = $data['image']; // default: gambar lama

    if (!empty($_FILES['image']['name'])) {
        $allowed_ext = ['jpg','jpeg','png','gif','webp'];
        $file_name   = $_FILES['image']['name'];
        $file_tmp    = $_FILES['image']['tmp_name'];
        $ext         = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed_ext)) {
            $new_name = time() . "_" . basename($file_name);
            $image_path = "../assets/img/karir/";
            if(!is_dir($image_path)) mkdir($image_path, 0755, true);
            $target = $image_path . $new_name;

            if (move_uploaded_file($file_tmp, $target)) {
                if (!empty($data['image']) && file_exists($image_path . $data['image'])) {
                    unlink($image_path . $data['image']);
                }
                $image = $new_name;
            }
        } else {
            echo "<p style='color:red;text-align:center;'>Format file tidak didukung!</p>";
        }
    }

    $sql = "UPDATE karir SET 
            title='$title',
            description='$description',
            date_posted='$date_posted',
            image='$image'
            WHERE id=$id";

    if(mysqli_query($conn,$sql)){
        header("Location: edit_karir.php?id=$id&success=1");
        exit();
    } else {
        echo "<p style='color:red;text-align:center;'>Gagal update lowongan!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Lowongan Karir - PT. ISMA</title>
  <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 0;
    }

    header {
      background: #2c3e50;
      color: white;
      padding: 15px 30px;
      text-align: center;
    }

    .container {
      max-width: 900px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    h2 {
      margin-bottom: 25px;
      color: #2c3e50;
      text-align: center;
    }

    label {
      font-weight: bold;
      display: block;
      margin-bottom: 8px;
      margin-top: 15px;
    }

    input[type="text"], input[type="date"], textarea, input[type="file"] {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
      box-sizing: border-box;
    }

    textarea {
      height: 150px;
      resize: vertical;
    }

    button {
      margin-top: 20px;
      background: #27ae60;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
      width: 100%;
    }
    button:hover {
      background: #219150;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #2980b9;
    }
    .back-link:hover {
      text-decoration: underline;
    }

    .preview {
      margin-top: 10px;
      text-align: center;
    }
    .preview img {
      margin-top: 8px;
      max-width: 200px;
      border:1px solid #ccc;
      padding:5px;
      border-radius:8px;
    }
    .alert-success {
      background: #d4edda; 
      color: #155724; 
      border: 1px solid #c3e6cb; 
      padding: 10px; 
      margin-bottom: 15px; 
      border-radius: 6px;
      text-align:center;
    }
  </style>
</head>
<body>
  <header>
    <h1>Edit Lowongan Karir</h1>
  </header>

  <div class="container">
    <h2>Edit Lowongan</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert-success">✅ Data berhasil diperbarui!</div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
      <label>Judul</label>
      <input type="text" name="title" value="<?php echo htmlspecialchars($data['title']); ?>" required>

      <label>Deskripsi</label>
      <textarea name="description" required><?php echo htmlspecialchars($data['description']); ?></textarea>

      <label>Tanggal Posting</label>
      <input type="date" name="date_posted" value="<?php echo htmlspecialchars($data['date_posted']); ?>" required>

      <div class="preview">
          <p>Gambar Saat Ini:</p>
          <?php if(!empty($data['image'])): ?>
              <img src="../assets/img/karir/<?php echo htmlspecialchars($data['image']); ?>" alt="Gambar Lowongan">
          <?php else: ?>
              <p><i>Tidak ada gambar</i></p>
          <?php endif; ?>
      </div>

      <label>Ganti Gambar</label>
      <input type="file" name="image" accept="image/*">

      <button type="submit" name="update">💾 Update</button>
    </form>

    <a href="karir.php" class="back-link">← Kembali ke Daftar Lowongan</a>
  </div>
</body>
</html>
