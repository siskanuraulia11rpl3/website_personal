<?php
session_start();
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIG Database</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-size: 12px;
            font-family: sans-serif;
            margin: 0px auto;
            padding: 0px;
            color: #FFFFFF;
            background-color: #333333;
        }

        a {
            text-decoration: none;
            color: #FF0000;
            font-weight: bold;
        }

        a:hover {
            color: #FF9900;
        }

        ul {
            margin: 0px auto;
            padding: 0px 15px 0px 15px;
            list-style: square;
        }

        li {
            padding-left: 15px;
            padding: 0px 15px 0px 5px;
        }

        input,
        select {
            padding: 5px;
            border: 1px solid #FFFFFF;
            background-color: #FF9900;
        }

        input,
        button {
            padding: 5px;
            border: 1px solid #FFFFFF;
            background-color: #FF9900;
        }

        button:hover {
            padding: 5px;
            border: 1px solid #FFFFFF;
            background-color: #FF3300;
            cursor: pointer;
        }
    </style>
</head>
<a href="index.php">
    <h1>Sistem Informasi Geografik</h1>
</a>

<body>

    <?php if ($is_logged_in) : ?>
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th align="center">No</th>
                        <!-- <th>X</th>
                        <th>Y</th> -->
                        <th>Nama Tempat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>


                    <?php
                    include('koneksi.php');

                    $lokasi  = mysqli_query($conn, "select * from kordinat_gis order by nomor desc");
                    $no = 1;
                    while ($koor = mysqli_fetch_array($lokasi)) {
                    ?>
                        <tr>
                            <td align="center"><?php echo $no++; ?></td>
                            <!-- <td><?php echo $koor['x']; ?></td> -->
                            <!-- <td><?php echo $koor['y']; ?></td> -->
                            <?php
                            if ($koor['status'] == 1) {
                                $warna = 'red';
                            } elseif ($koor['status'] == 0) {
                                $warna = 'white';
                            }

                            ?>
                            <td style="color: <?php echo $warna ?>"><?php echo $koor['nama_tempat']; ?></td>
                            <td style="color: <?php echo $warna ?>"><?php echo $koor['status']; ?></td>

                            <td align="center"><a href="aktif.php?nomor=<?php echo $koor['nomor']; ?>"><button>
                                        <i class="fas fa-play"></i> tampilkan
                                    </button></a> <a href="nonaktif.php?nomor=<?php echo $koor['nomor']; ?>"><button>
                                        <i class="fas fa-ban"></i> jangan Tampil
                                    </button></a> <a href="hapus.php?nomor=<?php echo $koor['nomor']; ?>"><button>
                                        <i class="fas fa-trash"></i> Hapus
                                    </button></a></td>
                        </tr>
                    <?php
                    }
                    ?>



                    <!-- Tambahkan baris lainnya sesuai kebutuhan -->
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <h1 align="center"> Anda bukan admin</h1>
    <?php endif; ?>
</body>

</html>