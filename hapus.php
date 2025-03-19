<?php
include('koneksi.php');
$id = $_GET['nomor'];
$hapus = mysqli_query($conn, "delete from kordinat_gis where nomor='$id'");
header("Location: index.php");
