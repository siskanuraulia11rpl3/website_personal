<?php
include('koneksi.php');
$id = $_GET['nomor'];
$aktif = mysqli_query($conn, "UPDATE kordinat_gis SET status='1' WHERE nomor=$id");
header("Location: index.php");
