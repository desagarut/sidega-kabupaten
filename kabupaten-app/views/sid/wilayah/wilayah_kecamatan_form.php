<div class="content-wrapper">
	<section class="content-header">
    <h1>Form <?= ucwords($this->setting->sebutan_kecamatan)?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('beranda')?>"><i class="fa fa-home"></i> Beranda</a></li>
			<li><a href="<?= site_url('sid_core')?>"> Daftar <?= ucwords($this->setting->sebutan_kecamatan)?></a></li>
			<li class="active">Form <?= ucwords($this->setting->sebutan_kecamatan)?></li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<a href="<?= site_url("sid_core")?>" class="btn btn-social btn-box btn-info btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"  title="Kembali Ke Daftar Wilayah">
							<i class="fa fa-arrow-circle-left "></i>Kembali ke Daftar <?= ucwords($this->setting->sebutan_kecamatan)?>
           	</a>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12">
								<form id="validasi" action="<?= $form_action?>" method="POST" enctype="multipart/form-data"  class="form-horizontal">
									<div class="box-body">
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<label class="col-sm-3 control-label" for="kecamatan">Nama  <?= ucwords($this->setting->sebutan_kecamatan)?></label>
													<div class="col-sm-7">
														<input  id="kecamatan" class="form-control input-sm nama_terbatas required" maxlength="100" type="text" placeholder="Nama  <?= ucwords($this->setting->sebutan_kecamatan)?>" name="kecamatan" value="<?= $kecamatan?>">
													</div>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label class="col-sm-3 control-label" for="kode_kecamatan">Kode  <?= ucwords($this->setting->sebutan_kecamatan)?></label>
													<div class="col-sm-7">
														<input  id="kode_kecamatan" class="form-control input-sm nama_terbatas required" maxlength="100" type="text" placeholder="kode  <?= ucwords($this->setting->sebutan_kecamatan)?>" name="kode_kecamatan" value="<?= $kode_kecamatan?>">
													</div>
												</div>
											</div>

											<?php if ($kecamatan): ?>
												<div class="col-sm-12">
													<div class="form-group">
														<label class="col-sm-3 control-label" for="kepala_lama">Camat Sebelumnya</label>
														<div class="col-sm-7">
															<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
																<strong><?= $individu["nama"]?></strong>
																<br/>NIK - <?= $individu["nik"]?>
															</p>
														</div>
													</div>
												</div>
											<?php endif; ?>
											<div class="col-sm-12">
												<div class="form-group">
													<label class="col-sm-3 control-label" for="id_kepala">NIK / Nama Camat</label>
													<div class="col-sm-7">
														<select class="form-control select2" style="width: 100%;" id="id_kepala" name="id_kepala">
															<option selected="selected">-- Silakan Masukan NIK / Nama--</option>
															<?php foreach ($penduduk as $data): ?>
																<option value="<?= $data['id']?>">NIK :<?= $data['nik']." - ".$data['nama']." - ".$data['kecamatan']." - ".$data['desa']." - ".$data['dusun']." - ".$data['rw']." - ".$data['rt']?></option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class='box-footer'>
										<div class='col-xs-12'>
											<button type='reset' class='btn btn-social btn-box btn-danger btn-sm invisible' ><i class='fa fa-times'></i> Batal</button>
											<button type='submit' class='btn btn-social btn-box btn-info btn-sm pull-right'><i class='fa fa-check'></i> Simpan</button>
										</div>
									</div>
								</form>
							</div>
           	</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script src="<?= base_url()?>assets/js/validasi.js"></script>
<script src="<?= base_url()?>assets/js/jquery.validate.min.js"></script>
<script src="<?= base_url()?>assets/js/localization/messages_id.js"></script>
<script type="text/javascript">
	setTimeout(function() {
		$('#kecamatan').rules('add', {
			maxlength: 50
		})
	}, 500);
</script>
