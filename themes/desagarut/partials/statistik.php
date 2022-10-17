<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$penduduk = $this->db->query('SELECT COUNT(id) AS jumlah FROM tweb_penduduk WHERE status_dasar = 1')->result_array()[0]['jumlah'];
$keluarga = $this->db->query('SELECT COUNT(id) AS jumlah FROM tweb_keluarga')->result_array()[0]['jumlah'];
$rtm = $this->db->query('SELECT COUNT(id) AS jumlah FROM tweb_rtm')->result_array()[0]['jumlah'];
$id = $this->db->query('SELECT COUNT(id) AS jumlah FROM log_surat')->result_array()[0]['jumlah'];
$kecamatan = $this->db->query('SELECT COUNT(id) AS jumlah FROM tweb_wilayah WHERE kecamatan <> "-" AND kecamatan <> "0" AND desa = 0 AND dusun = "0" AND rw = "0" AND rt = "0"')->result_array()[0]['jumlah'];
$desa = $this->db->query('SELECT COUNT(id) AS jumlah FROM tweb_wilayah WHERE kecamatan <> "-" AND kecamatan <> "0" AND desa <> "-" AND desa <> "0" AND dusun = "0" AND rw = "0" AND rt = "0"')->result_array()[0]['jumlah'];
$dusun = $this->db->query('SELECT COUNT(id) AS jumlah FROM tweb_wilayah WHERE kecamatan <> "-" AND kecamatan <> "0" AND desa <> "-" AND desa <> "0" AND dusun <> "-" AND dusun <> "0"  AND rw = "0" AND rt = "0"')->result_array()[0]['jumlah'];
$rw = $this->db->query('SELECT COUNT(id) AS jumlah FROM tweb_wilayah WHERE kecamatan <> "-" AND kecamatan <> "0" AND desa <> "-" AND desa <> "0" AND dusun <> "-" AND dusun <> "0"  AND rw <> "-" AND rw <> "0" AND rt = "0"')->result_array()[0]['jumlah'];
$rt = $this->db->query('SELECT COUNT(id) AS jumlah FROM tweb_wilayah WHERE kecamatan <> "-" AND kecamatan <> "0" AND desa <> "-" AND desa <> "0" AND dusun <> "-" AND dusun <> "0"  AND rw <> "-" AND rw <> "0" AND rt <> "-" AND rt <> "0"')->result_array()[0]['jumlah'];
?>

    <!-- Facts Start -->
    <div class="container-fluid facts py-5 pt-lg-0 sm-none xs-none">
        <div class="container py-5 pt-lg-0">
            <div class="row gx-0">
                <div class="col-lg-2 wow zoomIn" data-wow-delay="0.6s">
                    <div class="bg-primary shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                        <div class="bg-white d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                            <i class="fa fa-users text-primary"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-white mb-0">Kec.</h5>
                            <h1 class="text-white mb-0" data-toggle="counter-up"><?= number_format($kecamatan,0,'', '.')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 wow zoomIn" data-wow-delay="0.3s">
                    <div class="bg-light shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                        <div class="bg-primary d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                            <i class="fa fa-check text-white"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-primary mb-0">Desa</h5>
                            <h1 class="mb-0" data-toggle="counter-up"><?= number_format($desa,0,'', '.')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 wow zoomIn" data-wow-delay="0.1s">
                    <div class="bg-primary shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                        <div class="bg-white d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                            <i class="fa fa-award text-primary"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-white mb-0">Dusun</h5>
                            <h1 class="text-white mb-0" data-toggle="counter-up"><?= number_format($dusun,0,'', '.')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 wow zoomIn" data-wow-delay="0.1s">
                    <div class="bg-light shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                        <div class="bg-primary d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                            <i class="fa fa-check text-white"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-primary mb-0">RW</h5>
                            <h1 class="mb-0" data-toggle="counter-up"><?= number_format($rw,0,'', '.')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 wow zoomIn" data-wow-delay="0.3s">
                    <div class="bg-primary shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                        <div class="bg-white d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                            <i class="fa fa-users text-primary"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-white mb-0">RT</h5>
                            <h1 class="text-white mb-0" data-toggle="counter-up"><?= number_format($rt,0,'', '.')?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 wow zoomIn" data-wow-delay="0.6s">
                    <div class="bg-light shadow d-flex align-items-center justify-content-center p-4" style="height: 150px;">
                        <div class="bg-primary d-flex align-items-center justify-content-center rounded mb-2" style="width: 60px; height: 60px;">
                            <i class="fa fa-check text-white"></i>
                        </div>
                        <div class="ps-4">
                            <h5 class="text-primary mb-0">RTM</h5>
                            <h1 class="mb-0" data-toggle="counter-up"><?= number_format($rtm,0,'', '.')?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Facts Start -->
