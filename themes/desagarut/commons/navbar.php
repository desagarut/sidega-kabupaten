<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Navbar & Carousel Start -->
<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
        <a href="<?= site_url('first') ?>" class="navbar-brand p-0">
            <h1 class="m-0"><img src="<?= gambar_kabupaten($kabupaten['logo']) ?>" alt="<?= ucfirst($this->setting->website_title) ?>" width="60px" height="60px">
                <?= ucfirst($this->setting->website_title) ?></h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="<?= site_url('first') ?>" class="nav-item nav-link active">Home</a>
                <?php if (menu_atas) : ?>
                    <?php foreach ($menu_atas as $menu) : ?>
                        <div class="nav-item dropdown">
                            <a href="<?= $menu['link'] ?>" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><?= $menu['nama'] ?>
                                <?php if (count($menu['submenu']) > 0) : ?>
                                <?php endif ?></a>

                            <?php if (count($menu['submenu']) > 0) : ?>
                                <div class="dropdown-menu m-0">
                                    <?php foreach ($menu['submenu'] as $submenu) : ?>
                                        <a href="<?= $submenu['link'] ?>" class="dropdown-item"><?= $submenu['nama'] ?></a>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>
    </nav>
</div>
<!-- Navbar & Carousel End -->