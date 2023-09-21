<?= $this->extend('template/template'); ?>

<?= $this->section('header'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" type="text/css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css" type="text/css">

<!-- css adminlte -->

<!-- <link rel="stylesheet" href="<?= base_url('table') ?>/plugins/fontawesome-free/css/all.min.css">

<link rel="stylesheet" href="<?= base_url('table') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('table') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('table') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> -->

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
        <h1 class="h3 mb-0 text-gray-800">Data Warehouse Jakarta</h1>
    </div>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="">
                        <div class="row">
                            <div class="col-xl-6">
                                <h6 class=" font-weight-bold text-primary">Data Warehouse</h6>
                            </div>
                            <div class="col-xl-6 d-flex justify-content-end">

                                <a href="<?= base_url('dashboard/warehouse-jakarta/stok') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Stok Produk</a>
                                <?php if (in_array(session()->get('role'), ['2', '3', '7'])) : ?>
                                    <div class="col-xl-1"></div>
                                    <a href="<?= base_url('dashboard/warehouse-jakarta/tambah') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk Baru</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="form-group">
                            <label class="form-label"><b>Filter Data :</b></label>
                            <div class="input-group" style="width: 16rem;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" name="datesBarangMasuk" id="datesBarangMasuk" class="form-control form-control-sm" value="">
                            </div>
                        </div>
                        <input type="hidden" value="<?= base_url('dashboard/warehouse-jakarta/list-barang-masuk-jkt') ?>" id="urlBarangMasuk">
                        <input type="hidden" value="<?= base_url('dashboard/warehouse-jakarta/delete') ?>" id="urlDelete">
                        <table class="table table-bordered" id="table1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <?php if (in_array(session()->get('role'), ['2', '3', '7'])) : ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <?php if (in_array(session()->get('role'), ['2', '3', '7'])) : ?>
                                        <td colspan="2"></td>
                                        <td><b>Total Qty :</b></td>
                                        <td id="totalSum"></td>
                                        <td></td>
                                    <?php else : ?>
                                        <td colspan="2"></td>
                                        <td><b>Total Qty :</b></td>
                                        <td id="totalSum"></td>
                                    <?php endif; ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Barang Keluar</h1>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class=" font-weight-bold text-primary">Barang Keluar</h6>
                            <?php if (session()->get('role') == '2' || session()->get('role') == '7' || session()->get('role') == '3') : ?>
                                <a href="<?= base_url('dashboard/warehouse-jakarta/keluar/tambah') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label"><b>Filter Data :</b></label>
                        <div class="input-group" style="width: 16rem;">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" name="datesBarangKeluar" id="datesBarangKeluar" class="form-control form-control-sm" value="">
                        </div>
                    </div>
                    <input type="hidden" value="<?= base_url('dashboard/warehouse-jakarta/list-barang-keluar-jkt') ?>" id="urlBarangKeluar">
                    <input type="hidden" value="<?= base_url('dashboard/warehouse-jakarta/keluar/delete') ?>" id="urlDeleteBarangKeluar">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Total Resi</th>
                                    <th>Bukti Pickup</th>
                                    <?php if (in_array(session()->get('role'), ['2', '3', '7'])) : ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <?php if (in_array(session()->get('role'), ['2', '3', '7'])) : ?>
                                        <td colspan="2"></td>
                                        <td><b>Total :</b></td>
                                        <td id="totalQty"></td>
                                        <td id="totalResi"></td>
                                        <td colspan="2"></td>
                                    <?php else : ?>
                                        <td colspan="2"></td>
                                        <td><b>Total :</b></td>
                                        <td id="totalQty"></td>
                                        <td id="totalResi"></td>
                                        <td></td>
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    <?php if (in_array(session()->get('role'), ['2', '3', '7'])) : ?>
        var columnBarangMasukJkt = [{
            data: 'no',
            orderable: false
        }, {
            data: 'tanggal'
        }, {
            data: 'nama_barang'
        }, {
            data: 'qty'
        }, {
            data: 'action'
        }, ];
    <?php endif ?>
    <?php if (in_array(session()->get('role'), ['1', '5', '4'])) : ?>
        var columnBarangMasukJkt = [{
            data: 'no',
            orderable: false
        }, {
            data: 'tanggal'
        }, {
            data: 'nama_barang'
        }, {
            data: 'qty'
        }];
    <?php endif; ?>

    <?php if (in_array(session()->get('role'), ['2', '3', '7'])) : ?>
        var columnBarangKeluarJkt = [{
                data: 'no',
                orderable: false
            },
            {
                data: 'tanggal'
            },
            {
                data: 'nama_barang'
            },
            {
                data: 'qty'
            },
            {
                data: 'total_resi'
            },
            {
                data: 'bukti_pickup'
            }, {
                data: 'action'
            },
        ];
    <?php endif ?>
    <?php if (in_array(session()->get('role'), ['1', '5', '4'])) : ?>
        var columnBarangKeluarJkt = [{
                data: 'no',
                orderable: false
            },
            {
                data: 'tanggal'
            },
            {
                data: 'nama_barang'
            },
            {
                data: 'qty'
            },
            {
                data: 'total_resi'
            },
            {
                data: 'bukti_pickup'
            },
        ];
    <?php endif; ?>
</script>

<script src="<?= base_url('js/data-table-barang-masuk-jkt.js') ?>"></script>
<script src="<?= base_url('js/data-table-barang-keluar-jkt.js') ?>"></script>
<script src="<?= base_url('js/sweet-alert.js') ?>"></script>


<?= $this->endsection(); ?>