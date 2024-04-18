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

// Query untuk mendapatkan daftar acara
$query = "SELECT * FROM events";
$stmt = $pdo->query($query);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Events</title>
    <!-- Sesuaikan dengan path CSS Anda -->
    <link rel="stylesheet" href="../assets/css/View Events.css">
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

    <div class="container">
        <h2>View Events</h2>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Event Date</th>
                    <th>Location</th>
                    <th>Organizer</th>
                    <th>Actions</th> <!-- Kolom baru untuk aksi -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo $event['event_name']; ?></td>
                        <td><?php echo $event['event_date']; ?></td>
                        <td><?php echo $event['location']; ?></td>
                        <td><?php echo $event['organizer']; ?></td>
                        <td>
                            <a href="edit_event.php?id=<?php echo $event['event_id']; ?>">Edit</a> |
                            <a href="delete_event.php?id=<?php echo $event['event_id']; ?>" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
