<style type="text/css">
	.text-white {
		color: white;
	}
	.pengaturan {
		float: left;
		padding-left: 10px;
	}
	.modal-body
	{
		overflow-y: auto;
		height: 400px;
		margin-left: 5px;
		margin-right: 5px;
	}
</style>
<div class="content-wrapper">
	<section class='content-header'>
		<h1>Beranda</h1>
		<ol class='breadcrumb'>
			<li><a href='<?=site_url()?>beranda'><i class='fa fa-home'></i> Beranda</a></li>
		</ol>
	</section>
    
	<section class='content' id="maincontent">
        <div class='row'>
			<?php $this->load->view('beranda/peta.php');?>
            <?php $this->load->view('beranda/umkm.php');?>
            <?php //$this->load->view('beranda/program_bantuan.php');?>
			<?php $this->load->view('beranda/layanan.php');?>
            
        </div>
        <div class='row'>
            <?php //$this->load->view('beranda/info.php');?>
			<?php //$this->load->view('beranda/layanan.php');?>
        </div>
        <div class='row'>
		<?php $this->load->view('beranda/rekap_sppt.php');?>
            <?php $this->load->view('beranda/warga_login.php');?>
			<?php $this->load->view('beranda/aparat_login.php');?>
			<?php $this->load->view('beranda/pengunjung.php');?>
		</div>
        <div class='row'>
            <?php $this->load->view('beranda/helpdesk.php');?>
            <?php $this->load->view('beranda/changelog.php');?>
			<?php $this->load->view('beranda/youtube.php');?>
        </div>
	</section>
</div>



