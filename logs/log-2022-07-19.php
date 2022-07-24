<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-07-19 01:31:08 --> 404 Page Not Found: /index
ERROR - 2022-07-19 01:31:12 --> 404 Page Not Found: /index
ERROR - 2022-07-19 08:31:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' and w.desa '0' and `w`.`rt` = '0'
OR `w`.`rw` <> '-' and `w`.`dusun` <> '-' ' at line 27 - Invalid query: SELECT (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(id) FROM tweb_wil_cluster WHERE dusun = w.dusun AND rw <> '-' AND rt = '-')
				END) AS jumlah_rw, (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(id) FROM tweb_wil_cluster WHERE dusun = w.dusun AND rt <> '0' AND rt <> '-')
				WHEN w.rw <> '0' and w.rw <> '-' and w.rt = '0' THEN (SELECT COUNT(id) FROM tweb_wil_cluster WHERE dusun = w.dusun AND rw = w.rw AND rt <> '0' AND rt <> '-')
				END) AS jumlah_rt, (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun))
				WHEN w.rw <> '0' and w.rw <> '-' and w.rt = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun and rw = w.rw))
				WHEN w.rt <> '0' and w.rt <> '-' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster = w.id)
				END) AS jumlah_warga, (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun) AND p.sex = 1)
				WHEN w.rw <> '0' and w.rw <> '-' and w.rt = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun and rw = w.rw) AND p.sex = 1)
				WHEN w.rt <> '0' and w.rt <> '-' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster = w.id and p.sex = 1)
				END) AS jumlah_warga_l, (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun) AND p.sex = 2)
				WHEN w.rw <> '0' and w.rw <> '-' and w.rt = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun and rw = w.rw) AND p.sex = 2)
				WHEN w.rt <> '0' and w.rt <> '-' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster = w.id and p.sex = 2)
				END) AS jumlah_warga_p, (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala = p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun) AND p.kk_level = 1)
				WHEN w.rw <> '0' and w.rw <> '-' and w.rt = '0' THEN (SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala = p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun and rw = w.rw) AND p.kk_level = 1)
				WHEN w.rt <> '0' and w.rt <> '-' THEN (SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala = p.id WHERE p.id_cluster = w.id AND p.kk_level = 1)
				END) AS jumlah_kk, `w`.*, `p`.`nama` AS `nama_kepala`, `p`.`nik` AS `nik_kepala`, (CASE WHEN w.desa = '0' THEN '' ELSE w.desa END) AS desa, (CASE WHEN w.dusun = '0' THEN '' ELSE w.dusun END) AS dusun, (CASE WHEN w.rw = '0' THEN '' ELSE w.rw END) AS rw, (CASE WHEN w.rt = '0' THEN '' ELSE w.rt END) AS rt
FROM `tweb_wil_cluster` `w`
LEFT JOIN `penduduk_hidup` `p` ON `w`.`id_kepala` = `p`.`id`
WHERE   (
`w`.`rt` = '0' and `w`.`rw` = '0' and `w`.`dusun` = '0' and `w`.`desa` = '0'
OR `w`.`rw` <> '-' and w.dusun '0' and w.desa '0' and `w`.`rt` = '0'
OR `w`.`rw` <> '-' and `w`.`dusun` <> '-' and w.desa '0' and `w`.`rt` = '0'
OR `w`.`rw` <> '-' and `w`.`dusun` <> '-' and `w`.`desa` <> '-' and `w`.`rt` = '0'
 )
