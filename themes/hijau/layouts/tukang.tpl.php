<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view($folder_themes . '/commons/meta') ?>
<?php $this->load->view($folder_themes . '/commons/for_css') ?>
</head>
<body>
<?php $this->load->view($folder_themes .'/commons/header') ?>
<section id="breadcrumbs2" class="breadcrumbs2">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h5>Tukang Warga</h5>
      <ol>
        <li><a href="<?= site_url("first"); ?>">Beranda</a></li>
        <li><a href="<?= site_url("first/tukang"); ?>">Tukang Warga</a></li>
      </ol>
    </div>
  </div>
</section>
<!-- End Breadcrumbs -->

<section id="team" class="team section-bg" style="padding-top:60px">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 entries">
        <?php $this->load->view($folder_themes . '/partials/tukang/index.php') ?>
      </div>
      <?php // $this->load->view($folder_themes .'/partials/sidebar.php') ?>
    </div>
  </div>
</section>
<?php $this->load->view($folder_themes .'/commons/footer_min') ?>
<?php $this->load->view($folder_themes . '/commons/for_js') ?>
</body>
</html>