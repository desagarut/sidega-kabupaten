<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-07-20 19:12:27 --> Query error: Duplicate entry '0-0-0-PAMEUNGPEUK--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `id_kepala`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', '10', 'PAMEUNGPEUK', 0, 0, 0)
ERROR - 2022-07-20 19:12:44 --> Query error: Duplicate entry '0-0-0-PAMEUNGPEUK--' for key 'rt' - Invalid query: INSERT INTO `tweb_wil_cluster` (`desa`, `kecamatan`, `dusun`, `rw`, `rt`) VALUES ('-', 'PAMEUNGPEUK', 0, 0, 0)
ERROR - 2022-07-20 20:37:32 --> Severity: error --> Exception: Call to undefined method Wilayah_model::total_desat() D:\laragon\www\sidega-kabupaten\kabupaten-app\controllers\Sid_core.php 154
ERROR - 2022-07-20 21:02:59 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' and w.desa '0' and `w`.`rt` = '0'
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
ERROR - 2022-07-20 21:02:59 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\laragon\www\sidega-kabupaten\kabupaten-app\models\Wilayah_model.php 124
ERROR - 2022-07-20 14:06:29 --> Severity: error --> Exception: Class 'CI_Controller' not found D:\laragon\www\sidega-kabupaten\system\core\CodeIgniter.php 369
