<?php

session_start();
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script type="text/javascript">
	$(document).ready(function() {
		$(".delbutton").click(function() {
			var element = $(this);
			var del_id = element.attr("id");
			var info = 'nomor=' + del_id;
			if (confirm("Anda yakin akan menghapus?")) {
				$.ajax({
					type: "POST",
					url: "hapus_lokasi.php",
					data: info,
					success: function() {}
				});
				$(this).parents(".content").animate({
					opacity: "hide"
				}, "slow");
			}
			return false;
		});
	})
</script>

<?php
include('koneksi.php');
if ($is_logged_in) { ?>
	<script>
		function openPopup(nomor) {
			var popupWidth = 500;
			var popupHeight = 300;
			var left = (screen.width - popupWidth) / 2;
			var top = (screen.height - popupHeight) / 2;
			var url = "ubah.php?nomor=" + nomor
			window.open(url, 'popupWindow', 'width=' + popupWidth + ', height=' + popupHeight + ', top=' + top + ', left=' + left);
		}
	</script>
<?php
	$lokasi = mysqli_query($conn, "select * from kordinat_gis order by nomor desc limit 0,10");
} else {
	$lokasi = mysqli_query($conn, "select * from kordinat_gis where status = 1 order by nomor desc limit 0,10");
}
while ($koor = mysqli_fetch_array($lokasi)) {
?>
	<ul>
		<li class="content">
			<?php
			if ($koor['status'] == 1) {
				$warna = '#0000CD';
			} elseif ($koor['status'] == 0) {
				$warna = 'red';
			}

			?>
			<a style="color: <?php echo $warna ?>" href="javascript:carikordinat(new google.maps.LatLng(<?php echo $koor['x']; ?>,<?php echo $koor['y']; ?>))">
				<?php echo $koor['nama_tempat']; ?>
			</a>
			<?php if ($is_logged_in) : ?>
				</button></a> <a href="hapus.php?nomor=<?php echo $koor['nomor']; ?>"><button>
						<i class="fas fa-trash"></i>
					</button></a> <a href="javascript:openPopup(<?php echo $koor['nomor']; ?>)"><button>
						<i class="fas fa-edit"></i>
					<?php else : ?>

					<?php endif; ?>


		</li>
	</ul>

<?php
}
?>
<br>
<hr>


