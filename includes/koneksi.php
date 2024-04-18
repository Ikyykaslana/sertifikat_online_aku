<?php
// Konfigurasi database
$host = "localhost"; // Sesuaikan dengan host Anda
$dbname = "serline"; // Sesuaikan dengan nama database Anda
$username = "root"; // Sesuaikan dengan username database Anda
$password = ""; // Sesuaikan dengan password database Anda (kosongkan jika tidak ada)

// Buat koneksi ke database menggunakan PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set mode error PDO ke exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Tangani kesalahan jika koneksi gagal
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
