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

// Query untuk mendapatkan informasi acara berdasarkan id
$query = "SELECT * FROM events WHERE event_id = :event_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['event_id' => $event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

// Periksa apakah acara dengan id yang diberikan ada dalam database
if (!$event) {
    header("Location: view_events.php");
    exit();
}

// Proses form jika ada data yang dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $organizer = $_POST['organizer'];

    // Query untuk memperbarui informasi acara
    $update_query = "UPDATE events SET event_name = :event_name, event_date = :event_date, location = :location, organizer = :organizer WHERE event_id = :event_id";
    $stmt = $pdo->prepare($update_query);
    $stmt->execute([
        'event_name' => $event_name,
        'event_date' => $event_date,
        'location' => $location,
        'organizer' => $organizer,
        'event_id' => $event_id
    ]);

    // Alihkan kembali ke halaman view_events.php setelah update berhasil
    header("Location: view_events.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <!-- Sesuaikan dengan path CSS Anda -->
    <link rel="stylesheet" href="../assets/css/edit_event.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="create_event.php">Create Event</a></li>
                <li><a href="view_events.php">View Events</a></li>
                <li><a href="generate_certificates.php">Generate Certificates</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="view_certificates.php">View Certificates</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>Edit Event</h2>
        <form method="POST">
            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" value="<?php echo $event['event_name']; ?>">
            <label for="event_date">Event Date:</label>
            <input type="date" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo $event['location']; ?>">
            <label for="organizer">Organizer:</label>
            <input type="text" id="organizer" name="organizer" value="<?php echo $event['organizer']; ?>">
            <button type="submit">Update Event</button>
        </form>
    </div>
</body>
</html>
