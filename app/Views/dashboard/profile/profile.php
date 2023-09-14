<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<?= $this->section('header'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?= $this->endSection(); ?>

<!-- menambahkan section -->
<?= $this->section('content'); ?>
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            text: '<?= session()->getFlashdata('success') ?>',
            showConfirmButton: false,
            timer: 2000
        })
    </script>
<?php endif ?>
<?php if (session()->getFlashdata('error')) : ?>
    <script>
        Swal.fire({
            position: 'center',
            icon: 'error',
            text: '<?= session()->getFlashdata('error') ?>',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class=" font-weight-bold text-primary">Profile</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= base_url('dashboard/profile/update') ?>" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <div class="form-group">
                    <label for="formGroupExampleInput">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" placeholder=" Masukan Nama Konsumen" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Email</label>
                    <input type="email" name="email" placeholder="Email" class="form-control formatted-input" value="<?= $data['email'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Password Baru</label>
                    <input type="password" name="password1" placeholder="Password Baru" class="form-control formatted-input" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Konfirmasi Password Baru</label>
                    <input type="password" name="password2" placeholder="Konfirmasi Password Baru" class="form-control formatted-input" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<!-- menambahkan script -->
<?= $this->section('custom-js'); ?>
<?= $this->endSection(); ?>