<?php
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=wilayah_rt_".date('Y-m-d').".xls");
  header("Pragma: no-cache");
  header("Expires: 0");

  include("kabupaten-app/views/sid/wilayah/wilayah_rt_print.php");

?>