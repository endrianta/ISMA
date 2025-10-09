<?php
include "config.php";
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['logout'])) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
    header("Location: login.php");
    exit;
}

// Query untuk menghitung materi pembelajaran private dan general
$pembelajaran_query = mysqli_query($conn, "SELECT 
                                            COUNT(CASE WHEN category = 'private' THEN 1 END) as private_count, 
                                            COUNT(CASE WHEN category = 'general' THEN 1 END) as general_count 
                                          FROM pembelajaran");
$pembelajaran_counts = mysqli_fetch_assoc($pembelajaran_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin - PT ISMA</title>
  <link rel="icon" type="image/png" href="../assets/img/logo.png">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { display: flex; background: #f4f6f9; }
    .sidebar { width: 220px; height: 100vh; background: #2c3e50; color: white; display: flex; flex-direction: column; justify-content: space-between; padding: 20px 0; position: fixed; }
    .sidebar h2 { text-align: center; margin-bottom: 20px; font-size: 20px; }
    .sidebar ul { list-style: none; padding: 0; margin: 0; }
    .sidebar ul li { padding: 15px 20px; transition: background 0.2s; }
    .sidebar ul li a { text-decoration: none; color: white; display: block; }
    .sidebar ul li:hover { background: #34495e; }
    .logout-container { padding: 20px; }
    .logout-btn { display: block; background: #e74c3c; color: white; text-align: center; padding: 10px; border-radius: 5px; text-decoration: none; transition: background 0.2s; }
    .logout-btn:hover { background: #c0392b; }
    .main-content { margin-left: 220px; padding: 20px; width: calc(100% - 220px); }
    .main-content h1 { margin-bottom: 20px; color: #2c3e50; }
    .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 20px; margin-top: 30px; }
    .card { background: linear-gradient(135deg, #87cefa, #e6f7ff); color: #003366; padding: 25px; border-radius: 15px; text-align: center; box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card:hover { transform: translateY(-8px); box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25); }
    .card h3 { margin-bottom: 12px; font-size: 18px; font-weight: 600; color: #004080; }
    .card p { font-size: 28px; font-weight: bold; color: #000; }
    
    /* Style untuk kartu yang dibagi */
    .card.split { padding: 15px 20px; }
    .card-split-container { display: flex; justify-content: space-around; align-items: center; text-align: center; margin-top: 15px; }
    .card-split-container .count { font-size: 28px; font-weight: bold; color: #000; margin: 0; }
    .card-split-container .label { font-size: 14px; color: #004080; }
  </style>
</head>
<body>
  <div class="sidebar">
    <div>
        <h2>ADMIN PT ISMA</h2>
        <ul>
            <li><a href="news.php">Kelola Berita</a></li>
            <li><a href="structure.php">Kelola Struktur</a></li>
            <li><a href="moment.php">Kelola Momen</a></li>
            <li><a href="contact.php">Kelola Kontak</a></li>
            <li><a href="admin_sub1.php">Kelola Aspek Hukum</a></li>
            <li><a href="sub5_list.php">Kelola Mitra</a></li>
            <li><a href="sertifikat.php">Kelola Sertifikat</a></li>
            <li><a href="pembelajaran.php">Kelola Pembelajaran</a></li>
            <li><a href="karir.php">Kelola Karir</a></li>
        </ul>
    </div>
    <div class="logout-container">
        <a href="?logout=true" class="logout-btn">Logout</a>
    </div>
  </div>

  <div class="main-content">
    <h1>Dashboard Admin</h1>
    <div class="cards">
      <div class="card">
        <h3>Total Berita</h3>
        <p><?= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM news"))['total']; ?></p>
      </div>
      <div class="card">
        <h3>Total Struktur</h3>
        <p><?= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM struktur_jabatan"))['total']; ?></p>
      </div>
      <div class="card">
        <h3>Total Momen</h3>
        <p><?= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM moment"))['total']; ?></p>
      </div>
      <div class="card">
        <h3>Total Kontak</h3>
        <p><?= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM contact"))['total']; ?></p>
      </div>
      <div class="card">
        <h3>Total Aspek Hukum</h3>
        <p><?= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM sub1"))['total']; ?></p>
      </div>
      <div class="card">
        <h3>Total Mitra</h3>
        <p><?= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM sub5"))['total']; ?></p>
      </div>
      <div class="card">
        <h3>Total Sertifikat</h3>
        <p><?= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM sertifikat"))['total']; ?></p>
      </div>
      <div class="card">
        <h3>Total Pelamar</h3>
        <p><?= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM applicants"))['total']; ?></p>
      </div>
      
      
      <!-- Materi Pembelajaran (SPLIT CARD) -->
      <div class="card split">
          <h3>Materi Pembelajaran</h3>
          <div class="card-split-container">
              <div>
                  <p class="count"><?= $pembelajaran_counts['private_count'] ?? 0 ?></p>
                  <div class="label">Private</div>
              </div>
              <div>
                  <p class="count"><?= $pembelajaran_counts['general_count'] ?? 0 ?></p>
                  <div class="label">General</div>
              </div>
          </div>
      </div>
    </div>
  </div>
</body>
</html>
