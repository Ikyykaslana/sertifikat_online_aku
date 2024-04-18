<?php
// Mulai session
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "user") {
    // Jika pengguna belum login atau bukan pengguna biasa, alihkan ke halaman login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Sesuaikan dengan path CSS Anda -->
    <link rel="stylesheet" href="../assets/css/admin_dashboard1.css">
</head>
<body>
<nav class="navbar">
            <ul>
                <li><a href="user_dashboard.php">Dashboard</a></li>
                <li><a href="view_certificates.php">View Certificates</a></li>
                <li><a href="../admin/logout.php">Logout</a></li>
            </ul>
    </nav>
    <div class="dashboard-container">
        <h2>Welcome to User Dashboard</h2>
        <!-- Tambahkan konten dashboard untuk pengguna biasa di sini -->
    </div>
</body>
</html>
