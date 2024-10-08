<?= $this->extend('mobile/layouts'); ?>

<?= $this->section('content'); ?>

<!-- sweetalert -->

<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>',
        })
    </script>
<?php elseif (session()->getFlashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= session()->getFlashdata('error') ?>',
            showConfirmButton: false,
        })
    </script>
<?php endif; ?>
<!-- Header Area -->
<div class="header-area" id="headerArea">
    <div class="container">
        <!-- Header Content -->
        <div class="header-content position-relative d-flex align-items-center justify-content-between">
            <!-- Back Button -->
            <div class="back-button">
                <a href="<?= base_url('/stok-opname') ?>">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>

            <!-- Page Title -->
            <div class="page-heading">
                <h6 class="mb-0"><?= $title ?></h6>
            </div>
            <div class="setting-wrapper">
            </div>
        </div>
    </div>
</div>
<div class="page-content-wrapper py-3">
    <div class="container">
        <!-- User Meta Data-->
        <div class="card user-data-card">
            <div class="card-body">
                <form action="<?= base_url('stok-opname/barang-masuk/add') ?>" method="POST">
                    <!-- <div class="input-group mb-3">
                        <span class="input-group-text" id="to">To</span>
                        <input class="form-control" type="text" placeholder="" aria-label="Username" aria-describedby="to">
                    </div> -->
                    <div id="reader" width="600px" class=""></div>
                    <div class="form-group">
                        <label class="form-label" for="message">Nama Barang</label>
                        <input class="form-control" id="nama_barang" name="nama_barang" placeholder="Scan Kode QR" value="" readonly>
                        <input class="form-control" id="id_barang" name="id_barang" placeholder="Masukan Qty" value="" hidden>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="message">Qty</label>
                        <input class="form-control" id="message" name="qty" placeholder="Masukan Qty" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="message">Jenis Barang Masuk</label>
                        <select class="form-select" name="jenis_barang_masuk" required>
                            <option value="Barang Beli">Barang Beli</option>
                            <option value="Barang Return">Barang Return</option>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label class="form-label" for="message">Jenis Barang Masuk</label>
                        <select class="form-select" name="jenis_barang_masuk">
                            <option value="Barang Beli">Barang Beli</option>
                            <option value="Barang Return">Barang Return</option>
                        </select>
                    </div> -->
                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="pb-3"></div>
</div>

<!-- Footer Nav -->
<!-- <div class="footer-nav-area" id="footerNav">
    <div class="container px-0">
        <div class="footer-nav position-relative shadow-sm footer-style-two">
            <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                <li>
                    <a href="<?= base_url('/') ?>">
                        <i class="bi bi-house"></i>
                    </a>
                </li>

                <li class="active">
                    <a href="#">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('/profile') ?>">
                        <i class="bi bi-person"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div> -->


<?= $this->endsection(); ?>

<?= $this->section('script'); ?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        console.log(`Code matched = ${decodedText}`, decodedResult);

        // data array
        var dataMaster = <?php echo json_encode($data); ?>;
        // cari data berdasarkan id dan ambil nama barang
        var data = dataMaster.find(x => x.id == decodedText);
        if (!data) {
            alert('Data tidak ditemukan');
            document.getElementById('nama_barang').value = '';
            document.getElementById('id_barang').value = '';
            return;
        }
        var nama_barang = data.nama_barang;
        // set value input dengan name nama_barang
        document.getElementById('nama_barang').value = nama_barang;
        document.getElementById('id_barang').value = data.id;

    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            }
        },
        /* verbose= */
        false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
<?= $this->endsection(); ?>