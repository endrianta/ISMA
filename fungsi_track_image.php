<?php 
function fixImagePath($html) {
    $baseUrl = ""; // ganti sesuai domain/hosting kamu
    return preg_replace('/src="\.\.\//', 'src="'.$baseUrl, $html);
}
?>