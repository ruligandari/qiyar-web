<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Stok Opname Gudang">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Title -->
    <title><?= $title ?></title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('mobile') ?>/img/core-img/favicon.ico">
    <link rel="apple-touch-icon" href="<?= base_url('mobile') ?>/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('mobile') ?>/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="<?= base_url('mobile') ?>/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('mobile') ?>/img/icons/icon-180x180.png">
    <!-- cdn js -->

    <!-- Style CSS -->
    <link rel="stylesheet" href="<?= base_url('mobile') ?>/style.css">

    <!-- Web App Manifest -->
    <link rel="manifest" href="<?= base_url('mobile') ?>/manifest.json">
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    <?= $this->renderSection('content'); ?>
    <!-- All JavaScript Files -->
    <script src="<?= base_url('mobile') ?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('mobile') ?>/js/slideToggle.min.js"></script>
    <script src="<?= base_url('mobile') ?>/js/internet-status.js"></script>
    <script src="<?= base_url('mobile') ?>/js/tiny-slider.js"></script>
    <script src="<?= base_url('mobile') ?>/js/venobox.min.js"></script>
    <script src="<?= base_url('mobile') ?>/js/countdown.js"></script>
    <script src="<?= base_url('mobile') ?>/js/rangeslider.min.js"></script>
    <script src="<?= base_url('mobile') ?>/js/vanilla-dataTables.min.js"></script>
    <script src="<?= base_url('mobile') ?>/js/index.js"></script>
    <script src="<?= base_url('mobile') ?>/js/imagesloaded.pkgd.min.js"></script>
    <script src="<?= base_url('mobile') ?>/js/isotope.pkgd.min.js"></script>
    <script src="<?= base_url('mobile') ?>/js/dark-rtl.js"></script>
    <script src="<?= base_url('mobile') ?>/js/active.js"></script>
    <script src="<?= base_url('mobile') ?>/js/pwa.js"></script>
    <script src="<?= base_url('mobile') ?>/js/service-worker.js"></script>

    <!-- render script -->
    <?= $this->renderSection('script'); ?>
</body>

</html>