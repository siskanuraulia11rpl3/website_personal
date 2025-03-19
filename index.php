<?php
session_start();
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>11210085 - SISKA NURAULIA</title>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBH3qFUd58QR6j--Z8V1Palp80gTVWcTKI"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
        var peta;
        var koorAwal = new google.maps.LatLng(-7.329579339811421, 108.2196256616021);

        function peta_awal() {
            loadDataLokasiTersimpan();
            var settingpeta = {
                zoom: 15,
                center: koorAwal,
                mapTypeId: google.maps.MapTypeId.HYBRID
            };
            peta = new google.maps.Map(document.getElementById("kanvaspeta"), settingpeta);
            google.maps.event.addListener(peta, 'click', function(event) {
                tandai(event.latLng);
            });
        }

        function tandai(lokasi) {
            $("#koorX").val(lokasi.lat());
            $("#koorY").val(lokasi.lng());
            tanda = new google.maps.Marker({
                position: lokasi,
                map: peta
            });
        }

        $(document).ready(function() {
            $("#simpanpeta").click(function() {
                var koordinat_x = $("#koorX").val();
                var koordinat_y = $("#koorY").val();
                var nama_tempat = $("#namaTempat").val();
                var status = $("#status").val();
                $.ajax({
                    url: "simpan_lokasi_baru.php",
                    data: "koordinat_x=" + koordinat_x + "&koordinat_y=" + koordinat_y + "&nama_tempat=" + nama_tempat + "&status=" + status,
                    success: function(msg) {
                        $("#namaTempat").val(null);
                    }
                });
            });
        });



        function loadDataLokasiTersimpan() {
            $('#kordinattersimpan').load('tampilkan_lokasi_tersimpan.php');
        }
        setInterval(loadDataLokasiTersimpan, 3000);

        function carikordinat(lokasi) {
            var settingpeta = {
                zoom: 15,
                center: lokasi,
                mapTypeId: google.maps.MapTypeId.HYBRID
            };
            peta = new google.maps.Map(document.getElementById("kanvaspeta"), settingpeta);
            tanda = new google.maps.Marker({
                position: lokasi,
                map: peta
            });
            google.maps.event.addListener(tanda, 'click', function() {
                infowindow.open(peta, tanda);
            });
            google.maps.event.addListener(peta, 'click', function(event) {
                tandai(event.latLng);
            });
        }


        function gantipeta() {
            loadDataLokasiTersimpan();
            var isi = document.getElementById('cmb').value;
            if (isi == '1') {
                var settingpeta = {
                    zoom: 15,
                    center: koorAwal,
                    mapTypeId: google.maps.MapTypeId.HYBRID
                };
            } else if (isi == '2') {
                var settingpeta = {
                    zoom: 15,
                    center: koorAwal,
                    mapTypeId: google.maps.MapTypeId.TERRAIN
                };
            } else if (isi == '3') {
                var settingpeta = {
                    zoom: 15,
                    center: koorAwal,
                    mapTypeId: google.maps.MapTypeId.SATELLITE
                };
            } else if (isi == '4') {
                var settingpeta = {
                    zoom: 15,
                    center: koorAwal,
                    mapTypeId: google.maps.MapTypeId.HYBRID
                };
            }
            peta = new google.maps.Map(document.getElementById("kanvaspeta"), settingpeta);
            google.maps.event.addListener(peta, 'click', function(event) {
                tandai(event.latLng);
            });
        }

        function suggest(inputString) {
            if (inputString.length == 0) {
                $('#suggestions').fadeOut();
            } else {
                $('#country').addClass('load');
                $.post("autosuggest.php", {
                    queryString: "" + inputString + ""
                }, function(data) {
                    if (data.length > 0) {
                        $('#suggestions').fadeIn();
                        $('#suggestionsList').html(data);
                        $('#country').removeClass('load');
                    }
                });
            }
        }

        function fill(thisValue) {
            $('#country').val(thisValue);
            setTimeout("$('#suggestions').fadeOut();", 600);
        }
    </script>

</head>
<style>
    body {
        font-size: 12px;
        font-family: sans-serif;
        margin: 0px auto;
        padding: 0px;
        color: black;
        background-color: rgb(255, 255, 255);
        font-weight: bold;

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
        background-color: rgb(109, 177, 255);
    }

    input,
    button {
        border-radius: 7px;
        padding: 5px;
        border: 1px solid #FFFFFF;
        background-color: rgb(109, 177, 255);
    }

    button:hover {
        padding: 5px;
        border: 1px solid #FFFFFF;
        background-color: rgb(255, 0, 0);
        cursor: pointer;
    }
</style>

<body onLoad="peta_awal()">
    <div id="kanvaspeta" style=" margin:0px auto; width:65%; height:630px; float:right; padding:10px;"></div>
    <div id="form_lokasi" style="background-color:#fffff ; width:23%; height:600px; text-align:left; padding:10px; float:left;">
        <form id="form" action="#">
            <div id="suggest">Masukkan nama tempat: <br />
                <input type="text" size="25" value="" id="country" onkeyup="suggest(this.value);" onblur="fill();" class="" />

                <div class="suggestionsBox" id="suggestions" style="display: none;"> <img src="arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                    <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
                </div>
            </div>
        </form>
        <table>
            <tr>
                <td>Ganti Jenis Peta</td>
                <td>:
                    <select id="cmb" onchange="gantipeta()">
                        <option value="1">Peta Roadmap</option>
                        <option value="2">Peta Terrain</option>
                        <option value="3">Peta Satelite</option>
                        <option value="4">Peta Hybrid</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Koordinat X</td>
                <td>: <input type="text" name="koordinatx" id="koorX" readonly="readonly"></td>
            </tr>
            <tr>
                <td>Koordinat Y</td>
                <td>: <input type="text" name="koordinaty" id="koorY" readonly="readonly"></td>
            </tr>
            <tr>
                <td>Nama Lokasi</td>
                <td>: <input type="text" name="namatempat" id="namaTempat"></td>
            </tr>
            <!--<tr><td>Status</td><td>: <select name="status" id="status" style="width: 181px;">-->
            <!--            <option value="0">Inactive (default)</option>-->
            <!--            <option value="1">Active</option>-->
            <!--        </select>-->
            <tr>
                <td></td>
                <td><button id="simpanpeta">Simpan</button> <button onclick="javascript:carikordinat(koorAwal);">Koordinat Awal</button></td>
            </tr>
        </table>
        <div id=kordinattersimpan></div>
        <div class="container">
            <?php if ($is_logged_in) : ?>
                <br>
                <form align="center" method="POST" action="logout.php">
                    <input style="cursor: pointer; font-weight: bold" type="submit" name="logout" value="LOGOUT">
                </form>
            <?php else : ?>
                <table width='80%' border='0'>
                    <form method='POST' action='login.php'>
                        <tr>
                            <th colspan='2' align='center'>Login</th>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td><input type='text' name='user' size='10'></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input type='password' name='pass' size='10'></td>
                        </tr>
                        <tr>
                            <th colspan='2' align='center'>
                                <input style="cursor: pointer;font-weight: bold " type='submit' name='tombol' value='OK'>
                            </th>
                        </tr>
                        <?php if (isset($_SESSION['error_message'])) : ?>
                            <tr>
                                <td colspan='2' align='center' style='color:blue'><?php echo $_SESSION['error_message'];
                                                                                    unset($_SESSION['error_message']); ?></td>
                            </tr>
                        <?php endif; ?>
                    </form>
                </table>
            <?php endif; ?>
        </div>
    </div>
    </div>

</body>

</html>