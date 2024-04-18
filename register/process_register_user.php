<?php
include_once '../includes/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];

    // Hash password sebelum disimpan
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menyimpan data pengguna
    $query = "INSERT INTO users (username, password, full_name, email) VALUES (:username, :password, :fullname, :email)";

    // Siapkan statement SQL
    $stmt = $pdo->prepare($query);

    // Bind parameter
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    // Eksekusi statement
    if ($stmt->execute()) {
        // Redirect ke halaman login setelah registrasi berhasil
        header("Location: ../admin/login.php");
        exit();
    } else {
        // Tampilkan pesan kesalahan jika gagal menyimpan data
        echo "Registrasi gagal. Silakan coba lagi.";
    }
}
?>
