<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view($folder_themes . '/commons/head') ?>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1823410826720847" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Spinner Start -->
    <!--<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner"></div>
    </div>
    <!-- Spinner End -->
    <?php $this->load->view($folder_themes . '/commons/topbar') ?>
    <?php $this->load->view($folder_themes . '/commons/navbar') ?>


    <?php $this->load->view($folder_themes . '/layouts/home.tpl.php') ?>
    <?php $this->load->view($folder_themes . '/commons/footer') ?>
</body>

</html>