<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<script>
	$(function() {
		var keyword = <?= $keyword; ?> ;
		$("#cari").autocomplete( {
			source: keyword,
			maxShowItems: 10,
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Kategori Kelompok</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('beranda'); ?>"><i class="fa fa-home"></i> Beranda</a></li>
			<li><a href="<?= site_url('kelompok'); ?>"> Daftar Kelompok</a></li>
			<li class="active">Kategori Kelompok</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="mainform" name="mainform" action="" method="post">
			<div class="box box-info">
				<div class="box-header with-border">
                <?php if ($this->CI->cek_hak_akses('h')): ?>
					<a href="<?= site_url('kelompok_master/form'); ?>" title="Tambah Kategori Kelompok Baru" class="btn btn-social btn-box bg-olive btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i class="fa fa-plus"></i> Tambah Kategori Kelompok Baru</a>
					<a href="#confirm-delete" title="Hapus Data" onclick="deleteAllBox('mainform','<?= site_url('kelompok_master/delete_all'); ?>')" class="btn btn-social btn-box	btn-danger btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block hapus-terpilih"><i class='fa fa-trash-o'></i> Hapus Data Terpilih</a>
				<?php endif; ?>
                	<a href="<?= site_url('kelompok'); ?>" class="btn btn-social btn-box btn-info btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i class="fa fa-arrow-circle-left"></i> Kembali Ke Daftar Kelompok</a>
				</div>
				<div class="box-body">
					<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
						<form id="mainform" name="mainform" action="" method="post">
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group input-group-sm pull-right">
										<input name="cari" id="cari" class="form-control" placeholder="Cari..." type="text" value="<?= html_escape($cari); ?>" onkeypress="if (event.keyCode == 13){$('#'+'mainform').attr('action', '<?= site_url("kelompok_master/filter/cari")?>');$('#'+'mainform').submit();}">
										<div class="input-group-btn">
											<button type="submit" class="btn btn-default" onclick="$('#'+'mainform').attr('action', '<?= site_url("kelompok_master/filter/cari")?>');$('#'+'mainform').submit();"><i class="fa fa-search"></i></button>
										</div>
									</div>
								</div>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered dataTable table-striped table-hover tabel-daftar">
									<thead class="bg-gray disabled color-palette">
										<tr>
											<th><input type="checkbox" id="checkall"/></th>
											<th>No</th>
											<?php if ($this->CI->cek_hak_akses('h')): ?>
                                            <th>Aksi</th>
											<? endif;?>
                                            <th><?= url_order($o, "{$this->controller}/{$func}/$p", 1, 'Kategori Kelompok'); ?></th>
											<th width="70%">Deskripsi Kelompok</th>
										</tr>
									</thead>
									<tbody>
										<?php if ($main): ?>
											<?php foreach ($main as $key => $data): ?>
												<tr>
													<td class="padat"><input type="checkbox" name="id_cb[]" value="<?= $data['id']?>" ></td>
													<td class="padat"><?= ($key + $paging->offset + 1); ?></td>
													<?php if ($this->CI->cek_hak_akses('h')): ?>
                                                    <td class="aksi">
														<a href="<?= site_url("kelompok_master/form/$data[id]")?>" class="btn bg-orange btn-box btn-sm" title="Ubah Kategori kelompok"><i class="fa fa-edit"></i></a>
														<a href="#" data-href="<?= site_url("kelompok_master/delete/$data[id]")?>" class="btn bg-maroon btn-box btn-sm" title="Hapus Data" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>
													</td>
                                                    <?php endif;?>
													<td nowrap><?= $data['kelompok']?></td>
													<td><?= $data['deskripsi']?></td>
												</tr>
											<?php endforeach; ?>
										<?php else: ?>
											<tr>
												<td class="text-center" colspan="5">Data Tidak Tersedia</td>
											</tr>
										<?php endif; ?>
									</tbody>
									</tbody>
								</table>
							</div>
						</form>
						<?php $this->load->view('global/paging');?>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
<?php $this->load->view('global/confirm_delete'); ?>
