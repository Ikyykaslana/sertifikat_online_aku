<?php
// Mulai session
session_start();

// Periksa apakah pengguna sudah login dan memiliki akses admin
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin") {
    // Jika pengguna belum login atau bukan admin, alihkan ke halaman login
    header("Location: login_admin.php");
    exit();
}

// Include koneksi ke database
include_once '../includes/koneksi.php';

// Query untuk mengambil daftar sertifikat
$queryCertificates = "SELECT * FROM certificates";
$stmtCertificates = $pdo->prepare($queryCertificates);
$stmtCertificates->execute();
$certificates = $stmtCertificates->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Certificates</title>
    <!-- Sesuaikan dengan path CSS Anda -->
    <link rel="stylesheet" href="../assets/css/view_certificates.css">
</head>
<body>
    <nav class="navbar">
            <ul>
                <!-- Tautan navigasi menuju halaman-halaman terkait -->
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="create_event.php">Create Event</a></li>
                <li><a href="view_events.php">View Events</a></li>
                <li><a href="generate_certificates.php">Generate Certificates</a></li>
               
                <li><a href="view_certificates.php">View Certificates</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
    </nav>

    <div class="container">
        <h2>View Certificates</h2>
        <!-- Tabel untuk menampilkan daftar sertifikat -->
        <table>
            <thead>
                <tr>
                    <th>Certificate ID</th>
                    <th>Participant Name</th>
                    <th>Event Name</th>
                    <th>Event Date</th>
                    <th>Certificate Text</th> <!-- Kolom untuk Certificate Text -->
                    <th>Created At</th>
                    <th>View PDF</th> <!-- Kolom untuk View PDF -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($certificates as $certificate): ?>
                <tr>
                    <td><?php echo $certificate['certificate_id']; ?></td>
                    <td><?php echo $certificate['participant_name']; ?></td>
                    <td><?php echo $certificate['event_name']; ?></td>
                    <td><?php echo $certificate['event_date']; ?></td>
                    <td><?php echo $certificate['certificate_text']; ?></td>
                    <td><?php echo $certificate['created_at']; ?></td>
                    <td><a href="certificate_pdf.php?certificate_id=<?php echo $certificate['certificate_id']; ?>" target="_blank">View PDF</a></td> <!-- Tautan untuk View PDF -->
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
