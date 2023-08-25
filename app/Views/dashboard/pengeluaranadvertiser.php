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
                    <a href="<?= base_url('dashboard/tambah-data-pengeluaran-advertiser') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
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
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Nama Advertiser</th>
                            <th>Bank Tujuan</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($pengeluaranadv as $data) :
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data['tanggal'] ?></td>
                                <td><?= $data['waktu'] ?></td>
                                <td><?= $data['nama_advertiser'] ?></td>
                                <td><?= $data['bank_tujuan'] ?></td>
                                <td><?= $data['keterangan'] ?></td>
                                <td>Rp. <?= number_format($data['jumlah'], 0, ',', '.') ?></td>
                                <td class="text-center">
                                    <a class="btn btn-success" title="Edit Bray" href="<?= base_url('dashboard/pengeluaran-advertiser/edit/') . $data['id_pengeluaran'] ?>" role="button"><i class="fas fa-sm fa-pen"></i></a>
                                    <button class="btn btn-danger delete-button" title="Hapus Bray" data-id="<?= $data['id_pengeluaran'] ?>" role="button"><i class="fas fa-sm fa-trash"></i></i></button>
                                </td>
                            </tr>
                        <?php
                        endforeach
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5"></td>
                            <td><b>Total</b></td>
                            <td><b>Rp. <?= number_format($total, 0, ',', '.') ?></b></td>
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

<script>
    let minDate, maxDate;


    // Custom filtering function which will search data in column four between two values
    DataTable.ext.search.push(function(settings, data, dataIndex) {
        let min = minDate.val();
        let max = maxDate.val();
        let date = new Date(data[1]);
        let jumlah = parseInt(data[6].replace(/[^\d.-]/g, '')); // Mengambil nilai dalam kolom "Jumlah" dan mengonversi ke Int

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

    $(document).ready(function() {
        // DataTables initialisation
        let table = $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    footer: true,
                    title: 'Data Pengeluaran Advertiser',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    className: 'mb-2',
                    // ubah nama file ketika di download

                },
                {
                    extend: 'pdfHtml5',
                    footer: true,
                    title: 'Data Pengeluaran Advertiser',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    className: 'mb-2',
                }
            ],
        });

        table.buttons().container()
            .appendTo('#example1_wrapper .col-md-6:eq(0)');

        // Refilter the table
        document.querySelectorAll('#min, #max').forEach((el) => {
            el.addEventListener('change', () => table.draw());
        });

    });
</script>
<script>
    // Tangkap semua elemen dengan class delete-button
    const deleteButtons = document.querySelectorAll(".delete-button");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const id = this.getAttribute("data-id");

            Swal.fire({
                title: "Apakah Anda yakin akan menghapus produk ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Gak Jadi Ah!",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan hapus menggunakan Ajax
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('dashboard/pengeluaran-advertiser/delete') ?>", // Ganti dengan URL tindakan penghapusan di Controller Anda
                        data: {
                            id: id
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.success) {
                                Swal.fire(
                                    "Dihapus!",
                                    "Data Lamaran Berhasil Dihapus",
                                    "success"
                                ).then(() => {
                                    // Muat ulang halaman setelah penghapusan
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    "Error!",
                                    "Failed to delete the item.",
                                    "error"
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                "Error!",
                                "An error occurred while deleting the item.",
                                "error"
                            );
                        },
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>