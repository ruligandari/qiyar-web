<?= $this->extend('mobile/layouts'); ?>

<?= $this->section('content'); ?>
<!-- Login Wrapper Area -->
<div class="login-wrapper d-flex align-items-center justify-content-center">
    <?php if (session()->getFlashdata('gagal')): ?>
        <div class="toast toast-autohide custom-toast-1 toast-warning home-page-toast" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="7000" data-bs-autohide="true">
            <div class="toast-body">
                <i class="bi bi-exclamation-circle-fill text-white h1 mb-0"></i>
                <div class="toast-text ms-3 me-2">
                    <p class="mb-0 text-white"><?= session()->getFlashdata('gagal') ?></p>
                </div>
            </div>

            <button class="btn btn-close btn-close-white position-absolute p-1" type="button" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="custom-container">
        <div class="text-center px-4">
            <h4 class="mb-3 text-center">Stok Opname Qiyarmedia</h4>
            <img class="login-intro-img" src="<?= base_url('mobile/') ?>img/bg-img/36.png" alt="">
        </div>

        <!-- Register Form -->
        <div class="register-form mt-4">
            <h6 class="mb-3 text-center">Log in untuk melanjutkan</h6>

            <form action="<?= base_url('m/auth') ?>" method="POST">
                <div class="form-group">
                    <input class="form-control" type="email" id="username" placeholder="Masukan Email" name="email">
                </div>

                <div class="form-group position-relative">
                    <input class="form-control" id="psw-input" type="password" placeholder="Masukan Password" name="password">
                    <div class="position-absolute" id="password-visibility">
                        <i class="bi bi-eye"></i>
                        <i class="bi bi-eye-slash"></i>
                    </div>
                </div>

                <button class="btn btn-primary w-100" type="submit">Sign In</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>