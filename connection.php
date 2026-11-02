<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "kampus_db";

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$connection) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>