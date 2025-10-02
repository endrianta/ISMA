<?php 
include "config.php"; 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: moment.php");
    exit();
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM moment WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if(!$data){
    echo "Data tidak ditemukan.";
    exit();
}

// Handle update
if(isset($_POST['update'])){
    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $image = $data['image'];

    if(!empty($_FILES['image']['name'])){
        $file_name = $_FILES['image']['name'];
        $file_tmp  = $_FILES['image']['tmp_name'];
        $ext       = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed   = ['jpg','jpeg','png','gif','webp'];

        if(in_array($ext,$allowed)){
            $new_name = $file_name;
            if(!is_dir("../assets/img/moment")) mkdir("../assets/img/moment",0777,true);
            $target = "../assets/img/moment/".$new_name;

            if(move_uploaded_file($file_tmp,$target)){
                // ==== Resize supaya seragam ====
                switch($ext){
                    case 'jpg':
                    case 'jpeg':
                        $src = imagecreatefromjpeg($target); break;
                    case 'png':
                        $src = imagecreatefrompng($target); break;
                    case 'gif':
                        $src = imagecreatefromgif($target); break;
                    case 'webp':
                        $src = imagecreatefromwebp($target); break;
                    default:
                        $src = null;
                }
                if($src){
                    $dst = imagecreatetruecolor(800, 600);
                    $width  = imagesx($src);
                    $height = imagesy($src);

                    imagecopyresampled($dst, $src, 0, 0, 0, 0, 800, 600, $width, $height);

                    if($ext == "png"){
                        imagepng($dst, $target);
                    } elseif($ext == "gif"){
                        imagegif($dst, $target);
                    } elseif($ext == "webp"){
                        imagewebp($dst, $target, 90);
                    } else {
                        imagejpeg($dst, $target, 90);
                    }

                    imagedestroy($src);
                    imagedestroy($dst);
                }
                // ==== End Resize ====

                if(!empty($data['image']) && file_exists("../assets/img/moment/".$data['image'])){
                    unlink("../assets/img/moment/".$data['image']);
                }
                $image = $new_name;
            }
        } else {
            echo "<p style='color:red;text-align:center;'>Format file tidak didukung!</p>";
        }
    }

    $sql = "UPDATE moment SET title='$title', image='$image' WHERE id=$id";
    if(mysqli_query($conn,$sql)){
        header("Location: edit_moment.php?id=$id&success=1");
        exit;
    } else {
        echo "<p style='color:red;text-align:center;'>Gagal update moment!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Moment - PT. ISMA</title>
<link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
<style>
/* Sama style seperti edit_news.php */
body { font-family: Arial, sans-serif; background:#f4f6f9; margin:0; padding:0;}
header { background:#2c3e50; color:white; padding:15px 30px; text-align:center;}
.container { max-width:700px; margin:40px auto; background:white; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);}
h2{text-align:center; margin-bottom:25px;}
label{font-weight:bold; display:block; margin-bottom:8px; margin-top:15px;}
input[type="text"], input[type="file"]{ width:100%; padding:10px; border-radius:6px; border:1px solid #ccc; font-size:15px;}
button{margin-top:20px; background:#27ae60; color:white; border:none; padding:12px 20px; font-size:16px; border-radius:8px; cursor:pointer; width:100%;}
button:hover{background:#219150;}
.back-link{display:inline-block; margin-top:20px; text-decoration:none; color:#2980b9;}
.back-link:hover{text-decoration:underline;}
.preview{margin-top:10px;text-align:center;}
.preview img{max-width:200px;border:1px solid #ccc;padding:5px;border-radius:8px;}
.alert-success{background:#d4edda;color:#155724;border:1px solid #c3e6cb;padding:10px;margin-bottom:15px;border-radius:6px;text-align:center;}
</style>
</head>
<body>
<header><h1>Edit Moment</h1></header>
<div class="container">
<h2>Edit Moment</h2>
<?php if(isset($_GET['success'])): ?>
<div class="alert-success">✅ Data berhasil diperbarui!</div>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data">
    <label>Judul</label>
    <input type="text" name="title" value="<?= htmlspecialchars($data['title']) ?>" required>

    <div class="preview">
        <p>Gambar Saat Ini:</p>
        <?php if(!empty($data['image'])): ?>
            <img src="../assets/img/moment/<?= htmlspecialchars($data['image']) ?>" alt="Gambar Moment">
        <?php else: ?>
            <p><i>Tidak ada gambar</i></p>
        <?php endif; ?>
    </div>

    <label>Ganti Gambar</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit" name="update">💾 Update</button>
</form>

<a href="moment.php" class="back-link">← Kembali ke Daftar Moment</a>
</div>
</body>
</html>