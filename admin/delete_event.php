<?php
// Mulai session
session_start();

// Periksa apakah pengguna sudah login dan merupakan admin
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin") {
    // Jika pengguna belum login atau bukan admin, alihkan ke halaman login
    header("Location: login_admin.php");
    exit();
}

// Include koneksi ke database
include_once '../includes/koneksi.php';

// Periksa apakah parameter id acara telah diberikan
if (!isset($_GET['id'])) {
    header("Location: view_events.php");
    exit();
}

// Ambil id acara dari parameter
$event_id = $_GET['id'];

// Query untuk menghapus acara berdasarkan id
$delete_query = "DELETE FROM events WHERE event_id = :event_id";
$stmt = $pdo->prepare($delete_query);
$stmt->execute(['event_id' => $event_id]);

// Alihkan kembali ke halaman view_events.php setelah penghapusan berhasil
header("Location: view_events.php");
exit();
?>
