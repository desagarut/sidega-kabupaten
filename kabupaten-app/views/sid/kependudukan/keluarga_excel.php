<?php
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=keluarga_".date('Y-m-d').".xls");
  header("Pragma: no-cache");
  header("Expires: 0");

  include("kabupaten-app/views/sid/kependudukan/keluarga_print.php");

?>
