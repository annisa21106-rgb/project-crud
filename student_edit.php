<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

require_once 'connection.php';
$pesan_error = "";

if (!isset($_GET['nim'])) {
    header("Location: student_view.php");
    exit();
}

$nim = mysqli_real_escape_string($connection, $_GET['nim']);
$query = "SELECT * FROM student WHERE nim = '$nim'";
$result = mysqli_query($connection, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: student_view.php");
    exit();
}

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($connection, $_POST['nama']);
    $tempat_lahir = mysqli_real_escape_string($connection, $_POST['tempat_lahir']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $fakultas = mysqli_real_escape_string($connection, $_POST['fakultas']);
    $jurusan = mysqli_real_escape_string($connection, $_POST['jurusan']);
    $ipk = $_POST['ipk'];

    $update_query = "UPDATE student SET 
        nama = '$nama', 
        tempat_lahir = '$tempat_lahir', 
        tanggal_lahir = '$tanggal_lahir', 
        fakultas = '$fakultas', 
        jurusan = '$jurusan', 
        ipk = '$ipk' 
        WHERE nim = '$nim'";

    if (mysqli_query($connection, $update_query)) {
        header("Location: student_view.php?pesan=Data berhasil diperbarui!");
        exit();
    } else {
        $pesan_error = "Gagal memperbarui data: " . mysqli_error($connection);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Sistem Informasi Akademik</h2>
        <a href="student_view.php">Kembali ke Daftar</a>
    </div>

    <div class="container" style="max-width: 650px;">
        <h3>Edit Data Mahasiswa</h3>
        <?php if ($pesan_error != ""): ?>
            <div class="alert danger"><?= $pesan_error; ?></div>
        <?php endif; ?>
        <form method="post" action="student_edit.php?nim=<?= $nim; ?>">
            <div class="form-group">
                <label>NIM (Tidak dapat diubah)</label>
                <input type="text" name="nim" value="<?= $data['nim']; ?>" readonly style="background: #e9ecef;">
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($data['tempat_lahir']); ?>" required>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir']; ?>" required>
            </div>
            <div class="form-group">
                <label>Fakultas</label>
                <input type="text" name="fakultas" value="<?= htmlspecialchars($data['fakultas']); ?>" required>
            </div>
            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" value="<?= htmlspecialchars($data['jurusan']); ?>" required>
            </div>
            <div class="form-group">
                <label>IPK</label>
                <input type="number" step="0.01" min="0" max="4.00" name="ipk" value="<?= $data['ipk']; ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="student_view.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
