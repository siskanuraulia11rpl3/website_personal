<?php
session_start();
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];

include('koneksi.php');
$id = $_GET['nomor'];

if ($is_logged_in) {
    $lokasi = mysqli_query($conn, "SELECT * FROM kordinat_gis WHERE nomor=$id");
} else {
    // Handle jika user tidak logged in
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <form method="POST" action="">
        <table width="80%" border="1" align="center">
            <tbody>
                <tr>
                    <th colspan="2">UBAH DATA</th>
                </tr>
                <?php while ($koor = mysqli_fetch_array($lokasi)) { ?>
                    <tr>
                        <td>Nama Tempat</td>
                        <td>: <input type="text" name="nama_tempat" size="20" value="<?php echo $koor['nama_tempat']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>: <input type="radio" name="status" value="1" <?php if ($koor['status'] == 1) echo 'checked'; ?>> Tampil
                            <input type="radio" name="status" value="0" <?php if ($koor['status'] == 0) echo 'checked'; ?>> Tidak Tampil </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th colspan="2"><input type="submit" value="OK" name="ubah"></th>
                </tr>
            </tbody>
        </table>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ubah'])) {
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $nama_tempat = mysqli_real_escape_string($conn, $_POST['nama_tempat']);

        // Eksekusi query update
        $ubah = mysqli_query($conn, "UPDATE kordinat_gis SET status='$status', nama_tempat='$nama_tempat' WHERE nomor='$id'");

        if ($ubah) {
            echo "<script>alert('Data berhasil diubah.'); window.close();</script>";
        } else {
            echo "<p>Gagal mengubah data: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>

</body>

</html>
