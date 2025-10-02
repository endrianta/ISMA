<?php
header('Content-Type: application/json');
// Sertakan file konfigurasi database dengan path yang benar
include "admin/config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid.']);
    exit;
}

if (!isset($_POST['nip']) || !isset($_POST['pembelajaran_id'])) {
    echo json_encode(['success' => false, 'message' => 'Data NIP atau ID materi tidak lengkap.']);
    exit;
}

$nip = trim($_POST['nip']);
$pembelajaran_id = (int)$_POST['pembelajaran_id'];

if (empty($nip)) {
    echo json_encode(['success' => false, 'message' => 'NIP tidak boleh kosong.']);
    exit;
}

// 1. Cek apakah NIP ini sudah pernah disetujui (trusted).
$check_approved_sql = "SELECT id FROM permintaan_akses WHERE nip = ? AND status = 'approved' LIMIT 1";
$stmt = $conn->prepare($check_approved_sql);
$stmt->bind_param("s", $nip);
$stmt->execute();
$approved_result = $stmt->get_result();

if ($approved_result->num_rows > 0) {
    // Jika NIP sudah trusted, ambil URL video dari materi yang diminta.
    $video_query = "SELECT video FROM pembelajaran WHERE id = ?";
    $stmt_video = $conn->prepare($video_query);
    $stmt_video->bind_param("i", $pembelajaran_id);
    $stmt_video->execute();
    $video_result = $stmt_video->get_result();

    if ($video_row = $video_result->fetch_assoc()) {
        $video_file = $video_row['video'];
        $video_url = "#";
        if (!empty($video_file)) {
            if (filter_var($video_file, FILTER_VALIDATE_URL)) {
                $video_url = $video_file;
            } else {
                $video_url = "assets/videos/pembelajaran/" . $video_file;
            }
        }
        echo json_encode([
            'success' => true, 
            'action' => 'play',
            'video_url' => $video_url
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menemukan detail video.']);
    }
    $stmt_video->close();
    exit;
}

// 2. Jika NIP belum trusted, cek apakah sudah ada permintaan sebelumnya.
$check_existing_sql = "SELECT status FROM permintaan_akses WHERE nip = ? AND pembelajaran_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt_existing = $conn->prepare($check_existing_sql);
$stmt_existing->bind_param("si", $nip, $pembelajaran_id);
$stmt_existing->execute();
$existing_result = $stmt_existing->get_result();

if ($existing_result->num_rows > 0) {
    $existing_request = $existing_result->fetch_assoc();
    if ($existing_request['status'] == 'pending') {
        echo json_encode(['success' => true, 'action' => 'message', 'message' => 'Anda sudah pernah mengirim permintaan. Mohon tunggu persetujuan Admin.']);
    } elseif ($existing_request['status'] == 'rejected') {
        echo json_encode(['success' => false, 'action' => 'message', 'message' => 'Permintaan Anda sebelumnya ditolak. Hubungi Admin.']);
    } else { // Jika statusnya approved tapi NIP-nya belum ada di tabel (kasus aneh), buat permintaan baru
        goto create_new_request;
    }
    $stmt_existing->close();
    exit;
}

// 3. Jika belum ada permintaan, buat permintaan baru.
create_new_request:
$insert_sql = "INSERT INTO permintaan_akses (nip, pembelajaran_id, status) VALUES (?, ?, 'pending')";
$stmt_insert = $conn->prepare($insert_sql);
$stmt_insert->bind_param("si", $nip, $pembelajaran_id);

if ($stmt_insert->execute()) {
    echo json_encode(['success' => true, 'action' => 'message', 'message' => 'Terima kasih! Permintaan Anda telah dikirim dan akan ditinjau oleh Admin.']);
} else {
    echo json_encode(['success' => false, 'action' => 'message', 'message' => 'Gagal menyimpan permintaan.']);
}

$stmt->close();
$stmt_insert->close();
$conn->close();
?>
