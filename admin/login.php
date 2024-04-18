<?php
// Periksa apakah terdapat pesan error dari proses login sebelumnya
$error_message = "";
if (isset($_GET['error']) && $_GET['error'] === "invalid_credentials") {
    $error_message = "Invalid username or password. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login.css"> <!-- Sesuaikan dengan path CSS Anda -->
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <!-- Tampilkan pesan error jika ada -->
        <?php if (!empty($error_message)) : ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="process_login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <!-- Tambahkan tautan ke halaman registrasi -->
        <p>Don't have an account? <a href="../register/register_user.php">Register here</a></p>
    </div>
</body>
</html>
