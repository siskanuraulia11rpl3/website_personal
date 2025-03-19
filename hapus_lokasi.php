<?php
include('koneksi.php');
$id = $_POST['nomor'];
$hapus = mysqli_query($conn, "delete from kordinat_gis where nomor='$id'");
?>
