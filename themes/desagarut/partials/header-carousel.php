<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="w-100" src="<?= base_url("$this->theme_folder/$this->theme/assets/img/sidega-001.jpg") ?>" alt="Image">
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div class="p-3" style="max-width: 900px;">
                    <h4 class="text-white text-uppercase mb-2 animated slideInDown">Selamat Datang di</h4>
                    <h1 class="text-white text-uppercase mb-3 animated slideInDown"><?= ucfirst($this->setting->website_title) ?></h1>
                    <a href="https://demo.desagarut.id" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Demo Aplikasi</a>
                    <a href="" class="btn btn-outline-light py-md-3 px-md-5 animated slideInRight">Contact Us</a>
                </div>
            </div>
        </div>

        <?php foreach ($slider_gambar['gambar'] as $gambar) : ?>
            <?php $file_gambar = $slider_gambar['lokasi'] . 'sedang_' . $gambar['gambar']; ?>
            <?php if (is_file($file_gambar)) : ?>

                <div class="carousel-item">
                    <img class="w-100" src="<?php echo base_url() . $slider_gambar['lokasi'] . 'sedang_' . $gambar['gambar'] ?>" alt="<?= $gambar['judul'] ?>">

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h3 class="text-white text-uppercase mb-3 animated slideInDown"><?= $gambar['kategori'] ?></h3>
                            <h1 class="text-white text-uppercase mb-3 animated slideInDown"><?= $gambar['judul'] ?></h1>
                            <a href="<?= 'artikel/' . buat_slug($gambar); ?>" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Baca</a>
                            <a href="<?= site_url('arsip') ?>" class="btn btn-outline-light py-md-3 px-md-5 animated slideInRight">Semua Berita</a>
                        </div>
                    </div>
                </div>
                <?php $active = false; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>