ORDER BY `w`.`kecamatan`, `desa`, `dusun`, `rw`, `rt`
ERROR - 2022-07-19 08:31:27 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\laragon\www\sidega-kabupaten\kabupaten-app\models\Wilayah_model.php 124
ERROR - 2022-07-19 08:31:36 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' and w.desa '0' and `w`.`rt` = '0'
OR `w`.`rw` <> '-' and `w`.`dusun` <> '-' ' at line 27 - Invalid query: SELECT (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(id) FROM tweb_wil_cluster WHERE dusun = w.dusun AND rw <> '-' AND rt = '-')
				END) AS jumlah_rw, (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(id) FROM tweb_wil_cluster WHERE dusun = w.dusun AND rt <> '0' AND rt <> '-')
				WHEN w.rw <> '0' and w.rw <> '-' and w.rt = '0' THEN (SELECT COUNT(id) FROM tweb_wil_cluster WHERE dusun = w.dusun AND rw = w.rw AND rt <> '0' AND rt <> '-')
				END) AS jumlah_rt, (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun))
				WHEN w.rw <> '0' and w.rw <> '-' and w.rt = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun and rw = w.rw))
				WHEN w.rt <> '0' and w.rt <> '-' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster = w.id)
				END) AS jumlah_warga, (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun) AND p.sex = 1)
				WHEN w.rw <> '0' and w.rw <> '-' and w.rt = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun and rw = w.rw) AND p.sex = 1)
				WHEN w.rt <> '0' and w.rt <> '-' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster = w.id and p.sex = 1)
				END) AS jumlah_warga_l, (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun) AND p.sex = 2)
				WHEN w.rw <> '0' and w.rw <> '-' and w.rt = '0' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun and rw = w.rw) AND p.sex = 2)
				WHEN w.rt <> '0' and w.rt <> '-' THEN (SELECT COUNT(p.id) FROM penduduk_hidup p WHERE p.id_cluster = w.id and p.sex = 2)
				END) AS jumlah_warga_p, (CASE
				WHEN w.dusun <> '0' and w.dusun <> '-' and w.rw = '0' THEN (SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala = p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun) AND p.kk_level = 1)
				WHEN w.rw <> '0' and w.rw <> '-' and w.rt = '0' THEN (SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala = p.id WHERE p.id_cluster IN(SELECT id FROM tweb_wil_cluster WHERE dusun = w.dusun and rw = w.rw) AND p.kk_level = 1)
				WHEN w.rt <> '0' and w.rt <> '-' THEN (SELECT COUNT(p.id) FROM keluarga_aktif k inner join penduduk_hidup p ON k.nik_kepala = p.id WHERE p.id_cluster = w.id AND p.kk_level = 1)
				END) AS jumlah_kk, `w`.*, `p`.`nama` AS `nama_kepala`, `p`.`nik` AS `nik_kepala`, (CASE WHEN w.desa = '0' THEN '' ELSE w.desa END) AS desa, (CASE WHEN w.dusun = '0' THEN '' ELSE w.dusun END) AS dusun, (CASE WHEN w.rw = '0' THEN '' ELSE w.rw END) AS rw, (CASE WHEN w.rt = '0' THEN '' ELSE w.rt END) AS rt
FROM `tweb_wil_cluster` `w`
LEFT JOIN `penduduk_hidup` `p` ON `w`.`id_kepala` = `p`.`id`
WHERE   (
`w`.`rt` = '0' and `w`.`rw` = '0' and `w`.`dusun` = '0' and `w`.`desa` = '0'
OR `w`.`rw` <> '-' and w.dusun '0' and w.desa '0' and `w`.`rt` = '0'
OR `w`.`rw` <> '-' and `w`.`dusun` <> '-' and w.desa '0' and `w`.`rt` = '0'
OR `w`.`rw` <> '-' and `w`.`dusun` <> '-' and `w`.`desa` <> '-' and `w`.`rt` = '0'
 )
