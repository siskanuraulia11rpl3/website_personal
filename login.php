<?php
session_start(); // Memulai sesi

include 'koneksi.php'; // Menghubungkan ke file config.php yang berisi koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    } else {
        $username = $_POST['user'];
        $password = $_POST['pass'];

        $hashed_password = sha1($password);

        // Melakukan escape pada input pengguna untuk mencegah SQL Injection
        // $username = $mysqli->real_escape_string($username);

        // Melakukan query langsung ke database
        $query = "SELECT * FROM operator WHERE username = '$username' AND password = '$hashed_password'";
        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Memeriksa apakah password cocok
            if ($hashed_password === $user['password']) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $user['username'];
                // echo "Masuk"; // Menghasilkan output yang menyebabkan pesan error
            } else {
                $_SESSION['error_message'] = "Username atau password salah";
                header('Location: index.php');
                exit; // Perlu ada exit setelah mengirim header
            }
        } else {
            $_SESSION['error_message'] = "Username atau password salah";
            header('Location: index.php');
            exit; // Perlu ada exit setelah mengirim header
        }


        // $result->free();

        // Memindahkan header() ke akhir
        header('Location: index.php');
        exit;
    }
}
