<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Data Penerima Vaksin Covid-19</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link href="<?= base_url()?>assets/css/report.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			.textx
			{
				mso-number-format:"\@";
			}
		</style>
	</head>
	<body>
		<div id="body">
			<table>
				<tbody>
					<tr>
						<td align="center">
							<?php if ($aksi != 'unduh'): ?>
								<img src="<?= gambar_kabupaten($config['logo']);?>" alt="" style="width:100px; height:auto">
							<?php endif; ?>
							<h1>PEMERINTAH <?= strtoupper($this->setting->sebutan_kabupaten)?> <?= strtoupper($config['nama_kabupaten'])?> </h1>
							<h1 style="text-transform: uppercase;"></h1>
							<h1><?= strtoupper($this->setting->sebutan_kecamatan)?> <?= strtoupper($config['nama_kecamatan'])?> </h1>
							<h1><?= strtoupper($this->setting->sebutan_desa)." ".strtoupper($config['nama_desa'])?></h1>
						</td>
					</tr>
					<tr>
						<td style="padding: 5px 20px;">
							<hr style="border-bottom: 2px solid #000000; height:0px;">
						</td>
					</tr>
					<tr>
						<td align="center" >
							<h3><u>DATA PENERIMA VAKSIN COVID-19</u></h3>
						</td>
					</tr>
					<tr>
						<td style="padding: 5px 20px;">
							<strong>Sasaran: </strong>Penduduk<br>
						</td>
					</tr>
					<tr>
						<td style="padding: 5px 20px;">
							<table class="border thick">
								<thead>
									<tr class="border thick">
										<th>No</th>
										<th>NIK</th>
										<th>Nama</th>
										<th>Tempat Lahir</th>
										<th>Tanggal Lahir</th>
										<th>Jenis Kelamin</th>
										<th>Alamat</th>
										<th>Tanggal Vaksin</th>
										<th>Jenis Vaksin</th>
										<th>Dosis 1</th>
										<th>Dosis 2</th>
										<th>No HP</th>
										<th>Email</th>
										<th>KIPI</th>
										<th>Keterangan</th>
										<th>Wajib Pantau</th>
									</tr>
								</thead>
								<tbody>
									<?php	$i=1;	foreach ($peserta_vaksin_list as $key=>$item): ?>
										<tr>
											<td><?= $i?></td>
											<td class='textx'><?= $item["terdata_nama"]?></td>
											<td><?= $item["terdata_info"]?></td>
											<td><?= $item["tempat_lahir"] ?></td>
											<td><?= $item["tanggal_lahir"] ?></td>
											<td><?= $item["sex"] ?></td>
											<td><?= $item["info"]?></td>
											<td><?= $item["tanggal"]?></td>
											<td><?= $item["jenis_vaksin"]?></td>
											<td><?= $item["dosis1"]?></td>
											<td><?= $item["dosis2"]?></td>
											<td><?= $item["no_hp"]?></td>
											<td><?= $item["email"]?></td>
											<td><?= $item["kipi"]?></td>
											<td><?= $item["keterangan"]?></td>
											<td><?= ($item["is_wajib_pantau"] === '1' ? "Ya" : "Tidak"); ?></td>
										</tr>
									<?php $i++;	endforeach;	?>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
</html>

