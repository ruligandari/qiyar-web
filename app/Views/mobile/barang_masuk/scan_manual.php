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
                <a href="<?= base_url('stok-opname/barang-masuk') ?>">
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
                
                <!-- Toggle Switch Beli / Return -->
                <div class="d-flex justify-content-center mb-4">
                    <div class="btn-group" role="group" aria-label="Mode">
                        <input type="radio" class="btn-check" name="mode_switch" id="mode_beli" value="beli" checked>
                        <label class="btn btn-outline-primary" for="mode_beli">Barang Beli</label>

                        <input type="radio" class="btn-check" name="mode_switch" id="mode_return" value="return">
                        <label class="btn btn-outline-primary" for="mode_return">Barang Return</label>
                    </div>
                </div>

                <form action="<?= base_url('stok-opname/barang-masuk/add') ?>" method="POST" id="form-scan">
                    <!-- Hidden input to store mode -->
                    <input type="hidden" name="jenis_barang_masuk" id="jenis_barang_masuk" value="Barang Beli">

                    <div class="form-group mb-3">
                        <label class="form-label" id="label-scan" for="qrcode">Scan Barcode Barang</label>
                        <div class="input-group">
                            <input class="form-control" id="qrcode" name="qrcode" placeholder="Scan atau ketik ID/Resi..." autofocus>
                            <button class="btn btn-outline-secondary" type="button" id="btn-search"><i class="bi bi-search"></i> Cari</button>
                        </div>
                        <small class="text-muted" id="help-text">Tekan Enter atau klik tombol Cari setelah mengetik ID Barang.</small>
                    </div>

                    <hr>

                    <div id="single-item-container">
                        <div class="form-group">
                            <label class="form-label" for="nama_barang">Nama Barang</label>
                            <input class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang" value="" readonly>
                            <input class="form-control" id="id_barang" name="id_barang" value="" hidden>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="qty">Qty</label>
                            <input type="number" class="form-control" id="qty" name="qty" placeholder="Masukan Qty">
                        </div>

                        <!-- Input Resi (Hidden by default, shown for Return) -->
                        <div class="form-group d-none" id="group-resi">
                            <label class="form-label" for="resi">Nomor Resi (Referensi)</label>
                            <input class="form-control" id="resi" name="resi" placeholder="Nomor Resi Barang Keluar" readonly>
                        </div>

                        <button class="btn btn-primary w-100 mt-3" type="submit">Simpan</button>
                    </div>
                </form>

                <!-- Multiple Results Container -->
                <div id="multiple-results-area" class="mt-4 d-none">
                    <h6 class="text-muted mb-2">Hasil Pencarian (Pilih Salah Satu):</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;"><input type="checkbox" id="check-all" checked></th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody id="multiple-results-body">
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-success w-100 mt-2" type="button" id="btn-save-bulk">
                        <i class="bi bi-save"></i> Simpan Barang Terpilih
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endsection(); ?>

