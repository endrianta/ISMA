<?php
include "config.php";

if ($_FILES['file']['name']) {
    $filename = uniqid()."_".$_FILES['file']['name'];
    $location = "../assets/img/karir/".$filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
        echo json_encode([
            'link' => "assets/img/karir/".$filename
        ]);
    }
}
?>
