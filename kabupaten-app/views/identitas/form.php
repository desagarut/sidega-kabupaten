<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="content-wrapper">
	<section class="content-header">
		<h1>Identitas <?= $kabupaten; ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('beranda'); ?>"><i class="fa fa-home"></i> Beranda</a></li>
			<li><a href="<?= site_url('identitas'); ?>"></i> Identitas <?= $kabupaten; ?></a></li>
			<li class="active">Ubah Identitas <?= $kabupaten; ?></li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<form id="mainform" action="<?= $form_action; ?>" method="POST" enctype="multipart/form-data" class="form-horizontal" id="validasi">
				<div class="col-md-3">
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img class="profile-user-img img-responsive img-circle" src="<?= gambar_kabupaten($main['logo']); ?>" alt="Logo">
							<br/>
							<p class="text-center text-bold">Lambang <?= $kabupaten; ?></p>
							<p class="text-muted text-center text-red">(Kosongkan, jika logo tidak berubah)</p>
							<br/>
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" id="file_path" >
								<input type="file" class="hidden" id="file" name="logo">
								<input type="hidden" name="old_logo" value="<?= $main['logo']; ?>">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-box" id="file_browser"><i class="fa fa-search"></i> Browse</button>
								</span>
							</div>
						</div>
					</div>
					<div class="box box-primary">
						<div class="box-body box-profile">
							<img class="img-responsive" src="<?= gambar_kabupaten($main['kantor_kabupaten'], TRUE); ?>" alt="Kantor <?= $kabupaten; ?>">
							<br/>
							<p class="text-center text-bold">Kantor <?= $kabupaten; ?></p>
							<p class="text-muted text-center text-red">(Kosongkan, jika kantor <?= $kabupaten; ?> tidak berubah)</p>
							<br/>
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" id="file_path2" >
								<input type="file" class="hidden" id="file2" name="kantor_kabupaten">
								<input type="hidden" name="old_kantor_kabupaten" value="<?= $main['kantor_kabupaten']; ?>">
								<span class="input-group-btn">
									<button type="button" class="btn btn-info btn-box" id="file_browser2"><i class="fa fa-search"></i> Browse</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="box box-primary">
						<div class="box-header with-border">
							<a href="<?= site_url('identitas'); ?>" class="btn btn-social btn-box btn-info btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Kembali Ke Data <?= $kabupaten; ?>"><i class="fa fa-arrow-circle-o-left"></i> Kembali Ke Data Identitas <?= $kabupaten; ?></a>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label class="col-sm-3 control-label" for="nama">Nama <?= $kabupaten; ?></label>
								<div class="col-sm-8">
									<input id="nama_kabupaten" name="nama_kabupaten" class="form-control input-sm nama_terbatas required" maxlength="50" type="text" placeholder="Nama <?= $kabupaten; ?>" value="<?= $main["nama_kabupaten"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="kode_kabupaten">Kode <?= $kabupaten; ?></label>
								<div class="col-sm-2">
									<input id="kode_kabupaten" name="kode_kabupaten" class="form-control input-sm bilangan required"  minlength="4" maxlength="4" type="text" placeholder="Kode <?= $kabupaten; ?>" value="<?= $main["kode_kabupaten"]; ?>" ></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="nama_bupati">Nama Bupati</label>
								<div class="col-sm-8">
									<input id="nama_bupati" name="nama_bupati" class="form-control input-sm nama required" maxlength="50" type="text" placeholder="Bupati" value="<?= $main["nama_bupati"]?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="nip_bupati">NIP Bupati</label>
								<div class="col-sm-8">
									<input id="nip_bupati" name="nip_bupati" class="form-control input-sm nomor_sk" maxlength="50" type="text" placeholder="NIP Bupati" value="<?= $main["nip_bupati"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="nama_wakil_bupati">Nama Wakil Bupati</label>
								<div class="col-sm-8">
									<input id="nama_wakil_bupati" name="nama_wakil_bupati" class="form-control input-sm nama required" maxlength="50" type="text" placeholder="Wakil Bupati" value="<?= $main["nama_wakil_bupati"]?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="nip_wakil_bupati">NIP Bupati</label>
								<div class="col-sm-8">
									<input id="nip_wakil_bupati" name="nip_wakil_bupati" class="form-control input-sm nomor_sk" maxlength="50" type="text" placeholder="NIP Wakil Bupati" value="<?= $main["nip_wakil_bupati"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="alamat">Alamat Kantor </label>
								<div class="col-sm-8">
									<textarea id="alamat" name="alamat" class="form-control input-sm alamat required" maxlength="100" placeholder="Alamat Kantor <?= $kabupaten; ?>" rows="3" style="resize:none;"><?= $main["alamat"]; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="kode_pos">Kode Pos </label>
								<div class="col-sm-2">
									<input id="kode_pos" name="kode_pos" class="form-control input-sm number" minlength="5" maxlength="5" type="text" placeholder="Kode Pos " value="<?= $main["kode_pos"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="email">E-Mail </label>
								<div class="col-sm-8">
									<input id="email" name="email" class="form-control input-sm email" maxlength="50" type="text" placeholder="E-Mail <?= $kabupaten; ?>" value="<?= $main["email"]?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="telepon">Telpon </label>
								<div class="col-sm-8">
									<input id="telepon" name="telepon" class="form-control input-sm bilangan" type="text" maxlength="15" placeholder="Telpon <?= $kabupaten; ?>" value="<?= $main["telepon"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="website">Website </label>
								<div class="col-sm-8">
									<input id="website" name="website" class="form-control input-sm url" maxlength="50" type="text" placeholder="Website " value="<?= $main["website"]; ?>"></input>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label" for="propinsi">Provinsi</label>
								<div class="col-sm-4">
									<select name="nama_propinsi" class="form-control select2 input-sm required" onchange="$('input[name=kode_propinsi]').val($(this).find(':selected').data('kode'));" style="width: 100%;">
										<option value="">Pilih Provinsi</option>
										<?php foreach ($list_provinsi AS $data): ?>
											<option value="<?= $data['nama']; ?>" data-kode="<?= $data['kode']; ?>" <?= selected(strtolower($main['nama_propinsi']), strtolower($data['nama'])); ?>><?= $data['nama']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="kode_propinsi">Kode Provinsi</label>
								<div class="col-sm-2">
									<input id="kode_propinsi" name="kode_propinsi" class="form-control input-sm bilangan required" minlength="2" maxlength="2" type="text" placeholder="Kode Provinsi" value="<?= $main["kode_propinsi"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="batas_utara">Batas Utara <?= $batas_utara; ?></label>
								<div class="col-sm-8">
									<input id="batas_utara" name="batas_utara" class="form-control input-sm nama_terbatas required" maxlength="50" type="text" placeholder="Nama Utara" value="<?= $main["batas_utara"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="batas_selatan">Batas Selatan <?= $batas_selatan; ?></label>
								<div class="col-sm-8">
									<input id="batas_selatan" name="batas_selatan" class="form-control input-sm nama_terbatas required" maxlength="50" type="text" placeholder="Nama Selatan" value="<?= $main["batas_selatan"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="batas_timur">Batas Timur <?= $batas_timur; ?></label>
								<div class="col-sm-8">
									<input id="batas_timur" name="batas_timur" class="form-control input-sm nama_terbatas required" maxlength="50" type="text" placeholder="Nama Timur" value="<?= $main["batas_timur"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="batas_barat">Batas Barat <?= $batas_barat; ?></label>
								<div class="col-sm-8">
									<input id="batas_barat" name="batas_barat" class="form-control input-sm nama_terbatas required" maxlength="50" type="text" placeholder="Nama Barat" value="<?= $main["batas_barat"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="batas_barat">Luas Wilayah </label>
								<div class="col-sm-8">
									<input id="luas_wilayah" name="luas_wilayah" class="form-control input-sm" maxlength="10" type="text" placeholder="" value="<?= $main["luas_wilayah"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="batas_barat">Ketinggian Diatas Permukaan Laut (mdpl)</label>
								<div class="col-sm-8">
									<input id="mdpl" name="mdpl" class="form-control input-sm" maxlength="50" type="text" placeholder="" value="<?= $main["mdpl"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="batas_barat">Terluar di Indonesia</label>
								<div class="col-sm-8">
									<input id="terluar_id" name="terluar_id" class="form-control input-sm" maxlength="50" type="text" placeholder="" value="<?= $main["terluar_id"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="batas_barat">Terluar di Provinsi</label>
								<div class="col-sm-8">
									<input id="terluar_prov" name="terluar_prov" class="form-control input-sm" maxlength="50" type="text" placeholder="" value="<?= $main["terluar_prov"]; ?>"></input>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="profil_singkat">Profil Singkat <?= $kabupaten; ?></label>
								<div class="col-sm-8">
									<textarea id="profil_singkat" name="profil_singkat" class="form-control input-sm alamat" placeholder="Profil Singkat <?= $kabupaten; ?>" rows="3" style="resize:auto;"><?= $main["profil_singkat"]; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="visi">Visi <?= $kabupaten; ?></label>
								<div class="col-sm-8">
									<textarea id="visi" name="visi" class="form-control input-sm" placeholder="Visi <?= $kabupaten; ?>" rows="3" style="resize:auto;"><?= $main["visi"]; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="misi">Misi <?= $kabupaten; ?></label>
								<div class="col-sm-8">
									<textarea id="misi" name="misi" class="form-control input-sm" placeholder="Misi <?= $kabupaten; ?>" rows="3" style="resize:auto;"><?= $main["misi"]; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="strategi">Strategi <?= $kabupaten; ?></label>
								<div class="col-sm-8">
									<textarea id="strategi" name="strategi" class="form-control input-sm" placeholder="strategi <?= $kabupaten; ?>" rows="3" style="resize:auto;"><?= $main["strategi"]; ?></textarea>
								</div>
							</div>
						</div>
						<div class='box-footer'>
							<button type='reset' class='btn btn-social btn-box btn-danger btn-sm' ><i class='fa fa-times'></i> Batal</button>
							<button type='submit' class='btn btn-social btn-box btn-info btn-sm pull-right'><i class='fa fa-check'></i> Simpan</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>
