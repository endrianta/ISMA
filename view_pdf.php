<?php
if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $filepath = 'assets/img/sertifikat/' . $filename;

    if (file_exists($filepath) && strtolower(pathinfo($filepath, PATHINFO_EXTENSION)) === 'pdf') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat - PT. ISMA</title>
    <link href="assets/img/logo.png" rel="icon">
    <style>
        body, html { margin: 0; padding: 0; height: 100%; overflow: hidden; }
        iframe { border: none; width: 100%; height: 100%; }
    </style>
</head>
<body>
    <iframe src="<?php echo htmlspecialchars($filepath); ?>"></iframe>
</body>
</html>
<?php
        exit;
    }
}
http_response_code(404);
echo "File not found.";
?>