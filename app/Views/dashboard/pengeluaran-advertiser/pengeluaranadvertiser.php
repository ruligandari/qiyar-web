<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<?= $this->section('header'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            text: 'Data produk berhasil diupdate!',
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
        <h1 class="h3 mb-0 text-gray-800">Pengeluaran Advertiser</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h6 class=" font-weight-bold text-primary">Data Pengeluaran Advertiser</h6>
                    <?php if (session()->get('role') == '1' || session()->get('role') == '3') : ?>
                        <a href="<?= base_url('dashboard/advertiser/tambah-data-pengeluaran-advertiser') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
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
                    <input type="text" name="dates" id="dates" class="form-control form-control-sm" value="">
                </div>
            </div>

            <div class="table-responsive">
                <table id="table" class="table table-sm table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Nama Advertiser</th>
                            <th>Bank Tujuan</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th colspan="5"></th>
                            <th style="text-align:right">Total:</th>
                            <th id="totalSum"></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
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
        let table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('dashboard/advertiser/pengeluaran-advertiser/list-pengeluaran') ?>',
                method: 'POST',
                data: function(d) {
                    d.dates = $('input[name="dates"]').val();
                },
            },
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    footer: true,
                    title: 'Data Pengeluaran Advertiser - ' + formattedDate,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                    className: 'mb-2',
                    // ubah nama file ketika di download

                },
                {
                    extend: 'pdfHtml5',
                    footer: true,
                    title: 'Data Pengeluaran Advertiser - ' + formattedDate,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
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
                    data: 'waktu'
                },
                {
                    data: 'nama_advertiser'
                },
                {
                    data: 'bank_tujuan'
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'jumlah'
                },

                {
                    data: 'action',
                    orderable: false
                },
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'Semua']
            ], // Pilihan jumlah data per halaman, termasuk "Semua"
            pageLength: -1,
            order: [],
            columnDefs: [{
                targets: -1,
                orderable: false
            }, ],
            initComplete: function() {
                // Fungsi untuk menghitung jumlah total kolom "jumlah"
                function sumColumn() {
                    let sum = table.column(6, {
                        search: 'applied'
                    }).data().reduce(function(acc, curr) {
                        let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse angka
                        return acc + numericValue;
                    }, 0);

                    // Format jumlah total sebagai mata uang Indonesia
                    let formattedSum = sum.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0, // Atur ini ke 0 untuk menghilangkan angka di belakang koma
                        maximumFractionDigits: 2
                    });

                    // Tampilkan jumlah total di elemen HTML dengan ID "totalSum"
                    $('#totalSum').html(formattedSum);
                }

                // Panggil fungsi sumColumn saat tabel selesai dimuat
                sumColumn();

                // Panggil fungsi sumColumn lagi ketika tabel di-filter atau di-sort
                table.on('search.dt draw.dt', sumColumn);
            },
        });

        $('#dates').change(function(event) {
            table.ajax.reload();
        });

    });

    function deleteRecord(id) {
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
                    url: "<?= base_url('dashboard/advertiser/pengeluaran-advertiser/delete') ?>",
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
    let minDate, maxDate;


    // Custom filtering function which will search data in column four between two values
    DataTable.ext.search.push(function(settings, data, dataIndex) {
        let min = minDate.val();
        let max = maxDate.val();
        let date = new Date(data[1]);

        if (
            (min === null && max === null) ||
            (min === null && date <= max) ||
            (min <= date && max === null) ||
            (min <= date && date <= max)
        ) {
            // Jika data sesuai dengan kriteria filter
            return true;
        }
        return false;
    });

    // Create date inputs
    minDate = new DateTime('#min', {
        format: 'MMMM Do YYYY'
    });
    maxDate = new DateTime('#max', {
        format: 'MMMM Do YYYY'
    });

    let currentDate = new Date();
    let formattedDate = currentDate.toISOString().split('T')[0];

    <?php if (session()->get('role') != '5') : ?>

        $(document).ready(function() {
            // DataTables initialisation
            let table = $('#example1').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        footer: true,
                        title: 'Data Pengeluaran Advertiser - ' + formattedDate,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6],
                        },
                        className: 'mb-2',
                        // ubah nama file ketika di download

                    },
                    {
                        extend: 'pdfHtml5',
                        footer: true,
                        title: 'Data Pengeluaran Advertiser - ' + formattedDate,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6],
                        },
                        className: 'mb-2',
                    }
                ],
            });

            // Sum the "jumlah" column
            function sumColumn() {
                let sum = table.column(6, {
                    search: 'applied'
                }).data().reduce(function(acc, curr) {
                    let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse the formatted number
                    return acc + numericValue;
                }, 0);

                // Format the sum as Indonesian currency
                let formattedSum = sum.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0, // Set this to 0 to remove trailing zeros
                    maximumFractionDigits: 2
                });

                // Display the formatted sum
                $('#totalSum').html(formattedSum);
            }

            // Call sumColumn when searching/filtering is applied
            table.on('search.dt', function() {
                sumColumn();
            });

            // Initial sum when the page loads
            sumColumn();

            table.buttons().container()
                .appendTo('#example1_wrapper .col-md-6:eq(0)');

            // Refilter the table
            document.querySelectorAll('#min, #max').forEach((el) => {
                el.addEventListener('change', () => {
                    table.draw();
                    sumColumn();
                });
            });


        });
    <?php endif ?>
    <?php if (session()->get('role') == '5') : ?>
        $(document).ready(function() {
            // DataTables initialisation
            let table = $('#example1').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        footer: true,
                        title: 'Data Pengeluaran  <?= session()->get('nama') ?> - ' + formattedDate,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6],
                        },
                        className: 'mb-2',
                        // ubah nama file ketika di download

                    },
                    {
                        extend: 'pdfHtml5',
                        footer: true,
                        title: 'Data Pengeluaran  <?= session()->get('nama') ?> - ' + formattedDate,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6],
                        },
                        className: 'mb-2',
                    }
                ],
            });

            // Sum the "jumlah" column
            function sumColumn() {
                let sum = table.column(6, {
                    search: 'applied'
                }).data().reduce(function(acc, curr) {
                    let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse the formatted number
                    return acc + numericValue;
                }, 0);

                // Format the sum as Indonesian currency
                let formattedSum = sum.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0, // Set this to 0 to remove trailing zeros
                    maximumFractionDigits: 2
                });

                // Display the formatted sum
                $('#totalSum').html(formattedSum);
            }

            // Call sumColumn when searching/filtering is applied
            table.on('search.dt', function() {
                sumColumn();
            });

            // Initial sum when the page loads
            sumColumn();

            table.buttons().container()
                .appendTo('#example1_wrapper .col-md-6:eq(0)');

            // Refilter the table
            document.querySelectorAll('#min, #max').forEach((el) => {
                el.addEventListener('change', () => {
                    table.draw();
                    sumColumn();
                });
            });


        });
    <?php endif ?>
</script>

<?= $this->endSection(); ?>