<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";

// Koneksi ke MySQL tanpa memilih database terlebih dahulu
$conn = mysqli_connect($db_host, $db_user, $db_pass);
if (!$conn) {
    die("Koneksi MySQL gagal: " . mysqli_connect_error());
}

// 1. Buat Database kampus_db
$sql_db = "CREATE DATABASE IF NOT EXISTS kampus_db";
if (!mysqli_query($conn, $sql_db)) {
    die("Gagal membuat database: " . mysqli_error($conn));
}
mysqli_select_db($conn, "kampus_db");

// 2. Buat Tabel admin
$sql_admin = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
mysqli_query($conn, $sql_admin);

// Isi data admin default (username: admin, password: password123)
$hashed_password = password_hash("password123", PASSWORD_DEFAULT);
$sql_insert_admin = "INSERT IGNORE INTO admin (username, password) VALUES ('admin', '$hashed_password')";
mysqli_query($conn, $sql_insert_admin);

// 3. Buat Tabel student
$sql_student = "CREATE TABLE IF NOT EXISTS student (
    nim VARCHAR(15) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    tempat_lahir VARCHAR(50) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    fakultas VARCHAR(50) NOT NULL,
    jurusan VARCHAR(50) NOT NULL,
    ipk DECIMAL(3, 2) NOT NULL
)";
mysqli_query($conn, $sql_student);

// Tambah data mahasiswa dummy awal
$sql_dummy = "INSERT IGNORE INTO student (nim, nama, tempat_lahir, tanggal_lahir, fakultas, jurusan, ipk) VALUES 
('1201220001', 'Ahmad Farhan', 'Surabaya', '2003-05-14', 'Rekayasa Industri', 'Sistem Informasi', 3.85),
('1201220002', 'Budi Santoso', 'Malang', '2003-08-20', 'Informatika', 'Informatika', 3.70)";
mysqli_query($conn, $sql_dummy);

echo "<h3 style='color: green;'>Database, Tabel, dan Data Awal Berhasil Digenerate!</h3>";
echo "<p><a href='login.php'>Menuju Halaman Login</a></p>";
mysqli_close($conn);
?>