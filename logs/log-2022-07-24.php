<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-07-24 16:11:53 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''0' and w.desa '0' and `w`.`rt` = '0'
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
ERROR - 2022-07-24 16:11:53 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\laragon\www\sidega-kabupaten\kabupaten-app\models\Wilayah_model.php 124
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Lib/lightbox
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Lib/owlcarousel
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Css/bootstrap.min.css
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Lib/animate
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Css/style.css
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Lib/wow
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Lib/easing
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Lib/waypoints
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Lib/counterup
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Lib/owlcarousel
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Lib/isotope
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Lib/lightbox
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Js/main.js
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Img/hero.png
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Img/about.png
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Img/portfolio-1.jpg
ERROR - 2022-07-24 10:02:03 --> 404 Page Not Found: Img/portfolio-2.jpg
ERROR - 2022-07-24 10:02:04 --> 404 Page Not Found: Img/portfolio-3.jpg
ERROR - 2022-07-24 10:02:04 --> 404 Page Not Found: Img/portfolio-4.jpg
ERROR - 2022-07-24 10:02:04 --> 404 Page Not Found: Img/portfolio-5.jpg
ERROR - 2022-07-24 10:02:04 --> 404 Page Not Found: Img/portfolio-6.jpg
ERROR - 2022-07-24 10:02:04 --> 404 Page Not Found: Img/testimonial-1.jpg
ERROR - 2022-07-24 10:02:04 --> 404 Page Not Found: Img/testimonial-2.jpg
ERROR - 2022-07-24 10:02:04 --> 404 Page Not Found: Img/testimonial-3.jpg
ERROR - 2022-07-24 10:02:04 --> 404 Page Not Found: Img/team-1.jpg
ERROR - 2022-07-24 10:02:04 --> 404 Page Not Found: Img/team-2.jpg
ERROR - 2022-07-24 10:02:04 --> 404 Page Not Found: Img/team-3.jpg
ERROR - 2022-07-24 10:02:04 --> 404 Page Not Found: Img/favicon.ico
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/portfolio-1.jpg
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/about.png
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/hero.png
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/portfolio-2.jpg
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/portfolio-4.jpg
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/portfolio-3.jpg
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/portfolio-5.jpg
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/portfolio-6.jpg
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/testimonial-1.jpg
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/testimonial-2.jpg
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/testimonial-3.jpg
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/team-1.jpg
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/team-2.jpg
ERROR - 2022-07-24 10:07:25 --> 404 Page Not Found: Img/team-3.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/portfolio-1.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/portfolio-2.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/portfolio-3.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/about.png
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/hero.png
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/portfolio-4.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/portfolio-5.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/portfolio-6.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/testimonial-1.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/testimonial-2.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/testimonial-3.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/team-1.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/team-2.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/team-3.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/portfolio-2.jpg
ERROR - 2022-07-24 10:09:20 --> 404 Page Not Found: Img/portfolio-3.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Js/main.js
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/carousel-1.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/team-1.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/carousel-2.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/about.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/carousel-3.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/service-1.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/service-2.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/service-3.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/service-4.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/service-5.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/service-6.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/feature.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/project-1.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/project-2.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/project-3.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/project-4.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/project-5.jpg
ERROR - 2022-07-24 10:13:21 --> 404 Page Not Found: Img/project-6.jpg
ERROR - 2022-07-24 10:13:22 --> 404 Page Not Found: Img/project-7.jpg
ERROR - 2022-07-24 10:13:22 --> 404 Page Not Found: Img/project-8.jpg
ERROR - 2022-07-24 10:13:22 --> 404 Page Not Found: Img/project-9.jpg
ERROR - 2022-07-24 10:13:22 --> 404 Page Not Found: Img/project-10.jpg
ERROR - 2022-07-24 10:13:22 --> 404 Page Not Found: Img/team-2.jpg
ERROR - 2022-07-24 10:13:22 --> 404 Page Not Found: Img/team-3.jpg
ERROR - 2022-07-24 10:13:22 --> 404 Page Not Found: Img/testimonial-1.jpg
ERROR - 2022-07-24 10:13:22 --> 404 Page Not Found: Img/testimonial-2.jpg
ERROR - 2022-07-24 10:13:22 --> 404 Page Not Found: Img/testimonial-3.jpg
ERROR - 2022-07-24 10:13:22 --> 404 Page Not Found: Img/testimonial-4.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/about.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/service-1.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/carousel-1.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/team-1.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/carousel-3.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/carousel-2.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/service-2.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/service-3.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/service-4.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/service-5.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/service-6.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/feature.jpg
ERROR - 2022-07-24 10:14:06 --> 404 Page Not Found: Img/project-1.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/project-2.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/project-3.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/project-4.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/project-5.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/project-6.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/project-7.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/project-8.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/project-9.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/project-10.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/team-2.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/team-3.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/testimonial-1.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/testimonial-2.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/testimonial-3.jpg
ERROR - 2022-07-24 10:14:07 --> 404 Page Not Found: Img/testimonial-4.jpg
ERROR - 2022-07-24 10:25:19 --> 404 Page Not Found: Contacthtml/index
