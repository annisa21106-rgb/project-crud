<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: student_view.php");
    exit();
}

require_once 'connection.php';
$pesan_error = "";

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password']) || $password === $row['password']) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;
            header("Location: student_view.php");
            exit();
        } else {
            $pesan_error = "Password yang Anda masukkan salah!";
        }
    } else {
        $pesan_error = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login-body">
    <div class="login-card">
        <h2>Sistem Informasi Akademik</h2>
        <p class="subtitle">Silakan login untuk mengelola data mahasiswa</p>
        <?php if ($pesan_error != ""): ?>
            <div class="alert danger"><?= $pesan_error; ?></div>
        <?php endif; ?>
        <form method="post" action="login.php">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autocomplete="off" placeholder="Masukkan username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Masukkan password">
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block">Masuk</button>
        </form>
    </div>
</body>
</html>