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
        <div class="header-content position-relative d-flex align-items-center justify-content-between">
            <!-- Back Button -->
            <div class="back-button">
                <a href="<?= base_url('stok-opname/barang-keluar') ?>">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>
            <!-- Page Title -->
            <div class="page-heading">
                <h6 class="mb-0"><?= $title ?></h6>
            </div>
            <div class="setting-wrapper"></div>
        </div>
    </div>
</div>

<div class="page-content-wrapper py-3">
    <div class="container">
        <!-- User Meta Data-->
        <div class="card user-data-card">
            <div class="card-body">
                <form action="<?= base_url('stok-opname/barang-keluar/add') ?>" method="POST" id="form-scan">
                    
                    <div class="form-group mb-3">
                        <label class="form-label" for="qrcode">Scan Barcode / QR Code</label>
                        <input class="form-control" id="qrcode" name="qrcode" placeholder="Arahkan kursor kesini & Scan..." autofocus>
                        <small class="text-muted">Tekan otomatis submit setelah scan jika menggunakan scanner.</small>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label class="form-label" for="nama_barang">Nama Barang</label>
                        <input class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang" value="" readonly>
                        <input class="form-control" id="id_barang" name="id_barang" value="" hidden>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="qty">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty" placeholder="Masukan Qty">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="resi">Total Resi</label>
                        <input class="form-control" id="resi" name="resi" placeholder="Masukan Total Resi">
                    </div>

                    <button class="btn btn-primary w-100 mt-3" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>

<?= $this->section('script'); ?>
<script>
    // Data Master Barang dari Server
    var dataMaster = <?php echo json_encode($data); ?>;

    $(document).ready(function() {
        // Fokus otomatis ke input scan
        $('#qrcode').focus();

        // Event ketika input berubah (biasanya scanner mengirim Enter di akhir)
        $('#qrcode').on('change', function() {
            var code = $(this).val();
            processScan(code);
        });

        // Prevent submit form saat enter di field qrcode, tapi jalankan processScan
        $('#qrcode').on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                processScan($(this).val());
            }
        });
    });

    function processScan(code) {
        if(!code) return;

        console.log("Scanned:", code);
        
        // Cari data di master
        var data = dataMaster.find(x => x.id == code); // Asumsi QR berisi ID. Nanti bisa diganti code item.
        
        if (!data) {
            Swal.fire({
                icon: 'warning',
                title: 'Data tidak ditemukan',
                text: 'Kode: ' + code,
                timer: 1500
            });
            $('#nama_barang').val('');
            $('#id_barang').val('');
            $('#qrcode').val(''); // Clear input untuk scan berikutnya
            return;
        }

        // Isi field
        $('#nama_barang').val(data.nama_barang);
        $('#id_barang').val(data.id);
        
        // Pindah fokus ke qty agar user bisa input qty
        $('#qty').focus();

        // Optional: Reset field scan jika ingin scan resi nanti
        // $('#qrcode').val(''); 
    }
</script>
<?= $this->endsection(); ?>
