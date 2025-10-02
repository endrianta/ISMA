<?php 
    include "config.php"; 
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Tambah Banner - PT. ISMA</title>
        <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
        <style>
            body { 
                font-family: Arial, sans-serif; 
                background: #f4f6f9; 
                margin:0; 
                padding:0;
            }
            header { 
                background:#2c3e50; 
                color:white; 
                padding:15px 30px; 
                text-align:center;
            }
            .container { 
                max-width:700px; 
                margin:40px auto; 
                background:white; 
                padding:30px; 
                border-radius:12px; 
                box-shadow:0 4px 15px rgba(0,0,0,0.1);
            }
            h2{text-align:center; margin-bottom:25px;}
            label{font-weight:bold; display:block; margin-bottom:8px; margin-top:15px;}
            input[type="text"], input[type="file"]{ 
                width:100%; 
                padding:10px; 
                border-radius:6px; 
                border:1px solid #ccc; 
                font-size:15px;
            }
            button{
                margin-top:20px; 
                background:#27ae60; 
                color:white; 
                border:none; 
                padding:12px 20px; 
                font-size:16px; 
                border-radius:8px; 
                cursor:pointer; 
                width:100%;
            }
            button:hover{background:#219150;}
            .back-link{
                display:inline-block; 
                margin-top:20px; 
                text-decoration:none; 
                color:#2980b9;
            }
            .back-link:hover{text-decoration:underline;}
        </style>
    </head>
    <body>
        <header><h1>Tambah Banner</h1></header>
        <div class="container">
            <h2>Tambah Banner Baru</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <label>Gambar</label>
                <input type="file" name="image" accept="image/*" required>

                <button type="submit" name="save">💾 Simpan</button>
            </form>
            <a href="event.php" class="back-link">← Kembali ke Daftar Banner</a>
        </div>

        <?php
            if(isset($_POST['save'])){
                $image = $_FILES['image']['name'];
                $tmp   = $_FILES['image']['tmp_name'];
                $ext   = strtolower(pathinfo($image, PATHINFO_EXTENSION));

                if(!is_dir("../assets/img/banner/")) mkdir("../assets/img/banner/", 0777, true);

                $new_name   = $image;
                $targetPath = "../assets/img/banner/".$new_name;

                // Buat image resource sesuai tipe file
                switch($ext){
                    case 'jpg':
                    case 'jpeg':
                        $src = imagecreatefromjpeg($tmp); break;
                    case 'png':
                        $src = imagecreatefrompng($tmp); break;
                    case 'gif':
                        $src = imagecreatefromgif($tmp); break;
                    case 'webp':
                        $src = imagecreatefromwebp($tmp); break;
                    default:
                        $src = null;
                }

                if($src){
                    $dst = imagecreatetruecolor(800, 600);
                    $width  = imagesx($src);
                    $height = imagesy($src);

                    imagecopyresampled($dst, $src, 0, 0, 0, 0, 800, 600, $width, $height);

                    if($ext == "png"){
                        imagepng($dst, $targetPath);
                    } elseif($ext == "gif"){
                        imagegif($dst, $targetPath);
                    } elseif($ext == "webp"){
                        imagewebp($dst, $targetPath, 90);
                    } else {
                        imagejpeg($dst, $targetPath, 90);
                    }

                    imagedestroy($src);
                    imagedestroy($dst);
                } else {
                    move_uploaded_file($tmp, $targetPath);
                }

                // Simpan ke database
                $sql = "INSERT INTO banner (image) VALUES ('$new_name')";
                if(mysqli_query($conn,$sql)){
                    header("Location: banner.php");
                    exit;
                } else {
                    echo "<p style='color:red;text-align:center;'>Gagal menyimpan banner!</p>";
                }
            }
        ?>
    </body>
</html>