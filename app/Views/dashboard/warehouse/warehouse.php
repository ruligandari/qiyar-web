<?= $this->extend('template/template'); ?>

<?= $this->section('content'); ?>
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            text: 'Data berhasil diupdate!',
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
        <h1 class="h3 mb-0 text-gray-800">Data Advertiser</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h6 class=" font-weight-bold text-primary">Data Warehouse</h6>
                    <?php if (session()->get('role') == '1') : ?>
                        <a href="<?= base_url('dashboard/tambah-data-advertiser') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table border="0" cellspacing="5" cellpadding="5">
                    <tbody>
                        <tr>
                            <td>Dari :</td>
                            <td><input type="text" id="min" name="min"></td>
                        </tr>
                        <tr>
                            <td>Sampai :</td>
                            <td><input type="text" id="max" name="max"></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>1</td>
                            <td>Kalung Milano</td>
                            <td>1000</td>
                            <td class="text-center"> ini aksi</td>
                        </tr>

                    </tbody>
                    <tfoot>
                        <tr>
                            <?php if (session()->get('role') == '1') : ?>
                                <td colspan="3"></td>
                                <td><b>Total</b></td>
                                <td id="totalSum"></td>
                            <?php endif; ?>
                            <?php if (session()->get('role') == '3') : ?>
                                <td colspan="2"></td>
                                <td><b>Total</b></td>
                                <td id="totalSum"></td>
                            <?php endif; ?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>