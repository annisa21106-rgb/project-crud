<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

require_once 'connection.php';
$query = "SELECT * FROM student ORDER BY nim ASC";
$result = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Mahasiswa</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="navbar">
        <h2>Sistem Informasi Akademik</h2>
        <div>
            <span>Halo, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong> | </span>
            <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
        </div>
    </div>

    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3>Data Mahasiswa</h3>
            <a href="student_add.php" class="btn btn-primary">+ Tambah Mahasiswa</a>
        </div>

        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert success"><?= htmlspecialchars($_GET['pesan']); ?></div>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Fakultas</th>
                    <th>Jurusan</th>
                    <th>IPK</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['nim']; ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['tempat_lahir']); ?></td>
                            <td><?= $row['tanggal_lahir']; ?></td>
                            <td><?= htmlspecialchars($row['fakultas']); ?></td>
                            <td><?= htmlspecialchars($row['jurusan']); ?></td>
                            <td><?= $row['ipk']; ?></td>
                            <td>
                                <a href="student_edit.php?nim=<?= $row['nim']; ?>" class="btn btn-warning">Edit</a>
                                <a href="student_delete.php?nim=<?= $row['nim']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Belum ada data mahasiswa.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
