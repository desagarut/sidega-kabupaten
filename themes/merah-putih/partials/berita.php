<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

    <!-- Project Start -->

    
    <div class="container-xxl py-5">
        <div class="container">
 <!--           <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-danger px-3">Our Projects</h6>
                <h1 class="display-6 mb-4">Learn More About Our Complete Projects</h1>
            </div>-->
            <div class="owl-carousel project-carousel wow fadeInUp" data-wow-delay="0.1s">
            
            
      <?php if($artikel) : ?>
      <?php foreach($artikel as $article) : ?>
      <?php $data['article'] = $article ?>
      <?php $url = site_url('artikel/'.buat_slug($article)) ?>
      <?php $abstract = potong_teks(strip_tags($article['isi']), 200) ?>
      <?php $image = ($article['gambar'] && is_file(LOKASI_FOTO_ARTIKEL.'sedang_'.$article['gambar'])) ? 
                        AmbilFotoArtikel($article['gambar'],'sedang') : 
						base_url($this->theme_folder.'/'.$this->theme .'/assets/img/placeholder.png');?>
                <div class="project-item border rounded h-100 p-4" data-dot="">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded" src="<?= $image ?>" alt="">
                        <a href="<?= $image ?>" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                    <h6><?= $article['judul'] ?></h6>
                    <span><?= $article['judul'] ?></span>
                    <span>
                    	<small>
						<?= tgl_indo($article['tgl_upload']) ?><br/>
                    	<?= $article['owner'] ?>
                        </small>
                    </span>
                </div>
                
      <?php endforeach ?>
      <?php endif ?>
      <?php //$this->load->view($folder_themes .'/commons/paging') ?>
                
                
            </div>
        </div>
    </div>
    <!-- Project End -->

