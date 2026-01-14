<?= $this->extend('mobile/layouts'); ?>

<?= $this->section('content'); ?>

<!-- sweetalert -->

<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>',
        })
    </script>
<?php elseif (session()->getFlashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= session()->getFlashdata('error') ?>',
            showConfirmButton: false,
        })
    </script>
<?php endif; ?>
<!-- Header Area -->
<div class="header-area" id="headerArea">
    <div class="container">
        <!-- Header Content -->
        <div class="header-content position-relative d-flex align-items-center justify-content-between">
            <!-- Back Button -->
            <div class="back-button">
                <a href="<?= base_url('/stok-opname') ?>">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>

            <!-- Page Title -->
            <div class="page-heading">
                <h6 class="mb-0"><?= $title ?></h6>
            </div>
            <div class="setting-wrapper">
            </div>
        </div>
    </div>
</div>
<div class="page-content-wrapper py-3">
    <div class="container">
        <!-- User Information-->
        <div class="card user-info-card mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="user-info">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-1"><?= session()->get('nama') ?></h5>
                    </div>
                    <p class="mb-0"><?= session()->get('email') ?></p>
                </div>
            </div>
        </div>

        <!-- User Meta Data-->
        <div class="card user-data-card">
            <div class="card-body">
                <form action="<?= base_url('stok-opname/profile/update') ?>" method="POST">

                    <div class="form-group mb-3">
                        <label class="form-label" for="fullname">Nama</label>
                        <input class="form-control" id="fullname" type="text" value="<?= session()->get('nama') ?>" name="nama">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="email">Alamat Email</label>
                        <input class="form-control" id="email" type="text" value="<?= session()->get('email') ?>" name="email">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="job">Password Baru</label>
                        <input class="form-control" id="job" type="password" placeholder="********" name="password_1">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="portfolio">Konfirmasi Password Baru</label>
                        <input class="form-control" id="portfolio" type="password" name="password_2"
                            placeholder="********">
                    </div>

                    <button class="btn btn-success w-100" type="submit">Update</button>
                </form>
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