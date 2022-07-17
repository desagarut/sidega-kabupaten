<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image" style="padding-top: 10px;">
				<img src="<?= gambar_kabupaten($kabupaten['logo']); ?>" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info" style="padding-top: 10px;">
				<strong style="font-size:15px"><?= ucwords($this->setting->sebutan_kabupaten . " " . $kabupaten['nama_kabupaten']); ?></strong>
				<br/>Provinsi Jawa Barat
				<br style="color:bisque"/>Login as  <?=$nama?>
				</br>
            </div>		
        </div>

		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">MENU</li>
			<?php foreach ($modul AS $mod): ?>
				<?php if ($this->CI->cek_hak_akses('b', $mod['url'])): ?>
					<?php if (count($mod['submodul'])==0): ?>
						<li class="<?= jecho($this->modul_ini, $mod['id'], 'active'); ?>">
							<a href="<?= site_url("$mod[url]"); ?>">
								<i class="fa <?= $mod['ikon']; ?> <?= jecho($this->modul_ini, $mod['id'], 'text-aqua'); ?>"></i><span><?= $mod['modul']; ?></span>
								<span class="pull-right-container"></span>
							</a>
						</li>
					<?php else : ?>
						<li class="treeview <?= jecho($this->modul_ini, $mod['id'], 'active'); ?>">
							<a href="<?= site_url("$mod[url]"); ?>">
								<i class="fa <?= $mod['ikon']; ?> <?= jecho($this->modul_ini, $mod['id'], 'text-aqua'); ?>"></i><span><?= $mod['modul']; ?></span>
								<span class="pull-right-container"><i class='fa fa-angle-left pull-right'></i></span>
							</a>
							<ul class="treeview-menu <?= jecho($this->modul_ini, $mod['id'], 'active'); ?>">
								<?php foreach ($mod['submodul'] as $submod): ?>
									<li class="<?= jecho($this->sub_modul_ini, $submod['id'], 'active'); ?>">
										<a href="<?= site_url("$submod[url]"); ?>">
											<i class="fa <?= ($submod['ikon'] != NULL) ? $submod['ikon'] : 'fa-circle-o'; ?> <?= jecho($this->sub_modul_ini, $submod['id'], 'text-red'); ?>"></i>
											<?= $submod['modul']; ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</section>
</aside>

