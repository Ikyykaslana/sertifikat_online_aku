<?php
include_once '../includes/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $organizer = $_POST['organizer'];

    // Query untuk menyimpan data event
    $query = "INSERT INTO events (event_name, event_date, location, organizer) VALUES (:event_name, :event_date, :location, :organizer)";

    // Siapkan statement SQL
    $stmt = $pdo->prepare($query);

    // Bind parameter
    $stmt->bindParam(':event_name', $event_name, PDO::PARAM_STR);
    $stmt->bindParam(':event_date', $event_date, PDO::PARAM_STR);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->bindParam(':organizer', $organizer, PDO::PARAM_STR);

    // Eksekusi statement
    if ($stmt->execute()) {
        // Redirect ke halaman dashboard setelah event berhasil dibuat
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Tampilkan pesan kesalahan jika gagal menyimpan data
        echo "Failed to create event. Please try again.";
    }
}
?>
