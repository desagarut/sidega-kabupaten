<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php defined('THEME_VERSION') or define('THEME_VERSION', 'V4.7') ?>

<?php $kabupaten_title = trim(ucwords($this->setting->sebutan_kecamatan) . ' ' . $kabupaten['nama_kecamatan'].' '.$this->setting->sebutan_kabupaten . ' ' . $kabupaten['nama_kabupaten']); ?>

    <meta content="utf-8" http-equiv="encoding">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name='viewport' content='width=device-width, initial-scale=1' />

    <meta name='google' content='notranslate' />

    <meta name='theme' content='Potensi Kecamatan umkm' />

    <meta name='designer' content='Bambang Andri H'/>

    <meta name='theme:designer' content='Bambang Andri H' />

    <meta name="theme:version" content="<?= THEME_VERSION ?>" />

    <meta name="theme-color" content="#00C" />

    <meta name="keywords" content="sidega, SIDEGA, SIDeGa, sistem informasi desa garut, web, blog, informasi, website, tema sidega-blue, desa garut, kelurahan garut, kecamatan garut, kabupaten garut, Jawa Barat, indonesia"/>

    <meta property="og:site_name" content="<?= $kabupaten_title ?>"/>

    <meta property="og:type" content="article"/>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">


<?php if(isset($single_artikel)): ?>

	<title><?= $single_artikel["judul"] . " - $kabupaten_title" ?></title>

	<meta name='description' content="<?= str_replace('"', "'", substr(strip_tags($single_artikel['isi']), 0, 400)); ?>" />

	<meta property="og:title" content="<?= $single_artikel["judul"];?>"/>

	<?php if (trim($single_artikel['gambar'])!=''): ?>

	<meta property="og:image" content="<?= base_url()?><?= LOKASI_FOTO_ARTIKEL?>sedang_<?= $single_artikel['gambar'];?>"/>

	<?php endif; ?>

	<meta property='og:description' content="<?= str_replace('"', "'", substr(strip_tags($single_artikel['isi']), 0, 400)); ?>" />

<?php else: ?>

	<title><?php $tmp = ltrim(get_dynamic_title_page_from_path(), ' -'); echo (trim($tmp)=='') ? $kabupaten_title : "$tmp - $kabupaten_title"; ?></title>

	<meta name='description' content="<?= $this->setting->website_title . ' ' . $kabupaten_title; ?>" />

	<meta property="og:title" content="<?= $kabupaten_title;?>"/>

	<meta property='og:description' content="<?= $this->setting->website_title . ' ' . $kabupaten_title; ?>" />

<?php endif; ?>

    <meta property='og:url' content="<?= current_url(); ?>" />

<?php if(is_file(LOKASI_LOGO_INSTANSI . "favicon.ico")): ?>

    <link rel="shortcut icon" href="<?= base_url() . LOKASI_LOGO_INSTANSI?>favicon.ico" />

<?php else: ?>

    <link rel="shortcut icon" href="<?= base_url('favicon.ico')?>" />

<?php endif; ?>


	<script>const BASE_URL = '<?= base_url() ?>';	</script>

