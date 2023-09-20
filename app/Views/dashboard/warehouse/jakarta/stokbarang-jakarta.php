<?= $this->extend('template/template'); ?>

<?= $this->section('header'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css" type="text/css">

<?= $this->endSection(); ?>

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
        <h1 class="h3 mb-0 text-gray-800">Data Tambah Stok Warehouse Jakarta</h1>
    </div>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="">
                        <div class="row">
                            <div class="col-xl-6">
                                <h6 class=" font-weight-bold text-primary">Data Tambah Stok</h6>
                            </div>
                            <?php if (in_array(session()->get('role'), ['2', '3', '7'])) : ?>
                                <div class="col-xl-6 d-flex justify-content-end">
                                    <a href="<?= base_url('dashboard/warehouse-jakarta/stok/tambah') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Stok Produk</a>
                                </div>
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
                        <table class="table table-sm table-bordered" id="table-stok" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Jenis Barang Masuk</th>
                                    <th>Bukti Upload</th>
                                    <?php if (in_array(session()->get('role'), ['2', '3', '7'])) : ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($stok as $data) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $data['tanggal'] ?></td>
                                        <td><?= $data['nama_barang'] ?></td>
                                        <td><?= number_format($data['qty'], 0, ',', '.') ?></td>
                                        <td><?= $data['jenis_barang_masuk'] ?></td>
                                        <td><a href="<?= base_url('bukti-barang-masuk-jkt/') . $data['upload_bukti'] ?>" target="_blank">
                                                <img src="<?= base_url('bukti-barang-masuk-jkt/') . $data['upload_bukti'] ?>" alt="" style="height:50px; width:50px"></a></td>
                                        <?php if (in_array(session()->get('role'), ['2', '3', '7'])) : ?>
                                            <td class="text-center">
                                                <a class="btn btn-success" title="Edit Bray" href="<?= base_url('dashboard/warehouse-jakarta/stok/edit/') . $data['id'] ?>" role="button"><i class="fas fa-sm fa-pen"></i></a>
                                                <button class="btn btn-danger delete-stok" title="Hapus Bray" data-id="<?= $data['id'] ?>" data-url="<?= base_url('dashboard/warehouse-jakarta/stok/delete') ?>" role="button"><i class="fas fa-sm fa-trash"></i></i></button>
                                            </td>
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <?php if (in_array(session()->get('role'), ['2', '3', '7'])) : ?>
                                        <td colspan="2"></td>
                                        <td><b>Total Qty :</b></td>
                                        <td id="totalSum"></td>
                                        <td colspan="3"></td>
                                    <?php else : ?>
                                        <td colspan="2"></td>
                                        <td><b>Total Qty :</b></td>
                                        <td id="totalSum"></td>
                                        <td colspan="2"></td>
                                    <?php endif ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>


<script src="<?= base_url('js/sweet-alert.js') ?>"></script>
<script src="<?= base_url('js/data-table-stok.js') ?>"></script>

<?= $this->endsection(); ?>