ORDER BY `w`.`kecamatan`, `desa`, `dusun`, `rw`, `rt`
ERROR - 2022-07-19 08:31:36 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\laragon\www\sidega-kabupaten\kabupaten-app\models\Wilayah_model.php 124
ERROR - 2022-07-19 08:31:59 --> 404 Page Not Found: 
ERROR - 2022-07-19 08:41:31 --> Severity: error --> Exception: Call to undefined method Wilayah_model::get_kecamatan() D:\laragon\www\sidega-kabupaten\kabupaten-app\controllers\Sid_core.php 153
ERROR - 2022-07-19 10:51:12 --> Query error: Column 'kecamatan' cannot be null - Invalid query: INSERT INTO `tweb_wil_cluster` (`kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES (NULL, 'DEPOK', '7', '-', 0, 0)
ERROR - 2022-07-19 10:51:12 --> Query error: Column 'kecamatan' cannot be null - Invalid query: INSERT INTO `tweb_wil_cluster` (`kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES (NULL, 'DEPOK', '7', '-', '-', 0)
ERROR - 2022-07-19 10:51:12 --> Query error: Column 'kecamatan' cannot be null - Invalid query: INSERT INTO `tweb_wil_cluster` (`kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES (NULL, 'DEPOK', '7', 0, 0, '-')
ERROR - 2022-07-19 10:53:01 --> Severity: error --> Exception: Function name must be a string D:\laragon\www\sidega-kabupaten\kabupaten-app\views\sid\wilayah\wilayah_form_desa.php 33
ERROR - 2022-07-19 11:47:14 --> Query error: Column 'kecamatan' cannot be null - Invalid query: INSERT INTO `tweb_wil_cluster` (`kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES (NULL, 'JATISARI', '8', 0, 0, 0)
ERROR - 2022-07-19 11:47:14 --> Query error: Column 'kecamatan' cannot be null - Invalid query: INSERT INTO `tweb_wil_cluster` (`kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES (NULL, 'JATISARI', '8', '-', 0, 0)
ERROR - 2022-07-19 11:47:14 --> Query error: Column 'kecamatan' cannot be null - Invalid query: INSERT INTO `tweb_wil_cluster` (`kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES (NULL, 'JATISARI', '8', '-', '-', 0)
ERROR - 2022-07-19 11:47:14 --> Query error: Column 'kecamatan' cannot be null - Invalid query: INSERT INTO `tweb_wil_cluster` (`kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES (NULL, 'JATISARI', '8', 0, 0, '-')
ERROR - 2022-07-19 11:58:00 --> Query error: Unknown column 'id_kecamatan' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`id_kecamatan`, `kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES ('CISOMPET', 'CISOMPET', 'CIKONDANG', '9', 0, 0, 0)
ERROR - 2022-07-19 11:58:00 --> Query error: Unknown column 'id_kecamatan' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`id_kecamatan`, `kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES ('CISOMPET', NULL, 'CIKONDANG', '9', 0, 0, 0)
ERROR - 2022-07-19 11:58:00 --> Query error: Unknown column 'id_kecamatan' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`id_kecamatan`, `kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES ('CISOMPET', NULL, 'CIKONDANG', '9', '-', 0, 0)
ERROR - 2022-07-19 11:58:00 --> Query error: Unknown column 'id_kecamatan' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`id_kecamatan`, `kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES ('CISOMPET', NULL, 'CIKONDANG', '9', '-', '-', 0)
ERROR - 2022-07-19 11:58:00 --> Query error: Unknown column 'id_kecamatan' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`id_kecamatan`, `kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES ('CISOMPET', NULL, 'CIKONDANG', '9', 0, 0, '-')
ERROR - 2022-07-19 11:58:46 --> Query error: Unknown column 'id_kecamatan' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`id_kecamatan`, `kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES ('CISOMPET', 'CISOMPET', 'CIKONDANG', '9', 0, 0, 0)
ERROR - 2022-07-19 11:58:46 --> Query error: Unknown column 'id_kecamatan' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`id_kecamatan`, `kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES ('CISOMPET', NULL, 'CIKONDANG', '9', 0, 0, 0)
ERROR - 2022-07-19 11:58:46 --> Query error: Unknown column 'id_kecamatan' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`id_kecamatan`, `kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES ('CISOMPET', NULL, 'CIKONDANG', '9', '-', 0, 0)
ERROR - 2022-07-19 11:58:46 --> Query error: Unknown column 'id_kecamatan' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`id_kecamatan`, `kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES ('CISOMPET', NULL, 'CIKONDANG', '9', '-', '-', 0)
ERROR - 2022-07-19 11:58:46 --> Query error: Unknown column 'id_kecamatan' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`id_kecamatan`, `kecamatan`, `desa`, `id_kepala`, `dusun`, `rw`, `rt`) VALUES ('CISOMPET', NULL, 'CIKONDANG', '9', 0, 0, '-')
ERROR - 2022-07-19 12:00:13 --> Query error: Column 'kecamatan' cannot be null - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('CIKONDANG', '9', NULL, 0, 0, 0)
ERROR - 2022-07-19 12:00:13 --> Query error: Column 'kecamatan' cannot be null - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('CIKONDANG', '9', NULL, '-', 0, 0)
ERROR - 2022-07-19 12:00:13 --> Query error: Column 'kecamatan' cannot be null - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('CIKONDANG', '9', NULL, '-', '-', 0)
ERROR - 2022-07-19 12:00:13 --> Query error: Column 'kecamatan' cannot be null - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('CIKONDANG', '9', NULL, 0, 0, '-')
ERROR - 2022-07-19 12:11:21 --> Query error: Duplicate entry '0-0-0-0-SUKAMUKTI' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('SUKAMUKTI', '4', 0, 0, 0, 0)
ERROR - 2022-07-19 12:14:03 --> Query error: Unknown column '-ISOMPET' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`-ISOMPET`) VALUES ('')
ERROR - 2022-07-19 12:14:03 --> Query error: Unknown column '-ISOMPET' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`-ISOMPET`) VALUES ('')
ERROR - 2022-07-19 12:14:03 --> Query error: Unknown column '-ISOMPET' in 'field list' - Invalid query: INSERT INTO `tweb_wil_cluster` (`-ISOMPET`) VALUES ('')
ERROR - 2022-07-19 12:15:14 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '4', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:15:14 --> Query error: Duplicate entry '0-0---CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '4', 'CISOMPET', '-', 0, 0)
ERROR - 2022-07-19 12:15:14 --> Query error: Duplicate entry '0-----CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '4', 'CISOMPET', '-', '-', 0)
ERROR - 2022-07-19 12:16:17 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '5', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:16:17 --> Query error: Duplicate entry '0-0---CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '5', 'CISOMPET', '-', 0, 0)
ERROR - 2022-07-19 12:16:17 --> Query error: Duplicate entry '0-----CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '5', 'CISOMPET', '-', '-', 0)
ERROR - 2022-07-19 12:17:36 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '4', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:17:36 --> Query error: Duplicate entry '0-0---CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '4', 'CISOMPET', '-', 0, 0)
ERROR - 2022-07-19 12:17:36 --> Query error: Duplicate entry '0-----CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '4', 'CISOMPET', '-', '-', 0)
ERROR - 2022-07-19 12:21:54 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '5', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:21:54 --> Query error: Duplicate entry '0-0---CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '5', 'CISOMPET', '-', 0, 0)
ERROR - 2022-07-19 12:21:54 --> Query error: Duplicate entry '0-----CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '5', 'CISOMPET', '-', '-', 0)
ERROR - 2022-07-19 12:22:53 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '7', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:24:26 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '8', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:33:07 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '2', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:34:04 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '4', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:34:55 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '4', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:36:14 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '5', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:36:14 --> Query error: Duplicate entry '0-0---CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '5', 'CISOMPET', '-', 0, 0)
ERROR - 2022-07-19 12:36:14 --> Query error: Duplicate entry '0-----CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '5', 'CISOMPET', '-', '-', 0)
ERROR - 2022-07-19 12:36:14 --> Query error: Duplicate entry '------CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '5', 'CISOMPET', '-', '-', '-')
ERROR - 2022-07-19 12:37:13 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '7', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:38:42 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '8', 'CISOMPET', 0, 0, 0)
ERROR - 2022-07-19 12:39:21 --> Query error: Duplicate entry '0-0-0-CISOMPET--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '9', 'CISOMPET', 0, 0, 0)
