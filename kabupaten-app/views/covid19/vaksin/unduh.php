<?php
	header("Content-type: application/xls");
	header("Content-Disposition: attachment; filename="."laporan_".urlencode($judul)."_covid19_".date("Y-m-d").".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	include("kabupaten-app/views/covid19/vaksin/cetak_$judul.php");
?>
