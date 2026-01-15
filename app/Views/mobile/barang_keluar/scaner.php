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
                
                <!-- Scan Mode Toggle -->
                <!-- Scan Mode Toggle Removed as per request -->

                <!-- 1. Sticky Resi -->
                <div class="form-group mb-3">
                    <label class="form-label fw-bold" for="resi">Nomor Resi</label>
                    <div class="input-group">
                        <input class="form-control" id="resi" name="resi" placeholder="Scan Resi Awal..." required>
                        <button class="btn btn-outline-danger" type="button" id="btnResetResi" onclick="resetResi()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Camera Element -->
                <div class="card mb-3 shadow-sm">
                     <div class="card-body p-2">
                        <div id="reader" width="100%"></div>
                     </div>
                </div>

                <!-- 2. Input Barang Results -->
                <div class="row g-2 mb-3">
                    <div class="col-8">
                         <div class="form-group">
                            <label class="form-label" for="nama_barang">Barang</label>
                            <input class="form-control" id="nama_barang" name="nama_barang" placeholder="Scan Barcode..." readonly style="background-color: #f8f9fa;">
                            <input class="form-control" id="id_barang" name="id_barang" value="" hidden>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="qty">Qty</label>
                            <input type="number" class="form-control" id="qty" name="qty" placeholder="Qty">
                        </div>
                    </div>
                </div>

                <button class="btn btn-secondary w-100 mb-3" type="button" id="btn-add-item" onclick="addItemToCart()">
                    <i class="bi bi-plus-lg"></i> Tambah ke List
                </button>

                <!-- 3. Cart List -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="font-size: 0.9rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Barang</th>
                                <th width="15%">Qty</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="cart-body">
                            <!-- Cart Items -->
                        </tbody>
                    </table>
                    <div id="empty-cart-msg" class="text-center text-muted fst-italic p-2">Belum ada barang di list.</div>
                </div>

                <button class="btn btn-primary w-100 mt-3" type="button" id="btn-save-all" onclick="submitBulk()">
                    <i class="bi bi-save"></i> Simpan Semua Barang
                </button>
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    // State
    var cart = [];
    var dataMaster = <?php echo json_encode($data); ?>;

    // Check Local Storage on Load
    document.addEventListener('DOMContentLoaded', function() {
        var savedResi = localStorage.getItem('current_resi');
        if (savedResi) {
            document.getElementById('resi').value = savedResi;
        }
        
        // Listen to Resi changes
        document.getElementById('resi').addEventListener('change', function() {
            localStorage.setItem('current_resi', this.value);
        });

        // Qty Enter Handler
        document.getElementById('qty').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addItemToCart();
            }
        });
    });

    function resetResi() {
        if(confirm('Reset Resi?')) {
            localStorage.removeItem('current_resi');
            document.getElementById('resi').value = '';
            Swal.fire({
                icon: 'info', title: 'Resi Direset', toast: true, position: 'top-end', showConfirmButton: false, timer: 1000
            });
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        // Logic: If Resi is empty => Mode Resi. Else => Mode Barang.
        var currentResi = document.getElementById('resi').value;

        if(!currentResi) {
            // Mode Scan Resi
            document.getElementById('resi').value = decodedText;
            localStorage.setItem('current_resi', decodedText);
            
            Swal.fire({
                icon: 'success', title: 'Resi Tersimpan', text: 'Nomor: ' + decodedText,
                timer: 1000, showConfirmButton: false, toast: true, position: 'top-end'
            });
            return;
        }

        // Mode Scan Barang
        // data array
        var dataMaster = <?php echo json_encode($data); ?>;
        // cari data berdasarkan id dan ambil nama barang
        var data = dataMaster.find(x => x.id == decodedText);
        if (!data) {
            Swal.fire({
                icon: 'error', title: 'Tidak Ditemukan', text: 'Barang tidak terdaftar', timer: 1000, showConfirmButton: false, toast: true
            });
            return;
        }

        // Found
        document.getElementById('nama_barang').value = data.nama_barang;
        document.getElementById('id_barang').value = data.id;
        document.getElementById('qty').value = 1;
        document.getElementById('qty').focus();
        document.getElementById('qty').select();
    }

    function addItemToCart() {
        var id = document.getElementById('id_barang').value;
        var nama = document.getElementById('nama_barang').value;
        var qty = parseInt(document.getElementById('qty').value);

        if(!id || !nama || !qty || qty <= 0) {
            Swal.fire({icon: 'warning', title: 'Data Belum Lengkap', text: 'Scan barang dan isi qty', timer: 1000});
            return;
        }

        // Check if exists
        var existing = cart.find(x => x.id_barang == id);
        if(existing) {
            existing.qty += qty;
        } else {
            cart.push({
                id_barang: id,
                nama_barang: nama,
                qty: qty
            });
        }

        renderCart();
        
        // Reset Inputs
        document.getElementById('nama_barang').value = '';
        document.getElementById('id_barang').value = '';
        document.getElementById('qty').value = '';
        
        Swal.fire({icon: 'success', title: 'Masuk List', timer: 700, showConfirmButton: false, toast: true, position: 'bottom'});
    }

    function deleteItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    function renderCart() {
        var html = '';
        var tbody = document.getElementById('cart-body');
        var emptyMsg = document.getElementById('empty-cart-msg');

        if(cart.length === 0) {
            emptyMsg.style.display = 'block';
            tbody.innerHTML = '';
        } else {
            emptyMsg.style.display = 'none';
            cart.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${item.nama_barang}</td>
                        <td class="text-center">${item.qty}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-danger py-0 px-2" onclick="deleteItem(${index})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        }
    }

    function submitBulk() {
        var resi = document.getElementById('resi').value;
        if(!resi) {
            Swal.fire('Error', 'Resi wajib diisi!', 'error');
            return;
        }
        if(cart.length === 0) {
            Swal.fire('Error', 'List barang kosong!', 'error');
            return;
        }

        Swal.fire({
            title: 'Simpan Semua?',
            text: `Akan menyimpan ${cart.length} jenis barang ke Resi ${resi}.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                // Use jQuery for Ajax because user has it loaded in layout usually, 
                // or fetch API. Layout seems to have jQuery (from index.php context).
                // But scaner.php didn't explicitly load jquery in section script.
                // It is safer to use fetch or check if jquery is available.
                // Assuming jQuery is available from layout.
                
                $.ajax({
                    url: '<?= base_url('stok-opname/barang-keluar/add-bulk') ?>',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        resi: resi,
                        items: cart
                    }),
                    success: function(response) {
                        if(response.status === 'success') {
                            Swal.fire('Berhasil', response.message, 'success').then(() => {
                                cart = [];
                                renderCart();
                                
                                // Clear Resi & Reset Mode
                                localStorage.removeItem('current_resi');
                                document.getElementById('resi').value = '';
                                document.getElementById('mode_resi').checked = true;

                                document.getElementById('nama_barang').value = '';
                                document.getElementById('id_barang').value = '';
                                document.getElementById('qty').value = '';
                            });
                        } else {
                             Swal.fire('Info', response.message, 'warning');
                        }
                    },
                    error: function() {
                        Swal.fire('Gagal', 'Terjadi kesalahan sistem', 'error');
                    }
                });
            }
        });
    }

    function onScanFailure(error) {
        // handle scan failure
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 250,
                height: 150 
            }
        },
        false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
<?= $this->endsection(); ?>