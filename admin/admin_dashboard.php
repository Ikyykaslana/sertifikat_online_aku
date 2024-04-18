<?php
// Mulai session
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin") {
    // Jika pengguna belum login atau bukan admin, alihkan ke halaman login
    header("Location: login.php");
    exit();
}

// Include koneksi ke database
include_once '../includes/koneksi.php';

// Query untuk menghitung total certificates
$queryTotalCertificates = "SELECT COUNT(*) AS total_certificates FROM certificates";
$stmtTotalCertificates = $pdo->prepare($queryTotalCertificates);
$stmtTotalCertificates->execute();
$totalCertificates = $stmtTotalCertificates->fetch(PDO::FETCH_ASSOC)['total_certificates'];

// Query untuk menghitung total users
$queryTotalUsers = "SELECT COUNT(*) AS total_users FROM users";
$stmtTotalUsers = $pdo->prepare($queryTotalUsers);
$stmtTotalUsers->execute();
$totalUsers = $stmtTotalUsers->fetch(PDO::FETCH_ASSOC)['total_users'];

// Query untuk menghitung total events
$queryTotalEvents = "SELECT COUNT(*) AS total_events FROM events";
$stmtTotalEvents = $pdo->prepare($queryTotalEvents);
$stmtTotalEvents->execute();
$totalEvents = $stmtTotalEvents->fetch(PDO::FETCH_ASSOC)['total_events'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Sesuaikan dengan path CSS Anda -->
    <link rel="stylesheet" href="../assets/css/admin_dashboard1.css">
</head>
<body>
    <nav class="navbar">
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="create_event.php">Create Event</a></li>
                <li><a href="view_events.php">View Events</a></li>
                <li><a href="generate_certificates.php">Generate Certificates</a></li>
              
                <li><a href="view_certificates.php">View Certificates</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
    </nav>

    <div class="dashboard-container">
        <h2>Welcome to Admin Dashboard</h2>
        <div class="dashboard-stats">
            <div class="stat">
                <h3>Total Certificates</h3>
                <p><?php echo $totalCertificates; ?></p>
            </div>
            <div class="stat">
                <h3>Total Users</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="stat">
                <h3>Total Events</h3>
                <p><?php echo $totalEvents; ?></p>
            </div>
        </div>
        <!-- Tambahkan konten dashboard untuk admin di sini -->
    </div>
</body>
</html>