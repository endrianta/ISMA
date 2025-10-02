<?php 
include "config.php"; 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$data = mysqli_query($conn,"SELECT * FROM contact WHERE id='$id'");
$row = mysqli_fetch_assoc($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kontak - PT. ISMA</title>
    <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
    <style>
        body {font-family: Arial, sans-serif; background:#f4f6f9; margin:0;}
        header {background:#2c3e50; color:white; padding:15px 30px; text-align:center;}
        .container {max-width:700px; margin:40px auto; background:white; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);}
        h2{text-align:center; margin-bottom:25px;}
        label{font-weight:bold; display:block; margin-bottom:8px; margin-top:15px;}
        input, select, textarea{width:100%; padding:10px; border-radius:6px; border:1px solid #ccc; font-size:15px;}
        button{margin-top:20px; background:#2980b9; color:white; border:none; padding:12px 20px; font-size:16px; border-radius:8px; cursor:pointer; width:100%;}
        button:hover{background:#21618c;}
        .back-link{display:inline-block; margin-top:20px; text-decoration:none; color:#2980b9;}
        .back-link:hover{text-decoration:underline;}
    </style>
</head>
<body>
<header><h1>Edit Kontak</h1></header>
<div class="container">
    <h2>Edit Data Kontak</h2>
    <form method="POST">
        <label>Section</label>
        <select name="section" required>
            <option value="contact" <?php if($row['section']=="contact") echo "selected"; ?>>Contact</option>
            <option value="footer" <?php if($row['section']=="footer") echo "selected"; ?>>Footer</option>
        </select>

        <label>Type</label>
        <input type="text" name="type" value="<?php echo $row['type']; ?>" required>

        <label>Label</label>
        <input type="text" name="label" value="<?php echo $row['label']; ?>" required>

        <label>Value</label>
        <textarea name="value" required><?php echo $row['value']; ?></textarea>

        <button type="submit" name="update">💾 Update</button>
    </form>
    <a href="contact.php" class="back-link">← Kembali</a>
</div>

<?php
if(isset($_POST['update'])){
    $section = $_POST['section'];
    $type = $_POST['type'];
    $label = $_POST['label'];
    $value = $_POST['value'];

    $sql = "UPDATE contact SET section='$section', type='$type', label='$label', value='$value' WHERE id='$id'";
    if(mysqli_query($conn,$sql)){
        header("Location: contact.php");
        exit;
    } else {
        echo "<p style='color:red;text-align:center;'>Gagal update data!</p>";
    }
}
?>
</body>
</html>
