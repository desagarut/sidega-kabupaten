<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- ======= About Us Section ======= -->
    <section id="about-us" class="about-us">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Mengenal <?= ucfirst($this->setting->sebutan_desa).' '.ucwords($kabupaten['nama_desa']) ?></strong></h2>
          <p><i>kenali kami lebih dekat</i></p>
        </div>

        <div class="row">
          <div class="col-lg-12" data-aos="fade-right"><br/>
			<?php $this->load->view($folder_themes .'/widgets/map_tentang') ?>
          </div>
          <div class="col-lg-12" data-aos="fade-left"><br/>
            <p class="icon-box">
              <?= ucfirst($this->setting->sebutan_desa).' '.ucwords($kabupaten['nama_desa']) ?> adalah salah satu <?= ucfirst($this->setting->sebutan_desa);?> yang terletak di <?= ucwords($this->setting->sebutan_kecamatan." ".$kabupaten['nama_kecamatan'])?> <?= ucwords($this->setting->sebutan_kabupaten." ".$kabupaten['nama_kabupaten'])?> Provinsi <?= ucwords($this->setting->sebutan_propinsi." ".$kabupaten['nama_propinsi'])?>, Dengan Batas Wilayah:
            </p>
            <ul>
              <li><i class="ri-check-double-line"></i> Di Utara berbatasan dengan <?= ucwords($kabupaten['batas_utara']) ?></li>
              <li><i class="ri-check-double-line"></i> Di Selatan berbatasan dengan <?= ucwords($kabupaten['batas_selatan']) ?></li>
              <li><i class="ri-check-double-line"></i> Di Timur berbatasan dengan <?= ucwords($kabupaten['batas_timur']) ?></li>
              <li><i class="ri-check-double-line"></i> Di Barat berbatasan dengan <?= ucwords($kabupaten['batas_barat']) ?></li>
            </ul>
            <p class="font-italic">
              <?= ucwords($this->setting->profil_singkat." ".$kabupaten['profil_singkat'])?>
            </p>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->
