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
        <h1 class="h3 mb-0 text-gray-800">Data Warehouse Kuningan</h1>
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
                                <a href="<?= base_url('dashboard/warehouse-kuningan/stok') ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Stok Produk</a>
                                <?php if (in_array(session()->get('role'), ['2', '3', '6'])) : ?>
                                    <div class="col-xl-1"></div>
                                    <a href="<?= base_url('dashboard/warehouse-kuningan/tambah') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk Baru</a>
                                <?php endif; ?>
                            </div>
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
                            <input type="text" name="datesBarangMasuk" id="datesBarangMasuk" class="form-control form-control-sm" value="">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <input type="hidden" value="<?= base_url('dashboard/warehouse-kuningan/list-barang-masuk') ?>" id="urlBarangMasuk">
                        <input type="hidden" value="<?= base_url('dashboard/warehouse-kuningan/delete') ?>" id="urlDelete">
                        <table class="table table-bordered" id="table1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>HPP (Rp)</th>
                                    <th>Qty</th>
                                    <?php if (in_array(session()->get('role'), ['2', '3', '6'])) : ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="2"></th>
                                    <th>Total (HPP x Qty/Produk): </th>
                                    <th id="totalHPP" class="export-number"></th>
                                    <th id="totalSum" class="export-number"></th>
                                    <?php if (in_array(session()->get('role'), ['2', '3', '6'])) : ?>
                                        <th></th>
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
                            <?php if (in_array(session()->get('role'), ['2', '3', '6'])) : ?>
                                <a href="<?= base_url('dashboard/warehouse-kuningan/keluar/tambah') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
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
                    <div class="table-responsive">
                        <input type="hidden" value="<?= base_url('dashboard/warehouse-kuningan/list-barang-keluar') ?>" id="urlBarangKeluar">
                        <input type="hidden" value="<?= base_url('dashboard/warehouse-kuningan/keluar/delete') ?>" id="urlDeleteBarangKeluar">
                        <table class="table table-bordered" id="table2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Total Resi</th>
                                    <th>Bukti Pickup</th>
                                    <?php if (in_array(session()->get('role'), ['2', '3', '6'])) : ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <?php if (in_array(session()->get('role'), ['2', '3', '6'])) : ?>
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
                                    <?php endif; ?>
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
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('input[name="datesBarangMasuk"]').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#datesBarangMasuk').daterangepicker({
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

    var urlTable = $('#urlBarangMasuk').val();
    var urlDelete = $('#urlDelete').val();

    $(document).ready(function() {
        let table = $('#table1').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: urlTable,
                method: 'POST',
                data: function(d) {
                    d.dates = $('input[name="datesBarangMasuk"]').val();
                },
            },
            dom: '<"button-container"lBfrtip>',
            buttons: [{
                    extend: 'excelHtml5',
                    footer: true,
                    title: 'Data Barang Masuk - ' + formattedDate,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4],
                    },
                    customizeData: function(data) {
                        // Memperbaiki format angka pada kolom tertentu
                        for (var i = 0; i < data.body.length; i++) {
                            for (var j = 0; j < data.body[i].length; j++) {
                                // Kolom hpp dan qty (ganti dengan indeks yang sesuai)
                                if (j === 3 || j === 4) {
                                    data.body[i][j] = parseFloat(data.body[i][j].replace(/\./g, '').replace(',', '.')) || 0;
                                }
                            }
                        }
                    },
                    className: 'mb-2',
                    // ubah nama file ketika di download

                },
                {
                    extend: 'pdfHtml5',
                    footer: true,
                    title: 'Data Barang Masuk - ' + formattedDate,
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                    },
                    className: 'mb-2',
                }
            ],
            columns: [{
                    data: 'no',
                    orderable: false
                }, {
                    data: 'tanggal'
                }, {
                    data: 'nama_barang'
                }, {
                    data: 'hpp'
                },
                {
                    data: 'qty'
                },
                <?php if (in_array(session()->get('role'), ['2', '3', '6'])) : ?> {
                        data: 'action'
                    }
                <?php endif ?>
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'Semua']
            ], // Pilihan jumlah data per halaman, termasuk "Semua"
            pageLength: 10,
            order: [],
            columnDefs: [{
                targets: -1,
                orderable: false
            }, ],
            initComplete: function() {
                // Fungsi untuk menghitung jumlah total kolom "jumlah"
                function sumColumn() {
                    let columnData = table.column(4, {
                        search: 'applied'
                    }).data();

                    // Check if columnData is defined and not empty
                    if (columnData && columnData.length > 0) {
                        let sum = columnData.reduce(function(acc, curr) {
                            let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse angka
                            return acc + numericValue;
                        }, 0);

                        // Format jumlah total sebagai mata uang Indonesia
                        let formattedSum = sum.toLocaleString('id-ID', {
                            minimumFractionDigits: 0, // Atur ini ke 0 untuk menghilangkan angka di belakang koma
                            maximumFractionDigits: 2
                        });

                        // Tampilkan jumlah total di elemen HTML dengan ID "totalSum"
                        $('#totalSum').html('( ' + formattedSum + ' )');
                    } else {
                        // If columnData is undefined or empty, display a default value
                        $('#totalSum').html('0');
                    }

                    // jumlah hpp
                    let hppColumnIndex = 1; // Ganti dengan indeks kolom hpp pada DataTables Anda
                    let qtyColumnIndex = 1; // Ganti dengan indeks kolom qty pada DataTables Anda

                    let rowsData = table.rows({
                        search: 'applied'
                    }).data();
                    let totalHPP = 0;

                    rowsData.each(function(data) {
                        let hpp = parseFloat(data.hpp.replace(/\./g, '').replace(',', '.'));
                        let qty = parseFloat(data.qty.replace(/\./g, '').replace(',', '.'));
                        // Perkalian hpp dengan qty untuk setiap baris
                        let subtotal = hpp * qty;

                        // Menambahkan hasil perkalian ke totalHPP
                        totalHPP += subtotal;
                    });
                    // Format totalHPP sebagai mata uang Indonesia
                    let formattedTotalHPP = totalHPP.toLocaleString('id-ID', {
                        minimumFractionDigits: 0, // Atur ini ke 0 untuk menghilangkan angka di belakang koma
                        maximumFractionDigits: 2
                    });

                    // Tampilkan totalHPP di elemen HTML dengan ID "totalHPP"
                    $('#totalHPP').html('Rp. ' + formattedTotalHPP);
                }


                // Panggil fungsi sumColumn saat tabel selesai dimuat
                sumColumn();

                // Panggil fungsi sumColumn lagi ketika tabel di-filter atau di-sort
                table.on('search.dt draw.dt', sumColumn);
            },
        });

        $('#datesBarangMasuk').change(function(event) {
            table.ajax.reload();
        });

    });

    let currentDate = new Date();
    let formattedDate = currentDate.toISOString().split('T')[0];

    function deleteKngMasuk(id) {
        Swal.fire({
            title: "Apakah Anda yakin akan menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Tidak, batalkan!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan hapus menggunakan Ajax
                $.ajax({
                    method: "POST",
                    url: urlDelete,
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire(
                                "Dihapus!",
                                "Data Berhasil Dihapus",
                                "success"
                            ).then(() => {
                                // Muat ulang halaman setelah penghapusan
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                "Error!",
                                "Gagal menghapus data.",
                                "error"
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            "Error!",
                            "Terjadi kesalahan saat menghapus data.",
                            "error"
                        );
                    },
                });
            }
        });
    }
