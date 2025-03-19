<?php


session_start();
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
?>

<?php
$db = new mysqli('localhost', 'root' ,'', 'sig');


if (!$db) {

	echo 'Could not connect to the database.';
} else {

	if (isset($_POST['queryString'])) {
		$queryString = $db->real_escape_string($_POST['queryString']);

		if (strlen($queryString) > 0) {
			if ($is_logged_in) {
				$query = $db->query("SELECT * FROM kordinat_gis WHERE nama_tempat LIKE '$queryString%'AND status IN (0, 1)  LIMIT 10");
			} else {
				$query = $db->query("SELECT * FROM kordinat_gis WHERE nama_tempat LIKE '$queryString%'AND status = 1  LIMIT 10");
			}
			if ($query) {
				echo '<ul>';
				while ($result = $query->fetch_object()) {
					echo '<a href="javascript:carikordinat(new google.maps.LatLng(' . $result->x . ',' . $result->y . '))">
						<li onClick="fill(\'' . addslashes($result->nama_tempat) . '\');">' . $result->nama_tempat . '</li></a>';
				}
				echo '</ul>';
			} else {
				echo 'OOPS we had a problem :(';
			}
		} else {
			// do nothing
		}
	} else {
		echo 'There should be no direct access to this script!';
	}
}
