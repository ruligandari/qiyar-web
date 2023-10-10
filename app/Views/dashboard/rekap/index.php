<!-- menambahkan template/template.php -->
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

<!-- menambahkan section -->
<?= $this->section('content'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

    #table {
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        /* Ganti 14px dengan ukuran font yang Anda inginkan */
    }

    #detail-pengiriman {
        font-size: 13px;
        font-family: 'Poppins', sans-serif;
        /* Ganti 14px dengan ukuran font yang Anda inginkan */
    }

    #table th {
        font-size: 14px;
        font-weight: bold;
        /* Ganti 16px dengan ukuran font yang Anda inginkan */
    }
</style>
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
        <h1 class="h5 mb-0 text-gray-800">Rekap Data </h1>
    </div>
    <!-- DataTales Example -->
    <!-- <div class="card mb-4">
        <div class="card-body">
            <div class="row mx-2">
                <div class="card col-3 col-sm-3 p-2">
                    <h4>Test</h4>
                    <h5>Test</h5>
                </div>
            </div>
        </div>
    </div> -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h6 class=" font-weight-bold text-primary">Rekap Data</h6>
                    <?php if (in_array(session()->get('role'), ['2', '3', '5'])) : ?>
                        <div class="dropdown">
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" data-offset="10, 10">
                                <i class="fas fa-file-excel"></i>
                                Import Data Excel
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item" data-toggle="modal" data-target="#import"><i class="fas fa-file-import"></i> Import Data</button>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('dashboard/rekap/download-template') ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-file-export"></i> Download Template</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="form-group mr-3 ml-3">
                    <label class="form-label"><b>Filter Tanggal :</b></label>
                    <div class="input-group" style="width: 16rem;">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" name="dates" id="dates" class="form-control form-control-sm" value="">
                    </div>
                </div>
                <div class="form-group mr-3">
                    <label class="form-label"><b>Filter Status Pengiriman :</b></label>
                    <div class="input-group" style="width: 16rem;">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-filter"></i>
                            </span>
                        </div>
                        <select class="custom-select custom-select-sm" id="status_pengiriman">
                            <option value="">Semua</option>
                            <option value="terkirim">Terkirim</option>
                            <option value="proses delevry">Proses Dilevery</option>
                            <option value="return">Return</option>
                            <option value="cancel">Cancel</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="table" class="table table-sm table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Order</th>
                            <th>Tanggal</th>
                            <th>Pembeli</th>
                            <th>Nama Produk</th>
                            <th>HPP Barang</th>
                            <th>Nominal COD</th>
                            <th>Fee COD</th>
                            <th>Setelah Diskon</th>
                            <th>Laba</th>
                            <th>Status Pengiriman</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5"></th>
                            <th id="totalHPP"></th>
                            <th id="totalNominalCod"></th>
                            <th id="totalFeeCod"></th>
                            <th id="totalSetelahDiskon"></th>
                            <th id="totalLaba"></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="import" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('dashboard/rekap/import') ?>" method="post" enctype="multipart/form-data">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file_excel" id="validatedInputGroupCustomFile" required onchange="updateLabel()">
                            <input type="hidden" name="id_adv" value="<?= session()->get('id') ?>">
                            <label class="custom-file-label" for="validatedInputGroupCustomFile">Pilih File ...</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Import</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="detail-pengiriman" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pengiriman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card col-12 p-2 text-white" id="d_bg">
                    <div class="row">
                        <div class="col-md-3">
                            <span id="d_status"></span>
                        </div>
                        <div class="col-md-3">
                            <span id="d_pengirim"></span>
                        </div>
                        <div class="col-md-3">
                            <span id="d_tujuan"></span>
                        </div>
                        <div class="col-md-3">
                            <span id="d_pembayaran"></span>
                        </div>
                    </div>
                </div>
                <div class="col-6 mt-2">
                    <span id="d_nama"></span>
                </div>
                <div class="col-6 mt-2">
                    <span id="d_nohp"></span>
                </div>
                <div class="col-6 mt-2">
                    <span id="d_alamat"></span>
                </div>
                <table class="table table-sm table-bordered mt-2" width="100%">
                    <thead>
                        <tr>
                            <th>No Resi</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Harga Produk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="d_resi"></td>
                            <td id="d_produk"></td>
                            <td id="d_qty"></td>
                            <td id="d_harga"></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right">Sub Total</td>
                            <td id="id_subtotal"></td>
                        </tr>
                    </tbody>

                </table>
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
        // membuta funnction detailPemngeriman, yang nantinya mengirimkan id_order ke controller
        function detailPengiriman(id_order) {
            $.ajax({
                url: '<?= base_url('dashboard/rekap/detail-pengiriman') ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    id_order: id_order
                },
                success: function(data) {
                    $('#d_bg').removeClass('bg-success bg-warning bg-danger bg-secondary');

                    // menampilkan data ke modal #detail-pengiriman
                    // jika data[0].remarks == terkirim maka background card akan berwarna hijau
                    if (data[0].remarks == 'terkirim') {
                        $('#d_bg').addClass('bg-success');
                    } else
                        // jika data[0].remarks == proses delivery maka background card akan berwarna biru
                        if (data[0].remarks == 'proses delevry') {
                            $('#d_bg').addClass('bg-warning');
                        } else
                            // jika data[0].remarks == return maka background card akan berwarna merah
                            if (data[0].remarks == 'return') {
                                $('#d_bg').addClass('bg-danger');
                            } else
                                // jika data[0].remarks == cancel maka background card akan berwarna abu-abu
                                if (data[0].remarks == 'cancel') {
                                    $('#d_bg').addClass('bg-secondary');
                                }
                    $('#d_status').html('Status : ' + data[0].remarks);
                    $('#d_pengirim').html('Pengirim : ' + data[0].pengirim);
                    $('#d_tujuan').html('Tujuan : ' + data[0].city);
                    $('#d_pembayaran').html('Pembayaran : ' + data[0].payment_method);
                    $('#d_resi').html(data[0].resi);
                    $('#d_nama').html('Nama : ' + data[0].name);
                    $('#d_nohp').html('No HP : ' + data[0].phone);
                    $('#d_alamat').html('Alamat : ' + data[0].address + ', ' + data[0].subdistrict + ', ' + data[0].city + ', ' + data[0].province + ', ' + data[0].zip);
                    $('#d_produk').html(data[0].barang);
                    $('#d_qty').html(data[0].qty);
                    $('#d_harga').html('Rp. ' + number_format(data[0].product_price, 0, ',', '.'));
                    $('#id_subtotal').html('Rp. ' + number_format(data[0].product_price * data[0].qty, 0, ',', '.'));

                }
            });
        }
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('input[name="dates"]').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#dates').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Semua': [moment().subtract(1, 'years'), moment()],
                    'Hari Ini': [moment(), moment()],
                    'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                    '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                    'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                    'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });
        $(document).ready(function() {
            table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {

                    url: '<?= base_url('dashboard/rekap/list-rekap') ?>',
                    method: 'POST',
                    data: function(d) {
                        d.remarks = $('#status_pengiriman').val();
                        d.id_adv = '<?= session()->get('id') ?>';
                        d.dates = $('input[name="dates"]').val();
                    },
                },
                order: [],
                columnDefs: [{
                    targets: -1,
                    orderable: false
                }, ],
                initComplete: function() {
                    // Fungsi untuk menghitung jumlah total kolom "jumlah"
                    function sumColumn() {
                        let sumLaba = table.column(9, {
                            search: 'applied'
                        }).data().reduce(function(acc, curr) {
                            let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse angka
                            return acc + numericValue;
                        }, 0);

                        let sumHPP = table.column(5, {
                            search: 'applied'
                        }).data().reduce(function(acc, curr) {
                            let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse angka
                            return acc + numericValue;
                        }, 0);
                        let sumNominalCod = table.column(6, {
                            search: 'applied'
                        }).data().reduce(function(acc, curr) {
                            let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse angka
                            return acc + numericValue;
                        }, 0);
                        let sumFeeCod = table.column(7, {
                            search: 'applied'
                        }).data().reduce(function(acc, curr) {
                            let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse angka
                            return acc + numericValue;
                        }, 0);
                        let sumSetelahDiskon = table.column(8, {
                            search: 'applied'
                        }).data().reduce(function(acc, curr) {
                            let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse angka
                            return acc + numericValue;
                        }, 0);

                        // Format jumlah total sebagai mata uang Indonesia
                        let formattedSumLaba = sumLaba.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0, // Atur ini ke 0 untuk menghilangkan angka di belakang koma
                            maximumFractionDigits: 2
                        });
                        let formattedSumHPP = sumHPP.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0, // Atur ini ke 0 untuk menghilangkan angka di belakang koma
                            maximumFractionDigits: 2
                        });
                        let formattedSumNominalCod = sumNominalCod.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0, // Atur ini ke 0 untuk menghilangkan angka di belakang koma
                            maximumFractionDigits: 2
                        });
                        let formattedSumFeeCod = sumFeeCod.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0, // Atur ini ke 0 untuk menghilangkan angka di belakang koma
                            maximumFractionDigits: 2
                        });
                        let formattedSumSetelahDiskon = sumSetelahDiskon.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0, // Atur ini ke 0 untuk menghilangkan angka di belakang koma
                            maximumFractionDigits: 2
                        });

                        // Tampilkan jumlah total di elemen HTML dengan ID "totalSum"
                        $('#totalLaba').html(formattedSumLaba);
                        $('#totalHPP').html(formattedSumHPP);
                        $('#totalNominalCod').html(formattedSumNominalCod);
                        $('#totalFeeCod').html(formattedSumFeeCod);
                        $('#totalSetelahDiskon').html(formattedSumSetelahDiskon);
                    }

                    // Panggil fungsi sumColumn saat tabel selesai dimuat
                    sumColumn();

                    // Panggil fungsi sumColumn lagi ketika tabel di-filter atau di-sort
                    table.on('search.dt draw.dt', sumColumn);
                },
            });
            $('#status_pengiriman').change(function(event) {
                table.ajax.reload();
            });
            $('#dates').change(function(event) {
                table.ajax.reload();
            });
        });
    </script>

    <script>
        function updateLabel() {
            // Dapatkan elemen input file
            var inputFile = document.getElementById('validatedInputGroupCustomFile');

            // Dapatkan elemen label
            var label = document.querySelector('.custom-file-label');

            // Setel teks label dengan nama file yang dipilih
            label.textContent = inputFile.files[0].name;
        }
    </script>

    <?= $this->endSection(); ?>