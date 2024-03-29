<div class="content-wrapper">
	<section class="content-header">
		<h1>Profil Desa</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('beranda') ?>"><i class="fa fa-home"></i> Beranda</a></li>
			<li><a href="<?= site_url('beranda') ?>"></i> Potensi Umum</a></li>
			<li class="active">Batas Wilayah</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="mainformexcel" name="mainformexcel"method="post" class="form-horizontal">
			<div class="row">
				<div class="col-md-4 col-lg-3">
					<?php $this->load->view('potensi/menu.php')?>
				</div>
				<div class="col-md-8 col-lg-9">
					<div class="box box-info">
						<div class="box-header with-border">
							<a href="<?= site_url('potensi_umum/form') ?>" class="btn btn-social btn-box btn-success btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Tambah Data Baru">
								<i class="fa fa-plus"></i>Tambah Data
							</a>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-2">
												<select class="form-control input-sm select2" id="tahun_laporan" name="tahun_laporan" style="width:100%;">
													<option selected value="semua">Semua Tahun</option>
													<?php foreach ($list_tahun as $list) : ?>
														<option value="<?= $list->tahun_laporan ?>"><?= $list->tahun_laporan ?></option>
													<?php endforeach; ?>
												</select>
												</div>
											</div>
											<hr>
											<div class="table-responsive">
												<table id="tabel-potensi" class="table table-bordered dataTable table-hover">
													<thead class="bg-purple">
														<tr>
															<th class="text-center">No</th>
															<th width="230px" class="text-center">Aksi</th>
															<th class="text-center">Bulan</th>
															<th class="text-center">Tahun</th>
															<th class="text-center">Tahun Pembentukan</th>
															<th class="text-center">Luas Desa (Ha)</th>
															<th class="text-center">Nama Kepala <?= ucwords($this->setting->sebutan_desa)?> </th>
															<th class="text-center">Sebelah Utara</th>
															<th class="text-center">Sebelah Selatan</th>
															<th class="text-center">Sebelah Timur</th>
															<th class="text-center">Sebelah Barat</th>
															<th class="text-center">Penetapan Batas</th>
															<th class="text-center">Dasar Hukum Perdes No.</th>
															<th class="text-center">Dasar Hukum Perda No.</th>
															<th class="text-center">Peta Wilayah</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
<?php $this->load->view('global/confirm_delete'); ?>
<script>
	$(document).ready(function() {
		let tabelPotensi = $('#tabel-potensi').DataTable({
			'processing': true,
			'serverSide': true,
			'autoWidth': false,
			'pageLength': 10,
			'order': [
				[7, 'desc'],
			],
			'columnDefs': [{
				'orderable': false,
				'targets': [0, 1, 10],
			}],
			'ajax': {
				'url': "<?= site_url('potensi_umum') ?>",
				'method': 'POST',
				'data': function(d) {
					d.tahun_laporan = $('#tahun_laporan').val();
				}
			},
			'columns': [
				{
					'data': null,
				},
				{
					'data': function(data) {
						let status;
						if (data.status == 1) {
							status = `<a href="<?= site_url('potensi_umum/lock/') ?>${data.id}" class="btn bg-navy btn-box btn-sm" title="Non Aktifkan"><i class="fa fa-unlock"></i></a>`
						} else {
							status = `<a href="<?= site_url('potensi_umum/unlock/') ?>${data.id}" class="btn bg-navy btn-box btn-sm" title="Aktifkan"><i class="fa fa-lock"></i></a>`
						}

						return `
							<a href="<?= site_url('potensi_umum/info_potensi/'); ?>${data.id}" class="btn bg-blue btn-box btn-sm" title="Lihat Ringkasan"><i class="fa fa-search"></i></a>
							<a href="<?= site_url('potensi_umum/form/'); ?>${data.id}" title="Edit Data"  class="btn bg-orange btn-box btn-sm"><i class="fa fa-edit"></i></a>
							<a href="<?= site_url('potensi_umum/lokasi_maps/'); ?>${data.id}" class="btn bg-olive btn-box btn-sm" title="Lokasi Kantor Desa"><i class="fa fa-map"></i></a>
							<a href="<?= site_url('potensi_umum_dokumentasi/show/'); ?>${data.id}" class="btn bg-purple btn-box btn-sm" title="Rincian Dokumentasi"><i class="fa fa-list-ol"></i></a>
							${status}
							<a href="#" data-href="<?= site_url('potensi_umum/delete/'); ?>${data.id}" class="btn bg-maroon btn-box btn-sm"  title="Hapus" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>							`
					}
				},
				{
					'data': 'bulan_laporan'
				},
				{
					'data': 'tahun_laporan'
				},
				{
					'data': 'tahun_pembentukan'
				},
				{
					'data': 'luas_desa',
					'render': $.fn.dataTable.render.number( ',', '.', 0, )
				},
				{
					'data': 'nama_kepala'
				},
				{
					'data': 'batas_desa_utara'
				},
				{
					'data': 'batas_desa_selatan'
				},
				{
					'data': 'batas_desa_timur'
				},
				{
					'data': 'batas_desa_barat'
				},
				{
					'data': 'penetapan_batas'
				},
				{
					'data': 'no_perdes'
				},
				{
					'data': 'no_perda'
				},
				{
					'data': 'peta_wilayah'
				},
			],
			'language': {
				'url': "<?= base_url('/assets/bootstrap/js/dataTables.indonesian.lang') ?>"
			}
		});

		tabelPotensi.on('draw.dt', function() {
			let PageInfo = $('#tabel-potensi').DataTable().page.info();
			tabelPotensi.column(0, {
				page: 'current'
			}).nodes().each(function(cell, i) {
				cell.innerHTML = i + 1 + PageInfo.start;
			});
		});

		$('#tahun_laporan').on('select2:select', function (e) {
			tabelPotensi.ajax.reload();
		});
	});
</script>
