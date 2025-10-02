<?php
function fixImagePath($html) {
    // Hilangkan "../" supaya path sesuai root project
    $html = str_replace('../', '', $html);

    // Kalau mau pakai base url
     $baseUrl = "";
    // $html = preg_replace('/src="(?!http)([^"]+)"/', 'src="'.$baseUrl.'$1"', $html);

    return $html;
}
?>
