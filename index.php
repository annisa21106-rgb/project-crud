<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: student_view.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
