<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<?= $this->section('header'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<?= $this->endSection(); ?>

<!-- menambahkan section -->
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Barang Keluar</h1>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                text: 'Data berhasil ditambahkan!',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location = "<?= base_url('dashboard/pengeluaran-advertiser') ?>";
            });
        </script>
    <?php endif ?>
    <?php if (!empty(session()->getFlashdata('error'))) : ?>
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
    <style>
        .dropzone {
            border: 0px;
        }

        div.dz-default.dz-message {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
            padding: 40px 20px;
        }
    </style>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
        </div>
        <div class="card-body">
            <form method="POST" class="dropzone" id="fileDrop" action="<?= base_url('dashboard/warehouse-jakarta/keluar/add') ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="formGroupExampleInput">Tanggal</label>
                    <input type="date" class="form-control tanggal" value="<?= date('Y-m-d') ?>" id="formGroupExampleInput" name="tanggal" placeholder="Tanggal Input">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Barang</label>
                    <select class="custom-select" name="nama_barang[]">
                        <option selected>Pilih Barang</option>
                        <?php foreach ($barangmasuk as $data) : ?>
                            <option value="<?= $data['id'] ?>"><?= $data['nama_barang'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <span class="text-disable md-1"> <i class="fas fa-info-circle fa-sm text-danger"></i> Jika barang keluar berupa bundle, harap klik tambah item</span>
                </div>
                <div id="formTambahBarang"></div>
                <button type="button" class="btn btn-link" id="tambahBarang">+ Tambah Item </button>
                <div class="form-group">
                    <label for="formGroupExampleInput">Qty</label>
                    <input type="text" class="form-control" id="harga" name="qty" placeholder="Masukan Qty">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Total Resi</label>
                    <input type="text" class="form-control" id="harga" name="total_resi" placeholder="Masukan Total Resi">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</div>

</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    Dropzone.autoDiscover = true;
    Dropzone.options.fileDrop = { // The camelized version of the ID of the form element

        // The configuration we've talked about above
        autoProcessQueue: false,
        // paramname
        paramName: "upload_bukti",
        uploadMultiple: false,
        parallelUploads: 1,
        maxFiles: 1,
        maxFilesize: 2, // MB
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        // tambahkan close
        addRemoveLinks: true,
        // atur agar diatas button submit
        dictDefaultMessage: "Klik atau Drop disini untuk mengupload Bukti Upload",

        dictFileTooBig: "Ukuran file terlalu besar ({{filesize}}MiB). Maksimal ukuran file {{maxFilesize}}MiB.",

        // The setting up of the dropzone
        init: function() {
            var myDropzone = this;
            // autodiscover set false
            // First change the button to actually tell Dropzone to process the queue.
            this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
            });

            // terima response ketika sukses
            this.on("success", function(file, response) {
                console.log(response);
                // dapatkan status dari json response
                var respond = JSON.parse(response);
                // jika sukses
                if (respond.status == true) {
                    // sweet alert
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Data berhasil ditambahkan!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        window.location = "<?= base_url('dashboard/warehouse-jakarta') ?>";
                    });
                } else {
                    // sweet alert
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        text: 'Data gagal ditambahkan!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function() {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.

            });
            this.on("successmultiple", function(files, response) {
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.

                console.log(response);
            });
            this.on("errormultiple", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
                console.log(response);
            });
        }

    }
</script>
<script>
    $(document).ready(function() {
        // Fungsi untuk menambahkan input baru
        $("#tambahBarang").click(function() {
            var newInput = '<div class="form-group">' +
                '<label for="exampleInputEmail1">Nama Barang Bundle</label>' +
                '<select class="custom-select" name="nama_barang[]">' +
                '<option selected>Pilih Barang</option>' +
                '<?php foreach ($barangmasuk as $data) : ?>' +
                '<option value="<?= $data['id'] ?>"><?= $data['nama_barang'] ?></option>' +
                '<?php endforeach ?>' +
                '</select>' +
                '<button type="button" class="btn btn-link removeInput mt-2">Hapus</button>' +
                '</div>';

            $("#formTambahBarang").append(newInput);
        });

        // Fungsi untuk menghapus input
        $("#formTambahBarang").on("click", ".removeInput", function() {
            $(this).closest(".form-group").remove();
        });
    });
</script>

<?= $this->endSection(); ?>