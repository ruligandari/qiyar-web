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
                <!-- 1. Sticky Resi -->
                <div class="form-group mb-3">
                    <label class="form-label fw-bold" for="resi">Nomor Resi (Satu resi banyak barang)</label>
                    <div class="input-group">
                        <input class="form-control" id="resi" name="resi" placeholder="Scan/Input Resi Awal..." required>
                        <button class="btn btn-outline-danger" type="button" id="btnResetResi" onclick="resetResi()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>

                <hr class="my-2">

                <!-- 2. Input Barang -->
                <div class="form-group mb-2">
                    <label class="form-label" for="qrcode">Scan / Cari Barang</label>
                    <div class="input-group">
                        <input class="form-control" id="qrcode" name="qrcode" placeholder="Scan atau ketik ID..." autofocus>
                        <button class="btn btn-outline-secondary" type="button" id="btn-search"><i class="bi bi-search"></i></button>
                    </div>
                </div>

                <!-- Manual inputs removed for streamlined flow -->

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

    // State
    var dataMaster = <?php echo json_encode($data); ?>;
    var cart = []; 

    // Sticky Resi Logic
    function initStickyResi() {
        var savedResi = localStorage.getItem('current_resi');
        if (savedResi) {
            $('#resi').val(savedResi);
        }
        
        $('#resi').on('change', function() {
            var val = $(this).val();
            localStorage.setItem('current_resi', val);
            if(val) checkResiAvailability(val);
        });
    }

    function checkResiAvailability(resi) {
        $.ajax({
            url: '<?= base_url('stok-opname/barang-keluar/check-resi') ?>',
            type: 'POST',
            data: {resi: resi},
            success: function(response) {
                if(response.status === 'success' && response.exists) {
                    Swal.fire({
                        title: 'Resi Sudah Ada',
                        text: "Nomor resi ini sudah pernah digunakan sebelumnya. Apakah anda ingin melanjutkan menambahkan barang ke resi ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Lanjutkan',
                        cancelButtonText: 'Ganti Resi'
                    }).then((result) => {
                        if (!result.isConfirmed) {
                             $('#resi').val('');
                             localStorage.removeItem('current_resi');
                             $('#resi').focus();
                        } else {
                            // User wants to continue, maybe focus scanning
                            $('#qrcode').focus();
                        }
                    });
                }
            }
        });
    }

    function resetResi() {
        if(confirm('Reset Resi?')) {
            localStorage.removeItem('current_resi');
            $('#resi').val('');
            $('#resi').focus();
        }
    }

    $(document).ready(function() {

        initStickyResi();
        
        // 1. Initial Focus Logic
        if($('#resi').val() == '') {
            $('#resi').focus();
        } else {
            $('#qrcode').focus();
        }

        // 2. Resi Enter Handler (Move to Barcode)
        $('#resi').on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault(); 
                if($(this).val()) {
                    $('#qrcode').focus();
                }
            }
        });

        // 3. Handle Enter on QR Code (Rapid Scan)
        $('#qrcode').on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault(); 
                processScan($(this).val());
            }
        });

        $('#btn-search').on('click', function() {
            processScan($('#qrcode').val());
        });
    });

    function processScan(code) {
        if(!code) return;
        code = code.toString().trim();
        
        var data = dataMaster.find(x => x.id == code);
        
        if (!data) {
             Swal.fire({icon: 'error', title: 'Tidak Ditemukan', text: 'Barang tidak terdaftar', timer: 1000, showConfirmButton: false});
             $('#qrcode').select();
             return;
        }

        // Found -> Direct Add Mode
        addToCart(data.id, data.nama_barang, 1);
        
        // Visual Feedback (Toast)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true
        });
        Toast.fire({
            icon: 'success',
            title: data.nama_barang + ' (+1)'
        });

        // Reset Scan Input
        $('#qrcode').val('');
        $('#qrcode').focus();
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
                qty: qty
            });
        }
        renderCart();
    }

    function updateQty(index, newQty) {
        newQty = parseInt(newQty);
        if(newQty <= 0 || isNaN(newQty)) {
            // Optional: Ask confirmation to delete if 0? Or just reset to 1?
            // Let's reset to 1 for safety or delete if 0. 
            // Better behavior: minimum 1.
            cart[index].qty = 1;
            renderCart(); // re-render to fix input value
            return;
        }
        cart[index].qty = newQty;
        // No full re-render needed if we trust the input, but safe to re-render or just update data
        // Optimization: Don't re-render entire table to avoid losing focus if user is typing fast
        // But since onchange triggers on blur/enter, re-render is fine.
    }

    function deleteItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    function renderCart() {
        var html = '';
        if(cart.length === 0) {
            $('#empty-cart-msg').show();
        } else {
            $('#empty-cart-msg').hide();
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
                        <td class="text-center align-middle">
                            <button class="btn btn-sm btn-danger py-1 px-2" onclick="deleteItem(${index})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `;
            });
        }
        $('#cart-body').html(html);
    }

    function submitBulk() {
        var resi = $('#resi').val();
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
                                // Clear cart
                                cart = [];
                                renderCart();
                                
                                // Clear Resi (Transaction Completed)
                                localStorage.removeItem('current_resi');
                                $('#resi').val('');
                                
                                // Reset inputs
                                $('#qrcode').focus();
                            });
                        } else {
                            // Partial or Error
                             Swal.fire('Info', response.message, 'warning');
                             // If partial success, we might want to clear cart or only keep failed? 
                             // For simplicity: Clear all for now or let user manually fix.
                             // Let's clear nothing on error so user can fix.
                             if(response.status === 'partial') {
                                 // Maybe remove successful ones? Too complex for now.
                             }
                        }
                    },
                    error: function() {
                        Swal.fire('Gagal', 'Terjadi kesalahan sistem', 'error');
                    }
                });
            }
        });
    }
</script>
<?= $this->endsection(); ?>
