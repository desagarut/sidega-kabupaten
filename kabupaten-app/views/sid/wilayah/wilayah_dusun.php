<div class="content-wrapper">
	<section class="content-header">
		<h1>WILAYAH ADMINISTRATIF DESA/KELURAHAN <?= $desa ?></h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('beranda') ?>"><i class="fa fa-home"></i> Beranda</a></li>
			<li><a href="<?= site_url('sid_core') ?>"> Wilayah Kab.<?= $kabupaten['nama_kabupaten']?></a></li>
			<li><a href="<?= site_url('sid_core/sub_desa') ?>">Kec. <?= $kecamatan ?></a></li>
			<li><a href="<?= site_url('sid_core/sub_dusun') ?>">Deskel. <?= $desa ?></a></li>
			<li class="active">Data Dusun/Wilayah</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<?php if ($this->CI->cek_hak_akses('h')) : ?>
							<a href="<?= site_url("sid_core/form_desa/$id_desa") ?>" class="btn btn-social btn-box btn-success btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Tambah Data"><i class="fa fa-plus"></i> Tambah Dusun / Wilayah</a>
						<?php endif; ?>
						<a href="<?= site_url("sid_core/cetak_desa/$id_desa") ?>" class="btn btn-social btn-box bg-purple btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Cetak Data" target="_blank"><i class="fa fa-print "></i> Cetak</a>
						<a href="<?= site_url("sid_core/excel_desa/$id_desa") ?>" class="btn btn-social btn-box bg-navy btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Unduh Data" target="_blank"><i class="fa fa-download"></i> Unduh</a>
						<a href="<?= site_url("sid_core/sub_desa/$id_desa") ?>" class="btn btn-social btn-box btn-info btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Kembali Ke Daftar Desa / Kelurahan">
							<i class="fa fa-arrow-circle-left "></i>Kembali ke Daftar Desa / Kelurahan
						</a>
					</div>
					<div class="box-header with-border">
						<h4 class="text-center">DATA DUSUN/WILAYAH DESA/KELURAHAN <?= $desa ?><br/>
						 <?= strtoupper($this->setting->sebutan_kecamatan) ?> <?= $kecamatan ?> <?= strtoupper($this->setting->sebutan_kabupaten) ?> <?= $kabupaten['nama_kabupaten']?> </h4>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
									<form id="mainform" name="mainform" action="" method="post">
										<div class="row">
											<div class="col-sm-12">
												<div class="table-responsive">
													<table class="table table-bordered table-striped dataTable table-hover">
														<thead class="bg-gray disabled color-palette">
															<tr>
																<th class="padat">No</th>
																<th wlass="padat">Aksi</th>
																<th width="25%">Nama Desa</th>
																<th width="35%">Nama Kepala Desa</th>
																<th class="text-center">Dusun</th>
																<th class="text-center">RW</th>
																<th class="text-center">RT</th>
																<th class="text-center">KK</th>
																<th class="text-center">L+P</th>
																<th class="text-center">L</th>
																<th class="text-center">P</th>
															</tr>
														</thead>
														<tbody>
															<?php
															$total = array();
															$total['total_dusun'] = 0;
															$total['total_rw'] = 0;
															$total['total_rt'] = 0;
															$total['total_kk'] = 0;
															$total['total_warga'] = 0;
															$total['total_warga_l'] = 0;
															$total['total_warga_p'] = 0;
															foreach ($main as $data) :
															?>
																<tr>
																	<td class="no_urut"><?= $data['no'] ?></td>
																	<td nowrap>
																		<a href="<?= site_url("sid_core/sub_dusun/$data[id]") ?>" class="btn bg-purple btn-box btn-sm" title="Rincian Wilayah Kecamatan"><i class="fa fa-search"></i> Detail</a>
																		<?php if ($this->CI->cek_hak_akses('h')) : ?>
																			<a href="<?= site_url("sid_core/form_desa/$data[id]") ?>" class="btn bg-orange btn-box btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
																			<a href="#" data-href="<?= site_url("sid_core/delete/dusun/$data[id]") ?>" class="btn bg-maroon btn-box btn-sm" title="Hapus" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>
																			<a href="<?= site_url("sid_core/ajax_kantor_dusun_maps_google/$data[id]") ?>" class="btn btn-info btn-box btn-sm" title="Lokasi Kantor"><i class="fa fa-map-marker"></i></a>
																			<a href="<?= site_url("sid_core/ajax_wilayah_dusun_maps_google/$data[id]") ?>" class="btn btn-primary btn-box btn-sm" title="Peta Google"><i class="fa fa-google"></i></a>
																			<a href="<?= site_url("sid_core/ajax_wilayah_dusun_openstreet_maps/$data[id]") ?>" class="btn btn-info btn-box btn-sm" title="Peta Openstreet"><i class="fa fa-map-o"></i></a>
																		<?php endif; ?>
																	</td>
																	<td><?= strtoupper($data['desa']) ?></td>
																	<td nowrap><strong><?= strtoupper($data['nama_kades']) ?></strong> - <?= $data['nik_kades'] ?></td>
																	<td class="bilangan"><a href="<?= site_url("sid_core/sub_dusun/$data[id]") ?>" title="Rincian Wilayah Dusun"><?= $data['jumlah_dusun'] ?></a></td>
																	<td class="bilangan"><a href="<?= site_url("sid_core/sub_rw/$data[id]") ?>" title="Rincian Sub Wilayah RW"><?= $data['jumlah_rw'] ?></a></td>
																	<td class="bilangan"><?= $data['jumlah_rt'] ?></td>
																	<td class="bilangan"><a href="<?= site_url("sid_core/warga_kk/$data[id]") ?>"><?= $data['jumlah_kk'] ?></a></td>
																	<td class="bilangan"><a href="<?= site_url("sid_core/warga/$data[id]") ?>"><?= $data['jumlah_warga'] ?></a></td>
																	<td class="bilangan"><a href="<?= site_url("sid_core/warga_l/$data[id]") ?>"><?= $data['jumlah_warga_l'] ?></a></td>
																	<td class="bilangan"><a href="<?= site_url("sid_core/warga_p/$data[id]") ?>"><?= $data['jumlah_warga_p'] ?></a></td>
																</tr>
															<?php
																$total['total_dusun'] += $data['total_dusun'];
																$total['total_rw'] += $data['jumlah_rw'];
																$total['total_rt'] += $data['jumlah_rt'];
																$total['total_kk'] += $data['jumlah_kk'];
																$total['total_warga'] += $data['jumlah_warga'];
																$total['total_warga_l'] += $data['jumlah_warga_l'];
																$total['total_warga_p'] += $data['jumlah_warga_p'];
															endforeach;
															?>
														</tbody>
														<tfoot>
															<tr>
																<th colspan="4"><label>TOTAL</label></th>
																<th class="bilangan"><?= $total['total_dusun'] ?></th>
																<th class="bilangan"><?= $total['total_rw'] ?></th>
																<th class="bilangan"><?= $total['total_rt'] ?></th>
																<th class="bilangan"><?= $total['total_kk'] ?></th>
																<th class="bilangan"><?= $total['total_warga'] ?></th>
																<th class="bilangan"><?= $total['total_warga_l'] ?></th>
																<th class="bilangan"><?= $total['total_warga_p'] ?></th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php $this->load->view('global/confirm_delete'); ?>