<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

require_once 'connection.php';

if (isset($_GET['nim'])) {
    $nim = mysqli_real_escape_string($connection, $_GET['nim']);
    $query = "DELETE FROM student WHERE nim = '$nim'";

    if (mysqli_query($connection, $query)) {
        header("Location: student_view.php?pesan=Data berhasil dihapus!");
        exit();
    } else {
        header("Location: student_view.php?pesan=Gagal menghapus data!");
        exit();
    }
} else {
    header("Location: student_view.php");
    exit();
}
?>