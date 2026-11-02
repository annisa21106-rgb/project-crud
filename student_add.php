<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

require_once 'connection.php';
$pesan_error = "";

if (isset($_POST['submit'])) {
    $nim = mysqli_real_escape_string($connection, $_POST['nim']);
    $nama = mysqli_real_escape_string($connection, $_POST['nama']);
    $tempat_lahir = mysqli_real_escape_string($connection, $_POST['tempat_lahir']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $fakultas = mysqli_real_escape_string($connection, $_POST['fakultas']);
    $jurusan = mysqli_real_escape_string($connection, $_POST['jurusan']);
    $ipk = $_POST['ipk'];

    $query = "INSERT INTO student VALUES ('$nim', '$nama', '$tempat_lahir', '$tanggal_lahir', '$fakultas', '$jurusan', '$ipk')";
    if (mysqli_query($connection, $query)) {
        header("Location: student_view.php?pesan=Data berhasil ditambahkan!");
        exit();
    } else {
        $pesan_error = "Gagal menambah data: " . mysqli_error($connection);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Sistem Informasi Akademik</h2>
        <a href="student_view.php">Kembali ke Daftar</a>
    </div>

    <div class="container" style="max-width: 650px;">
        <h3>Tambah Data Mahasiswa</h3>
        <?php if ($pesan_error != ""): ?>
            <div class="alert danger"><?= $pesan_error; ?></div>
        <?php endif; ?>
        <form method="post" action="student_add.php">
            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" required placeholder="Contoh: 1201220003">
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" required>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" required>
            </div>
            <div class="form-group">
                <label>Fakultas</label>
                <input type="text" name="fakultas" required placeholder="Contoh: Rekayasa Industri">
            </div>
            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" required placeholder="Contoh: Sistem Informasi">
            </div>
            <div class="form-group">
                <label>IPK</label>
                <input type="number" step="0.01" min="0" max="4.00" name="ipk" required placeholder="Contoh: 3.75">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Simpan Data</button>
            <a href="student_view.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>