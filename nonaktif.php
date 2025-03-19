<?php
include('koneksi.php');
$id = $_GET['nomor'];
$nonaktif = mysqli_query($conn, "UPDATE kordinat_gis SET status='0' WHERE nomor=$id");
header("Location: index.php");