<?= $this->section('script'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Data Master (For 'Beli' Mode)
    var dataMaster = <?php echo json_encode($data); ?>;

    $(document).ready(function() {
        console.log("Data Master Loaded:", dataMaster.length);
        
        // Focus intial
        $('#qrcode').focus();

        // Handle Mode Switch
        $('input[name="mode_switch"]').change(function() {
            var mode = $(this).val();
            resetForm();
            
            if(mode === 'beli') {
                $('#jenis_barang_masuk').val('Barang Beli');
                $('#label-scan').text('Scan Barcode Barang');
                $('#qrcode').attr('placeholder', 'Scan atau ketik ID Barang...');
                $('#help-text').text('Tekan Enter atau klik tombol Cari setelah mengetik ID Barang.');
                $('#group-resi').addClass('d-none');
                $('#qty').prop('readonly', false).val('');
            } else {
                $('#jenis_barang_masuk').val('Barang Return');
                $('#label-scan').text('Scan Resi Pengiriman');
                $('#qrcode').attr('placeholder', 'Scan atau ketik Nomor Resi...');
                $('#help-text').text('Masukkan Resi untuk mencari data Barang Keluar.');
                $('#group-resi').removeClass('d-none');
                // Qty might be auto-filled from return data, but usually return qty is entered manually or capped.
                // For now allow edit.
            }
            $('#qrcode').focus();
        });

        // Handle Enter key
        $('#qrcode').on('keypress', function(e) {
            if (e.which == 13 || e.keyCode == 13) {
                e.preventDefault(); 
                var code = $(this).val();
                processScan(code);
            }
        });

        // Handle Search Button
        $('#btn-search').on('click', function() {
             var code = $('#qrcode').val();
             processScan(code);
        });
    });

    function resetForm() {
        $('#nama_barang').val('');
        $('#id_barang').val('');
        $('#qty').val('');
        $('#resi').val('');
        $('#qrcode').val('');
        $('#multiple-results-area').addClass('d-none');
        $('#multiple-results-body').empty();
        $('#single-item-container').removeClass('d-none'); // Show single form
    }

    function processScan(code) {
        if(!code) {
             Swal.fire({icon: 'info', title: 'Input Kosong', text: 'Silakan scan atau ketik kode', timer: 1500});
             return;
        }

        var mode = $('input[name="mode_switch"]:checked').val();

        if (mode === 'beli') {
            // Logic Barang Beli: Cari di Data Master (Client Side)
            searchMasterBarang(code);
        } else {
            // Logic Barang Return: Cari Resi di Server (Ajax)
            searchResiReturn(code);
        }
    }

    function searchMasterBarang(id) {
        var data = dataMaster.find(x => x.id == id);
        if (!data) {
             Swal.fire({icon: 'error', title: 'Tidak Ditemukan', text: 'ID Barang tidak ada di master.', timer: 2000});
             return;
        }
        $('#nama_barang').val(data.nama_barang);
        $('#id_barang').val(data.id);
        $('#qty').focus();
        $('#single-item-container').removeClass('d-none');
    }

    function searchResiReturn(resi) {
        // Show loader
        Swal.showLoading();
        
        $.ajax({
            url: '<?= base_url('stok-opname/barang-masuk/scan') ?>', 
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                kode_barang: resi, 
                mode: 'return'
            }),
            success: function(response) {
                Swal.close();
                if(response.status === 'success') {
                    
                    if(response.is_duplicate) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'PERINGATAN: SUDAH DIRETURN',
                            text: 'Resi ini sudah tercatat sebagai Barang Return sistem! Lanjut input lagi?',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Lanjut',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                processDisplayData(response.data, resi);
                            } else {
                                resetForm();
                            }
                        });
                    } else {
                        // Normal flow
                        processDisplayData(response.data, resi);
                    }

                } else {
                    Swal.fire({icon: 'error', title: 'Tidak Ditemukan', text: 'Resi tidak ditemukan di data Barang Keluar.'});
                }
            },
            error: function() {
                Swal.close();
                Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
            }
        });
    }

    function processDisplayData(items, resi) {
        if (items.length === 1) {
             // Single Item - Direct Fill
             fillFormReturn(items[0], resi);
             Swal.fire({
                icon: 'success', 
                title: 'Data Ditemukan', 
                text: 'Barang: ' + items[0].nama_barang,
                timer: 1500
            });
        } else {
            // Multiple Items - Show Inline Table & Hide Single Form
            showItemTable(items, resi);
             Swal.fire({
                icon: 'info', 
                title: 'Ditemukan ' + items.length + ' Barang', 
                text: 'Silakan pilih barang di tabel bawah form',
                timer: 1500
            });
        }
    }

    function fillFormReturn(item, resi) {
        $('#single-item-container').removeClass('d-none'); // Show single form
        $('#multiple-results-area').addClass('d-none'); // Optional: hide table if re-selecting single? 
        // Logic: if selecting from table, we might want to hide table OR keep it.
        // User asked: "tombol simpan pertama hilangkan" during bulk.
        // But if they select ONE from bulk, does it go to single form?
        // User said: "jangan pilih salah satu tapi bisa simpan keduanya".
        // Wait, if they select "Pilih" (green button) from table, it currently calls fillFormReturn.
        // If they click "Pilih", it implies they want to edit that single item.
        // So showing single form is correct.
        
        $('#nama_barang').val(item.nama_barang);
        $('#id_barang').val(item.id_barang_master); 
        $('#qty').val(item.qty); 
        $('#resi').val(resi);
        $('#qty').focus();
        $('#qty').select();
    }

    function showItemTable(items, resi) {
        $('#single-item-container').addClass('d-none'); // HIDE Single Form

        let rows = '';
        window.tempReturnItems = items;
        window.tempResi = resi;

        items.forEach((item, index) => {
            rows += `
                <tr>
                    <td>
                        <input type="checkbox" class="form-check-input item-checkbox" value="${index}" checked>
                    </td>
                    <td>${item.nama_barang}</td>
                    <td>${item.qty}</td>
                </tr>
            `;
        });

        $('#multiple-results-body').html(rows);
        $('#multiple-results-area').removeClass('d-none');
        
        // Handle Check All
        $('#check-all').prop('checked', true);
        $('#check-all').off('change').on('change', function() {
            $('.item-checkbox').prop('checked', $(this).prop('checked'));
        });
        
        // Handle Save Bulk
        $('#btn-save-bulk').off('click').on('click', function() {
            saveBulkData();
        });
    }

    function saveBulkData() {
        let selectedIndices = [];
        $('.item-checkbox:checked').each(function() {
            selectedIndices.push($(this).val());
        });

        if (selectedIndices.length === 0) {
            Swal.fire('Peringatan', 'Pilih minimal satu barang', 'warning');
            return;
        }

        let selectedItems = [];
        selectedIndices.forEach(idx => {
            let item = window.tempReturnItems[idx];
            selectedItems.push({
                id_barang: item.id_barang_master,
                qty: item.qty,
                nama_barang: item.nama_barang
            });
        });

        Swal.showLoading();
        $.ajax({
            url: '<?= base_url('stok-opname/barang-masuk/addBulk') ?>',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                items: selectedItems,
                resi: window.tempResi,
                jenis_barang_masuk: 'Barang Return'
            }),
            success: function(response) {
                Swal.close();
                if(response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 2000
                    }).then(() => {
                        resetForm();
                    });
                } else {
                    Swal.fire('Gagal', 'Gagal menyimpan data', 'error');
                }
            },
            error: function() {
                Swal.close();
                Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
            }
        });
    }
</script>
<?= $this->endsection(); ?>
