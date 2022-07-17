<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-07-12 14:35:32 --> Severity: error --> Exception: Call to undefined method Track_model::track_kabupaten() D:\laragon\www\kecamatan-master\kabupaten-app\controllers\First.php 129
ERROR - 2022-07-12 07:43:34 --> Unable to connect to the database
ERROR - 2022-07-12 07:50:52 --> Unable to connect to the database
ERROR - 2022-07-12 07:51:55 --> Unable to connect to the database
ERROR - 2022-07-12 07:52:05 --> Unable to connect to the database
ERROR - 2022-07-12 07:52:08 --> Unable to connect to the database
ERROR - 2022-07-12 07:52:53 --> Unable to connect to the database
ERROR - 2022-07-12 07:52:59 --> Unable to connect to the database
ERROR - 2022-07-12 07:58:28 --> Unable to connect to the database
ERROR - 2022-07-12 08:06:20 --> Unable to connect to the database
ERROR - 2022-07-12 15:14:03 --> Severity: error --> Exception: Call to undefined function gambar_kabupaten() D:\laragon\www\kabupaten-master\themes\umkm\commons\header.php 11
ERROR - 2022-07-12 15:14:23 --> Severity: error --> Exception: Call to undefined function gambar_kabupaten() D:\laragon\www\kabupaten-master\themes\umkm\commons\header.php 11
ERROR - 2022-07-12 15:14:39 --> Severity: error --> Exception: Call to undefined function gambar_kabupaten() D:\laragon\www\kabupaten-master\kabupaten-app\views\nav.php 7
ERROR - 2022-07-12 15:41:57 --> Query error: Expression #3 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'kecamatan-master.p.bulan_laporan' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT COUNT(*) AS `numrows`
FROM (
SELECT `p`.*, (CASE WHEN p.id_lokasi IS NOT NULL THEN CONCAT(
				(CASE WHEN w.rt != '0' THEN CONCAT('RT ', w.rt, ' / ') ELSE '' END),
				(CASE WHEN w.rw != '0' THEN CONCAT('RW ', w.rw, ' - ') ELSE '' END),
				w.dusun
			) ELSE p.lokasi END) AS alamat, (CASE WHEN MAX(CAST(d.judul as UNSIGNED INTEGER)) IS NOT NULL THEN CONCAT(MAX(CAST(d.judul as UNSIGNED INTEGER)), "%") ELSE CONCAT("belum ada progres") END) AS max_persentase
FROM `potensi_umum` `p`
LEFT JOIN `potensi_umum_dokumentasi` `d` ON `d`.`id_potensi` = `p`.`id`
LEFT JOIN `tweb_wil_cluster` `w` ON `p`.`id_lokasi` = `w`.`id`
WHERE `p`.`tahun_laporan` = ''
GROUP BY `p`.`id`
) CI_count_all_results
ERROR - 2022-07-12 15:41:57 --> Severity: error --> Exception: Call to a member function num_rows() on bool D:\laragon\www\kabupaten-master\system\database\DB_query_builder.php 1429
ERROR - 2022-07-12 15:42:11 --> Query error: Expression #3 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'kecamatan-master.p.bulan_laporan' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT COUNT(*) AS `numrows`
FROM (
SELECT `p`.*, (CASE WHEN p.id_lokasi IS NOT NULL THEN CONCAT(
				(CASE WHEN w.rt != '0' THEN CONCAT('RT ', w.rt, ' / ') ELSE '' END),
				(CASE WHEN w.rw != '0' THEN CONCAT('RW ', w.rw, ' - ') ELSE '' END),
				w.dusun
			) ELSE p.lokasi END) AS alamat, (CASE WHEN MAX(CAST(d.judul as UNSIGNED INTEGER)) IS NOT NULL THEN CONCAT(MAX(CAST(d.judul as UNSIGNED INTEGER)), "%") ELSE CONCAT("belum ada progres") END) AS max_persentase
FROM `potensi_umum` `p`
LEFT JOIN `potensi_umum_dokumentasi` `d` ON `d`.`id_potensi` = `p`.`id`
LEFT JOIN `tweb_wil_cluster` `w` ON `p`.`id_lokasi` = `w`.`id`
WHERE `p`.`tahun_laporan` = ''
GROUP BY `p`.`id`
) CI_count_all_results
ERROR - 2022-07-12 15:42:11 --> Severity: error --> Exception: Call to a member function num_rows() on bool D:\laragon\www\kabupaten-master\system\database\DB_query_builder.php 1429
ERROR - 2022-07-12 13:34:27 --> Unable to connect to the database
