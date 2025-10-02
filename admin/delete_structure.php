<?php
include "config.php";
session_start();
if(!isset($_SESSION['username'])){ header("Location: login.php"); exit(); }

if(!isset($_GET['id'])) { header("Location: structure.php"); exit(); }
$id = intval($_GET['id']);

$result = mysqli_query($conn,"SELECT * FROM struktur_jabatan WHERE id=$id");
$data = mysqli_fetch_assoc($result);
if($data){
    if(!empty($data['image']) && file_exists("../assets/img/structure/".$data['image'])){
        unlink("../assets/img/structure/".$data['image']);
    }
    mysqli_query($conn,"DELETE FROM struktur_jabatan WHERE id=$id");
}
header("Location: structure.php");
exit();
?>
