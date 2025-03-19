<?php
include('koneksi.php');
$koordinat_x = $_GET['koordinat_x'];
$koordinat_y = $_GET['koordinat_y'];
$nama_tempat = $_GET['nama_tempat'];
$status = $_GET['status'];
mysqli_query($conn, "insert into kordinat_gis (x,y,nama_tempat) values($koordinat_x,$koordinat_y,'$nama_tempat')");
