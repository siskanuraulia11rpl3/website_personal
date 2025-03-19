<?php
session_start(); // Memulai sesi

include 'koneksi.php'; // Menghubungkan ke file config.php yang berisi koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
?>
