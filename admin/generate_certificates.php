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

// Ambil daftar pengguna untuk pilihan dropdown
$queryUsers = "SELECT * FROM users";
$stmtUsers = $pdo->prepare($queryUsers);
$stmtUsers->execute();
$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

// Ambil daftar acara untuk pilihan dropdown
$queryEvents = "SELECT * FROM events";
$stmtEvents = $pdo->prepare($queryEvents);
$stmtEvents->execute();
$events = $stmtEvents->fetchAll(PDO::FETCH_ASSOC);

// Logika untuk memproses form pengiriman
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $eventId = $_POST["event_id"];
    $certificateText = $_POST["certificate_text"];
    
    // Query untuk membuat sertifikat baru
    $queryInsertCertificate = "INSERT INTO certificates (participant_name, event_name, event_date, certificate_text) VALUES (:participant_name, :event_name, :event_date, :certificate_text)";
    $stmtInsertCertificate = $pdo->prepare($queryInsertCertificate);
    
    // Ambil detail acara
    $queryEventDetails = "SELECT event_name, event_date FROM events WHERE event_id = :event_id";
    $stmtEventDetails = $pdo->prepare($queryEventDetails);
    $stmtEventDetails->bindParam(":event_id", $eventId);
    $stmtEventDetails->execute();
    $eventDetails = $stmtEventDetails->fetch(PDO::FETCH_ASSOC);
    
    // Ambil data pengguna yang dipilih
    if ($username === "all_users") {
        $selectedUsers = $users;
    } else {
        $queryUserDetails = "SELECT full_name FROM users WHERE username = :username";
        $stmtUserDetails = $pdo->prepare($queryUserDetails);
        $stmtUserDetails->bindParam(":username", $username);
        $stmtUserDetails->execute();
        $userDetails = $stmtUserDetails->fetch(PDO::FETCH_ASSOC);
        
        $selectedUsers = array($userDetails);
    }
    
    // Loop untuk menghasilkan sertifikat untuk setiap pengguna yang dipilih
    foreach ($selectedUsers as $user) {
        // Masukkan data sertifikat ke dalam database
        $stmtInsertCertificate->bindValue(':participant_name', $user['full_name']);
        $stmtInsertCertificate->bindValue(':event_name', $eventDetails['event_name']);
        $stmtInsertCertificate->bindValue(':event_date', $eventDetails['event_date']);
        $stmtInsertCertificate->bindValue(':certificate_text', $certificateText); // Tambahkan certificate_text
        $stmtInsertCertificate->execute();
    }
    
    // Redirect ke halaman sukses
    header("Location: generate_certificates.php?success=true");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Certificates</title>
    <!-- Sesuaikan dengan path CSS Anda -->
    <link rel="stylesheet" href="../assets/css/generate_certificates.css">
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
        <h2>Generate Certificates</h2>
        <!-- Form untuk memilih pengguna, acara, dan certificate_text -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Select User:</label>
                <select id="username" name="username" required>
                    <option value="all_users">Select All Users</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['username']; ?>"><?php echo $user['username']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="event_id">Select Event:</label>
                <select id="event_id" name="event_id" required>
                    <?php foreach ($events as $event): ?>
                        <option value="<?php echo $event['event_id']; ?>"><?php echo $event['event_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="certificate_text">Certificate Text:</label>
                <textarea id="certificate_text" name="certificate_text" rows="4" cols="50" required></textarea>
            </div>
            <button type="submit">Generate Certificates</button>
        </form>
        <?php 
        // Tampilkan pesan sukses jika ada
        if (isset($_GET["success"])) {
            echo "<p class='success'>Certificates successfully generated!</p>";
        }
        ?>
    </div>
</body>
</html>
