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
                        <div class="input-group">
                            <input class="form-control" id="qrcode" name="qrcode" placeholder="Scan atau ketik ID..." autofocus>
                            <button class="btn btn-outline-secondary" type="button" id="btn-search"><i class="bi bi-search"></i> Cari</button>
                        </div>
                        <small class="text-muted">Tekan Enter atau klik tombol Cari setelah mengetik manual.</small>
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
                        <label class="form-label" for="resi">Nomor Resi</label>
                        <input class="form-control" id="resi" name="resi" placeholder="Masukan Nomor Resi" required>
                    </div>

                    <button class="btn btn-primary w-100 mt-3" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>

<?= $this->section('script'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    // Data Master Barang dari Server
    var dataMaster = <?php echo json_encode($data); ?>;

    // Check if jQuery is loaded
    if (typeof jQuery === 'undefined') {
        alert("Error: jQuery not loaded! Please refresh or check connection.");
    }

    $(document).ready(function() {
        console.log("Data Master Loaded:", dataMaster.length, "items");
        if(dataMaster.length > 0) {
            console.log("Sample Data:", dataMaster[0]);
        } else {
            console.log("Data Master is EMPTY!");
        }
        
        // Fokus otomatis ke input scan
        $('#qrcode').focus();

        // 1. Handle Enter key (Keyboard & Scanner)
        $('#qrcode').on('keypress', function(e) {
            if (e.which == 13 || e.keyCode == 13) {
                e.preventDefault(); 
                var code = $(this).val();
                processScan(code);
            }
        });

        // 2. Handle Search Button Click
        $('#btn-search').on('click', function() {
             var code = $('#qrcode').val();
             processScan(code);
        });
    });

    function processScan(code) {
        if(!code) {
             Swal.fire({icon: 'info', title: 'Input Kosong', text: 'Silakan scan atau ketik ID barang', timer: 1500});
             return;
        }

        // Clean input
        code = code.toString().trim();
        console.log("Processing Code:", code);
        
        // Cari data di master
        // Ensure robust comparison using loose equality for ID
        var data = dataMaster.find(x => x.id == code); 
        
        if (!data) {
            console.warn("Item not found. Checking alternate codes...");
            // Optional: Backup check if user scanned a 'kode_barang' field instead of 'id'?
            // var data = dataMaster.find(x => x.kode_barang == code);
            
            Swal.fire({
                icon: 'error',
                title: 'Tidak Ditemukan',
                text: 'ID ' + code + ' tidak ada di data master. (Total item: '+dataMaster.length+')',
                timer: 3000,
                showConfirmButton: true
            });
            $('#nama_barang').val('');
            $('#id_barang').val('');
            $('#qrcode').select();
            return;
        }

        // FOUND!
        console.log("Item Found:", data);
        $('#nama_barang').val(data.nama_barang);
        $('#id_barang').val(data.id);
        
        // Move focus
        $('#qty').focus(); 
        $('#qty').select(); 
    }
</script>
<?= $this->endsection(); ?>
