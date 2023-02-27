<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php /*
	$title = (!empty($judul_kategori))? $judul_kategori: "Berita Terkini";
	if(is_array($title)){
		foreach($title as $item){
			$title = $item;
		}
	}*/
?>
<?php /*
	if (empty($this->input->get('cari')) AND
		((count($slide_galeri) > 0 || count($slide_artikel) > 0)) AND 
			$this->uri->segment(2) != 'kategori') {
		$this->load->view($folder_themes .'/partials/slider');
	}*/
?>
<?php // $this->load->view($folder_themes .'/partials/running_text') ?>
<?php //$this->load->view($folder_themes .'/partials/slider_berita') ?>
<?php //$this->load->view($folder_themes .'/partials/umkm_list') ?>
<?php //$this->load->view($folder_themes .'/partials/toko_warga/toko_show') ?>

<?php //if(empty($this->input->get('cari')) AND $headline AND $this->uri->segment(2) != 'kategori') : ?>
	<?php //$this->load->view($folder_themes .'/partials/headline') ?>
<?php //endif ?>
<?php $this->load->view($folder_themes .'/partials/header-carousel') ?>
<?php $this->load->view($folder_themes .'/partials/statistik') ?>
<?php $this->load->view($folder_themes .'/partials/about') ?>
<?php $this->load->view($folder_themes .'/partials/features') ?>
<?php $this->load->view($folder_themes .'/partials/service') ?>
<?php $this->load->view($folder_themes .'/partials/pricing') ?>
<?php $this->load->view($folder_themes .'/partials/quote') ?>
<?php // $this->load->view($folder_themes .'/partials/testimoni') ?>
<?php $this->load->view($folder_themes .'/partials/aparatur') ?>
<?php $this->load->view($folder_themes .'/partials/blog') ?>
<?php $this->load->view($folder_themes .'/partials/vendor') ?>