</script>
<script>
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('input[name="datesBarangKeluar"]').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#datesBarangKeluar').daterangepicker({
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

    var urlTableKeluar = $('#urlBarangKeluar').val();
    var urlDeleteKeluar = $('#urlDeleteBarangKeluar').val();

    console.log(urlDeleteKeluar);
    console.log(urlTableKeluar);

    $(document).ready(function() {
        let table = $('#table2').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: urlTableKeluar,
                method: 'POST',
                data: function(d) {
                    d.dates = $('input[name="datesBarangKeluar"]').val();
                },
            },
            dom: '<"button-container"lBfrtip>',
            buttons: [{
                    extend: 'excelHtml5',
                    footer: true,
                    title: 'Data Barang Keluar - ' + formattedDate,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            body: function(data, row, column, node) {
                                // Jika kolom adalah gambar, return elemen img
                                if (column === 5) {
                                    return $('img', data).attr('src');
                                }
                                return data;
                            }
                        }
                    },
                    className: 'mb-2',
                    // ubah nama file ketika di download

                },
                {
                    extend: 'pdfHtml5',
                    footer: true,
                    title: 'Data Barang Keluar - ' + formattedDate,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            body: function(data, row, column, node) {
                                // Jika kolom adalah gambar, return elemen img
                                if (column === 5) {
                                    return $('img', data).attr('src');
                                }
                                return data;
                            }
                        }
                    },
                    className: 'mb-2',
                }
            ],
            columns: [{
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
                <?php if (in_array(session()->get('role'), ['2', '3', '6'])) : ?> {
                        data: 'action'
                    },
                <?php endif ?>
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'Semua']
            ], // Pilihan jumlah data per halaman, termasuk "Semua"
            pageLength: 10,
            order: [],
            columnDefs: [{
                targets: -1,
                orderable: false
            }, ],
            initComplete: function() {
                // Fungsi untuk menghitung jumlah total kolom "jumlah"
                function sumColumn() {
                    let sum = table.column(3, {
                        search: 'applied'
                    }).data().reduce(function(acc, curr) {
                        let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse angka
                        return acc + numericValue;
                    }, 0);
                    let sumResi = table.column(4, {
                        search: 'applied'
                    }).data().reduce(function(acc, curr) {
                        let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse angka
                        return acc + numericValue;
                    }, 0);

                    // Format jumlah total sebagai mata uang Indonesia
                    let formattedSum = sum.toLocaleString('id-ID', {
                        minimumFractionDigits: 0, // Atur ini ke 0 untuk menghilangkan angka di belakang koma
                        maximumFractionDigits: 2
                    });
                    let formattedSumResi = sumResi.toLocaleString('id-ID', {
                        minimumFractionDigits: 0, // Atur ini ke 0 untuk menghilangkan angka di belakang koma
                        maximumFractionDigits: 2
                    });

                    // Tampilkan jumlah total di elemen HTML dengan ID "totalSum"
                    $('#totalQty').html(formattedSum);
                    $('#totalResi').html(formattedSumResi);
                }

                // Panggil fungsi sumColumn saat tabel selesai dimuat
                sumColumn();

                // Panggil fungsi sumColumn lagi ketika tabel di-filter atau di-sort
                table.on('search.dt draw.dt', sumColumn);
            },
        });

        $('#datesBarangKeluar').change(function(event) {
            table.ajax.reload();
        });

    });


    function deleteKngKeluar(id) {
        Swal.fire({
            title: "Apakah Anda yakin akan menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Tidak, batalkan!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan hapus menggunakan Ajax
                $.ajax({
                    type: "POST",
                    url: urlDeleteKeluar,
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        console.log(data);
                        if (data.success) {
                            Swal.fire(
                                "Dihapus!",
                                "Data Berhasil Dihapus",
                                "success"
                            ).then(() => {
                                // Muat ulang halaman setelah penghapusan
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                "Error!",
                                "Gagal menghapus data.",
                                "error"
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            "Error!",
                            "Terjadi kesalahan saat menghapus data.",
                            "error"
                        );
                    },
                });
            }
        });
    }
</script>
<script src="<?= base_url('js/sweet-alert.js') ?>"></script>

<?= $this->endsection(); ?>