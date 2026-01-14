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
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Akun</h1>
    </div>
    <!-- Collapsable Card Example -->
    <div class="row">
        <div class="col-xl-8 col-md-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample1" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample1">

                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user mx-2"></i> Akun</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseCardExample1">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Hak Akses</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($user as $data) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['nama'] ?></td>
                                            <td><?= $data['email'] ?></td>
                                            <td><?= $data['role'] ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-danger delete-button" data-id="<?= $data['id'] ?>"><i class="fas fa-sm fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">

                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-plus mx-2"></i> Tambah Akun</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseCardExample2">
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('dashboard/setting/add') ?>">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nama</label>
                                <input type="text" name="nama" class="form-control" id="exampleFormControlInput1" placeholder="Nama">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Email</label>
                                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Hak Akses</label>
                                <select class="form-control" name="role" id="exampleFormControlSelect1">
                                    <option value="1">Super Admin</option>
                                    <option value="2">Manager Broadcast</option>
                                    <option value="3">Manager Advertiser</option>
                                    <option value="4">Admin Advertiser</option>
                                    <option value="5">Karyawan Advertiser</option>
                                    <option value="6">Gudang Kuningan</option>
                                    <option value="7">Gudang Jakarta</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<!-- menambahkan script -->
<?= $this->section('custom-js'); ?>
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
    // Tangkap semua elemen dengan class delete-button
    const deleteButtons = document.querySelectorAll(".delete-button");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const id = this.getAttribute("data-id");

            Swal.fire({
                title: "Apakah Anda yakin akan menghapus Akun ini?",
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
                        url: "<?= base_url('dashboard/setting/delete') ?>", // Ganti dengan URL tindakan penghapusan di Controller Anda
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

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    title: 'Data User',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Data User',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
            ],
            "order": [
                [0, "asc"]
            ]
        });
    });
</script>

<?= $this->endSection(); ?>