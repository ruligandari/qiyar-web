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


                <!-- Camera Element -->
                <div class="card mb-3 shadow-sm">
                     <div class="card-body p-2">
                        <div id="reader" width="100%"></div>
                     </div>
                </div>

                <!-- 2. Input Barang Results -->
                <!-- Manual inputs removed for streamlined flow -->

                <!-- 3. Cart List -->

                <!-- 3. Cart List -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="font-size: 0.9rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Barang</th>
                                <th width="15%">Qty</th>
                                <th width="15%">Total Resi</th>
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

    function onScanSuccess(decodedText, decodedResult) {
        // Pause Camera
        try {
            html5QrcodeScanner.pause(true); 
        } catch(e) {
            console.error("Pause failed", e);
        }

        // Mode Scan Barang
        // data array
        var dataMaster = <?php echo json_encode($data); ?>;
        var data = dataMaster.find(x => x.id == decodedText);
        
        if (!data) {
            Swal.fire({
                icon: 'error', 
                title: 'Tidak Ditemukan', 
                text: 'Barang tidak terdaftar', 
                confirmButtonText: 'OK'
            }).then(() => {
                resumeCamera();
            });
            return;
        }

        // Found -> Direct Add
        addToCart(data.id, data.nama_barang, 1);
        
        Swal.fire({
            icon: 'success', 
            title: 'Berhasil',
            text: data.nama_barang + ' ditambahkan',
            confirmButtonText: 'Lanjut Scan'
        }).then(() => {
            resumeCamera();
        });
    }

    function resumeCamera() {
        try {
            html5QrcodeScanner.resume();
        } catch(e) {
            console.error("Resume failed", e);
            // Fallback if needed
        }
    }

    function addToCart(id, nama, qty) {
        // Check if exists
        var existing = cart.find(x => x.id_barang == id);
        if(existing) {
            existing.qty += qty;
        } else {
            cart.push({
                id_barang: id,
                nama_barang: nama,
                qty: qty,
                total_resi: 1 // Default 1
            });
        }
        renderCart();
    }

    function updateQty(index, newQty) {
        newQty = parseInt(newQty);
        if(newQty <= 0 || isNaN(newQty)) {
            cart[index].qty = 1;
            renderCart(); 
            return;
        }
        cart[index].qty = newQty;
    }

    function updateTotalResi(index, newVal) {
        newVal = parseInt(newVal);
        if(newVal <= 0 || isNaN(newVal)) {
            cart[index].total_resi = 1;
            renderCart(); 
            return;
        }
        cart[index].total_resi = newVal;
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
                        <td class="align-middle">${item.nama_barang}</td>
                        <td class="text-center" width="25%">
                            <input type="number" class="form-control form-control-sm text-center" 
                                value="${item.qty}" 
                                min="1" 
                                onchange="updateQty(${index}, this.value)"
                            >
                        </td>
                        <td class="text-center" width="25%">
                            <input type="number" class="form-control form-control-sm text-center" 
                                value="${item.total_resi}" 
                                min="1" 
                                onchange="updateTotalResi(${index}, this.value)"
                            >
                        </td>
                        <td class="text-center align-middle">
                            <button class="btn btn-sm btn-danger py-1 px-2" onclick="deleteItem(${index})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        }
    }

    function submitBulk() {
        if(cart.length === 0) {
            Swal.fire('Error', 'List barang kosong!', 'error');
            return;
        }

        Swal.fire({
            title: 'Simpan Semua?',
            text: `Akan menyimpan ${cart.length} jenis barang.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                
                $.ajax({
                    url: '<?= base_url('stok-opname/barang-keluar/add-bulk') ?>',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        items: cart
                    }),
                    success: function(response) {
                        if(response.status === 'success') {
                            Swal.fire('Berhasil', response.message, 'success').then(() => {
                                cart = [];
                                renderCart();
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
            qrbox: { width: 250, height: 150 },
            formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE, Html5QrcodeSupportedFormats.CODE_128, Html5QrcodeSupportedFormats.EAN_13 ]
        },
        /* verbose= */
        false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
<?= $this->endsection(); ?>