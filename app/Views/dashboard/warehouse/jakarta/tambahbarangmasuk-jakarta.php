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
        <h1 class="h3 mb-0 text-gray-800">Tambah Barang Masuk</h1>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                text: 'Data Pengeluaran Advertiser berhasil ditambahkan!',
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
        </div>
        <div class="card-body">
            <form class="dropzone" id="my-dropzone" method="POST" action="<?= base_url('dashboard/warehouse-jakarta/add') ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="formGroupExampleInput">Tanggal</label>
                    <input type="date" class="form-control tanggal" value="<?= date('Y-m-d') ?>" id="formGroupExampleInput" name="tanggal" placeholder="Tanggal Input">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Nama Barang</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" name="nama_barang" placeholder="Masukan Nama Barang">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">HPP</label>
                    <input type="text" class="form-control formatted-input" id="hpp" name="hpp" placeholder="Masukan HPP Barang">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Qty</label>
                    <input type="text" class="form-control formatted-input" id="harga" name="qty" placeholder="Masukan Qty">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    // mendapatkan elemen id input hpp




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
<script>
    function addThousandSeparator(input) {
        // Menambahkan pemisah ribuan ke input
        return input.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Ambil elemen input pertama dengan kelas "formatted-input"
    const inputElement = document.querySelector(".formatted-input");

    inputElement.addEventListener("input", function() {
        // Ambil nilai dari input
        const nilaiInput = parseFloat(inputElement.value.replace(/,/g, ""));

        // Pastikan nilaiInput adalah angka valid
        if (!isNaN(nilaiInput)) {
            // Tambahkan pemisah ribuan ke nilaiInput
            const nilaiFormat = addThousandSeparator(nilaiInput.toString());

            // Masukkan nilai yang diformat kembali ke input
            inputElement.value = nilaiFormat;
        }
    });
</script>
<?= $this->endSection(); ?>