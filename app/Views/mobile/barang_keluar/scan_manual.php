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

                <div class="row g-2 mb-3">
                    <div class="col-8">
                         <div class="form-group">
                            <!-- <label class="form-label" for="nama_barang">Nama Barang</label> -->
                            <input class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang..." readonly style="background-color: #f8f9fa;">
                            <input class="form-control" id="id_barang" name="id_barang" value="" hidden>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <!-- <label class="form-label" for="qty">Qty</label> -->
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
            localStorage.setItem('current_resi', $(this).val());
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
        console.log("Master Items:", dataMaster.length);
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

        // Handle Enter on Qty -> Trigger Add
        $('#qty').on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                addItemToCart();
            }
        });
    });

    function processScan(code) {
        if(!code) return;
        code = code.toString().trim();
        
        var data = dataMaster.find(x => x.id == code);
        
        if (!data) {
             Swal.fire({icon: 'error', title: 'Tidak Ditemukan', text: 'Barang tidak terdaftar', timer: 1000, showConfirmButton: false});
             $('#nama_barang').val('');
             $('#id_barang').val('');
             $('#qrcode').select();
             return;
        }

        // Found -> Auto Add Mode
        $('#nama_barang').val(data.nama_barang);
        $('#id_barang').val(data.id);
        $('#qty').val(1);
        
        // Execute Add Immediately
        addItemToCart();
        
        // Visual Feedback (Toast) instead of Alert
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true
        });
        Toast.fire({
            icon: 'success',
            title: data.nama_barang + ' (1)'
        });
    }

    function addItemToCart() {
        var id = $('#id_barang').val();
        var nama = $('#nama_barang').val();
        var qty = parseInt($('#qty').val());

        if(!id || !nama || !qty || qty <= 0) {
            Swal.fire({icon: 'warning', title: 'Data Belum Lengkap', text: 'Pastikan barang discan dan qty valid', timer: 1500});
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
        
        // Reset Inputs for Next Scan
        $('#qrcode').val('');
        $('#nama_barang').val('');
        $('#id_barang').val('');
        $('#qty').val('');
        $('#qrcode').focus();
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
                        <td>${item.nama_barang}</td>
                        <td class="text-center">${item.qty}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-danger py-0 px-2" onclick="deleteItem(${index})"><i class="bi bi-trash"></i></button>
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
