<?= $this->extend('mobile/layouts'); ?>

<?= $this->section('content'); ?>

<!-- Header Area -->
<div class="header-area" id="headerArea">
    <div class="container">

        <!-- # Header Five Layout -->
        <!-- Header Content -->
        <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
            <!-- Logo Wrapper -->
            <div class="logo-wrapper">
                <a href="<?= base_url('stok-opname') ?>">
                    <img src="<?= base_url('mobile') ?>/img/core-img/logo-2.png" alt="">
                </a>
            </div>

            <!-- Navbar Toggler -->
            <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas" data-bs-target="#affanOffcanvas"
                aria-controls="affanOffcanvas">
                <span class="d-block"></span>
                <span class="d-block"></span>
                <span class="d-block"></span>
            </div>
        </div>
        <!-- # Header Five Layout End -->

    </div>
</div>
<!-- Offcanvas Start -->
<div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1"
    aria-labelledby="affanOffcanvsLabel">

    <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas"
        aria-label="Close"></button>

    <div class="offcanvas-body p-0">
        <div class="sidenav-wrapper">
            <!-- Sidenav Profile -->
            <div class="sidenav-profile bg-gradient">
                <div class="sidenav-style1"></div>

                <!-- User Thumbnail -->

                <!-- User Info -->
                <div class="user-info">
                    <h6 class="user-name mb-0"><?= session()->get('nama') ?></h6>
                    <span><?= session()->get('email') ?></span>
                </div>
            </div>

            <!-- Sidenav Nav -->
            <ul class="sidenav-nav ps-0">
                <li>
                    <a href="<?= base_url('stok-opname/profile') ?>"><i class="bi bi-person"></i> Profile</a>
                </li>
                <li>
                    <div class="night-mode-nav">
                        <i class="bi bi-moon"></i> Night Mode
                        <div class="form-check form-switch">
                            <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
                        </div>
                    </div>
                </li>
                <li>
                    <a onclick="logout()"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </li>
            </ul>

            <!-- Social Info -->

            <!-- Copyright Info -->
            <div class="copyright-info">
                <p>
                    <span id="copyrightYear"></span>
                    &copy; Made by <a href="#">CV Qiyarmedia</a>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="page-content-wrapper py-3">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="toast toast-autohide custom-toast-1 toast-success home-page-toast" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="7000" data-bs-autohide="true">
            <div class="toast-body">
                <i class="bi bi-bookmark-check text-white h1 mb-0"></i>
                <div class="toast-text ms-3 me-2">
                    <p class="mb-0 text-white"><?= session()->getFlashdata('success') ?></p>
                </div>
            </div>

            <button class="btn btn-close btn-close-white position-absolute p-1" type="button" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <!-- Tiny Slider One Wrapper -->
    <div class="container">
        <div class="card card-bg-img bg-img bg-success mb-3">
            <div class="card-body p-3">
                <p class="text-white mb-0">Selamat Datang, Di Aplikasi Stok Opname Qiyarmedia</p>
            </div>
        </div>
    </div>
    <div class="container direction-rtl">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-1">
                    <div class="col-4">
                        <div class="feature-card mx-auto text-center">
                            <div class="card mx-auto bg-gray">
                                <!-- image link -->
                                <a href="<?= base_url('stok-opname/master-barang/') ?>">
                                    <img src="<?= base_url('mobile') ?>/assets/technical-support.png" alt="">
                                </a>
                            </div>
                            <p class="mb-0">Master Barang</p>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="feature-card mx-auto text-center">
                            <div class="card mx-auto bg-gray">
                                <!-- image link -->
                                <a href="<?= base_url('stok-opname/barang-masuk') ?>">
                                    <img src="<?= base_url('mobile') ?>/assets/barangmasuk.png" alt="">
                                </a>
                            </div>
                            <p class="mb-0">Barang Masuk</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="feature-card mx-auto text-center">
                            <div class="card mx-auto bg-gray">
                                <!-- image link -->
                                <a href="<?= base_url('stok-opname/barang-keluar') ?>">
                                    <img src="<?= base_url('mobile') ?>/assets/barangkeluar.png" alt="">
                                </a>
                            </div>
                            <p class="mb-0">Barang Keluar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-3"></div>
</div>

<!-- Footer Nav -->
<!-- <div class="footer-nav-area" id="footerNav">
    <div class="container px-0">
        <div class="footer-nav position-relative shadow-sm footer-style-two">
            <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                <li>
                    <a href="<?= base_url('/') ?>">
                        <i class="bi bi-house"></i>
                    </a>
                </li>

                <li class="active">
                    <a href="#">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('/profile') ?>">
                        <i class="bi bi-person"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div> -->

<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function logout() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda Akan Keluar Dari Aplikasi Ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('m/logout') ?>',
                    type: 'POST',
                    success: function() {
                        location.href = '<?= base_url('m/login') ?>';
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Data gagal dihapus.',
                            'error'
                        )
                    }
                })
            }
        })

    }
</script>

<?= $this->endsection(); ?>