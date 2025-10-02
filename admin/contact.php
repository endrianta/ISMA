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
    <title>Daftar Kontak - PT. ISMA</title>
    <link rel="icon" type="image/png" href="../assets/img/pelindo2.png">
    <style>
        body{font-family:Arial,sans-serif;background:#f4f6f9;margin:0;padding:0;}
        header{background:#2c3e50;color:white;padding:15px 30px;text-align:center;}
        .container{max-width:900px;margin:40px auto;background:white;padding:30px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.1);}
        h2{text-align:center;margin-bottom:25px;}
        table{width:100%;border-collapse:collapse;}
        table th,table td{border:1px solid #ccc;padding:10px;text-align:left;}
        table th{background:#ecf0f1;}
        a.btn{display:inline-block;margin: 5px;padding:8px 12px;border-radius:6px;text-decoration:none;color:white;font-size:14px;}
        .btn-add{background:#27ae60;}
        .btn-edit{background:#2980b9;}
        .btn-delete{background:#c0392b;}
        .btn:hover{opacity:0.85;}
    </style>
</head>
<body>
    <header><h1>Daftar Kontak</h1></header>
    <div class="container">
        <a href="admin.php" class="back-link">← Kembali</a>
        <h2>Data Kontak</h2>
        <a href="add_contact.php" class="btn btn-add">+ Tambah Kontak</a>
        <br><br>
        <table>
            <tr>
                <th>Section</th>
                <th>Type</th>
                <th>Label</th>
                <th>Value</th>
                <th>Aksi</th>
            </tr>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM contact ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>
                        <td>{$row['section']}</td>
                        <td>{$row['type']}</td>
                        <td>{$row['label']}</td>
                        <td>{$row['value']}</td>
                        <td>
                            <a href='edit_contact.php?id={$row['id']}' class='btn btn-edit'>✏ Edit</a> 
                            <a href='delete_contact.php?id={$row['id']}' class='btn btn-delete' onclick=\"return confirm('Yakin hapus data ini?')\">🗑 Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
