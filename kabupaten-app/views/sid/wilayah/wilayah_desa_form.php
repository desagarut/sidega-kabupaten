<div class="content-wrapper">
	<section class="content-header">
		<h1><?= ucwords($this->setting->sebutan_kecamatan) ?> <?= $kecamatan?> Form Desa</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('beranda') ?>"><i class="fa fa-home"></i> Beranda</a></li>
			<li><a href="<?= site_url('sid_core') ?>"> <?= ucwords($this->setting->sebutan_kecamatan) ?> <?= $kecamatan?></a></li>
			<li><a href="<?= site_url("sid_core/sub_desa/$id_desa") ?>"> Daftar Desa</a></li>
			<li class="active">Form</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<a href="<?= site_url("sid_core/sub_desa/$id_kecamatan/$id_desa") ?>" class="btn btn-social btn-box btn-info btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Kembali Ke Daftar Desa">
							<i class="fa fa-arrow-circle-left "></i>Kembali ke Daftar Desa
						</a>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12">
								<form id="validasi" action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
									<div class="box-body">
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<label class="col-sm-3 control-label" for="kecamatan">Kecamatan</label>
													<div class="col-sm-3">
														<input id="kode_kecamatan" class="form-control input-sm" disabled maxlength="100" type="text" placeholder="Kode kecamatan" name="kode_kecamatan" value="<?= $kode_kecamatan ?>">
													</div>
													<div class="col-sm-4">
														<input id="kecamatan" class="form-control input-sm nama_terbatas" disabled maxlength="100" type="text" placeholder="Nama kecamatan" name="kecamatan" value="<?= $kecamatan ?>">
													</div>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label class="col-sm-3 control-label" for="desa">Nama Desa</label>
													<div class="col-sm-3">
														<input id="kode_desa" class="form-control input-sm nama_terbatas required" maxlength="100" type="text" placeholder="Kode Desa" name="kode_desa" value="<?= $kode_desa ?>">
													</div>

													<div class="col-sm-4">
														<?php if ($id_desa) : ?>
															<input type="hidden" name="id_desa" value="<?= $id_desa ?>">
														<?php endif; ?>
														<input id="desa" class="form-control input-sm nama_terbatas required" maxlength="100" type="text" placeholder="Nama Desa" name="desa" value="<?= $desa ?>">
													</div>
												</div>
											</div>
											<?php if ($desa) : ?>
												<div class="col-sm-12">
													<div class="form-group">
														<label class="col-sm-3 control-label" for="kepala_lama">Kades / Lurah Sebelumnya</label>
														<div class="col-sm-7">
															<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
																<strong><?= $individu["nama"] ?></strong>
																<br />NIK - <?= $individu["nik"] ?>
															</p>
														</div>
													</div>
												</div>
											<?php endif; ?>
											<div class="col-sm-12">
												<div class="form-group">
													<label class="col-sm-3 control-label" for="id_kepala">NIK / Nama Kepala Desa</label>
													<div class="col-sm-7">
														<select class="form-control select2" style="width: 100%;" id="id_kepala" name="id_kepala">
															<option selected="selected">-- Silakan Masukan NIK / Nama--</option>
															<?php foreach ($penduduk as $data) : ?>
																<option value="<?= $data['id'] ?>">NIK :<?= $data['nik'] . " - " . $data['nama'] . " - " . $data['dusun'] . " - " . $data['desa'] . " - " . $data['kecamatan'] ?></option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class='box-footer'>
										<div class='col-xs-12'>
											<button type='reset' class='btn btn-social btn-box btn-danger btn-sm invisible'><i class='fa fa-times'></i> Batal</button>
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
<script src="<?= base_url() ?>assets/js/validasi.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/localization/messages_id.js"></script>
<script type="text/javascript">
	setTimeout(function() {
		$('#desa').rules('add', {
			maxlength: 100
		})
	}, 500);
</script>