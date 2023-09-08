<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<?= $this->section('header'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="">
                <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('dashboard/warehouse-jakarta/keluar/add') ?>" enctype="multipart/form-data">
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
                    <div class="form-group">
                        <label for="formGroupExampleInput">Upload Bukti Pembayaran</label>
                        <input type="file" class="form-control-file form-control" id="exampleFormControlFile1" name="upload_bukti">
                        <br id="jarak">
                        <img id="previewImage" src="" style="max-width: 100%; max-height: 200px;">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </div>
    <?= $this->endSection(); ?>

    <?= $this->section('script'); ?>
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

    <script>
        // Mendapatkan elemen input file
        var inputFile = document.getElementById('exampleFormControlFile1');

        // Mendapatkan elemen gambar untuk menampilkan preview
        var previewImage = document.getElementById('previewImage');
        var jarak = document.getElementById('jarak');

        // Menambahkan event listener untuk menghandle perubahan input file
        inputFile.addEventListener('change', function() {
            var file = inputFile.files[0];

            if (file) {
                // Membaca file sebagai URL data
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Menampilkan gambar pada elemen gambar
                    previewImage.src = e.target.result;
                    // Menampilkan elemen gambar
                    previewImage.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                // Menghapus elemen gambar jika tidak ada file yang dipilih
                previewImage.parentNode.removeChild(previewImage);
                jarak.parentNode.removeChild(jarak);
            }
        });
    </script>
    <?= $this->endSection(); ?>