<?php
include_once '../includes/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa apakah pengguna ada di database
    $query = "SELECT * FROM users WHERE username = :username";

    // Siapkan statement SQL
    $stmt = $pdo->prepare($query);

    // Bind parameter
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasil query
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika pengguna ditemukan, verifikasi password
    if ($user && password_verify($password, $user['password'])) {
        // Set session untuk pengguna
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['user_role']; // Tambahan: simpan peran pengguna di session

        // Redirect ke halaman dashboard sesuai peran
        if ($user['user_role'] === 'admin') {
            header("Location: admin_dashboard.php");
            exit();
        } elseif ($user['user_role'] === 'user') {
            header("Location: ../user/user_dashboard.php");
            exit();
        }
    } else {
        // Tampilkan pesan error jika kredensial tidak cocok
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
}
?>
