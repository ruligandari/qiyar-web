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
                <a href="<?= base_url('stok-opname/barang-masuk') ?>">
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
                
                <!-- Toggle Switch Beli / Return -->
                <div class="d-flex justify-content-center mb-4">
                    <div class="btn-group" role="group" aria-label="Mode">
                        <input type="radio" class="btn-check" name="mode_switch" id="mode_beli" value="beli" checked>
                        <label class="btn btn-outline-primary" for="mode_beli">Barang Beli</label>

                        <input type="radio" class="btn-check" name="mode_switch" id="mode_return" value="return">
                        <label class="btn btn-outline-primary" for="mode_return">Barang Return</label>
                    </div>
                </div>

                <form action="<?= base_url('stok-opname/barang-masuk/add') ?>" method="POST">
                    <!-- Hidden input to store mode -->
                    <input type="hidden" name="jenis_barang_masuk" id="jenis_barang_masuk" value="Barang Beli">
                    
                    <div id="reader" width="600px"></div>
                    
                    <div id="single-item-container">
                        <div class="form-group mt-3">
                            <label class="form-label" id="label-scan" for="message">Nama Barang</label>
                            <input class="form-control" id="message" name="nama_barang" placeholder="Scan Kode QR/Resi" value="" readonly>
                            <input class="form-control" id="id_barang" name="id_barang" value="" hidden>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="qty">Qty</label>
                            <input class="form-control" id="qty" name="qty" placeholder="Masukan Qty">
                        </div>
                        <!-- Input Resi (Hidden by default, shown for Return) -->
                        <div class="form-group d-none" id="group-resi">
                            <label class="form-label" for="resi">Nomor Resi (Referensi)</label>
                            <input class="form-control" id="resi" name="resi" placeholder="Nomor Resi" readonly>
                        </div>

                        <button class="btn btn-primary w-100 mt-3" type="submit">Simpan</button>
                    </div>
                </form>

                <!-- Multiple Results Container -->
                <div id="multiple-results-area" class="mt-4 d-none">
                    <h6 class="text-muted mb-2">Hasil Pencarian:</h6>
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
                    <button class="btn btn-primary w-100 mt-3" type="button" id="btn-save-bulk">
                        <i class="bi bi-save"></i> Simpan Terpilih
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-3"></div>
</div>

<?= $this->endsection(); ?>

<?= $this->section('script'); ?>
<!-- Use CDNJS for stability -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
     // Data Master (For 'Beli' Mode)
    var dataMaster = <?php echo json_encode($data); ?>;

    // Handle Mode Logic Visuals
    $('input[name="mode_switch"]').change(function() {
        var mode = $(this).val();
        resetForm();
        
        if(mode === 'beli') {
            $('#jenis_barang_masuk').val('Barang Beli');
            $('#label-scan').text('Nama Barang');
            $('#message').attr('placeholder', 'Scan Kode QR Barang...');
            $('#group-resi').addClass('d-none');
        } else {
            $('#jenis_barang_masuk').val('Barang Return');
            $('#label-scan').text('Hasil Scan Resi');
            $('#message').attr('placeholder', 'Scan QR Resi...');
            $('#group-resi').removeClass('d-none');
        }
    });

    function resetForm() {
        $('#message').val('');
        $('#id_barang').val('');
        $('#qty').val('');
        $('#resi').val('');
        $('#multiple-results-area').addClass('d-none');
        $('#multiple-results-body').empty();
        $('#single-item-container').removeClass('d-none'); // Show single
    }

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code matched = ${decodedText}`, decodedResult);
        var mode = $('input[name="mode_switch"]:checked').val();

        if (mode === 'beli') {
            // Logic Barang Beli: Match with local master data
            var data = dataMaster.find(x => x.id == decodedText);
            if (!data) {
                // Try comparing Strings just in case
                data = dataMaster.find(x => x.id == decodedText.toString());
            }

            if (data) {
                // Success
                document.getElementById('message').value = data.nama_barang;
                document.getElementById('id_barang').value = data.id;
                $('#single-item-container').removeClass('d-none');
                // document.getElementById('qty').focus(); 
                // Play success sound or vibrate?
                // alert("Barang Ditemukan!");
            } else {
                Swal.fire({icon: 'error', title: 'Tidak Ditemukan', text: 'Barang tidak terdaftar', timer: 1500});
            }

        } else {
            // Logic Barang Return: Server lookup by Resi
            fetch('<?= base_url('stok-opname/barang-masuk/scan/') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    kode_barang: decodedText,
                    mode: 'return'
                })
            }).then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if(html5QrcodeScanner) html5QrcodeScanner.pause(); // Pause camera while showing alert

                    if(data.is_duplicate) {
                         Swal.fire({
                            icon: 'warning',
                            title: 'SUDAH DIRETURN',
                            text: 'Resi ini sudah tercatat sebagai Barang Return! Lanjut?',
                            showCancelButton: true,
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#d33',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                processDisplayData(data.data, decodedText);
                            } else {
                                if(html5QrcodeScanner) html5QrcodeScanner.resume();
                                resetForm();
                            }
                        });
                    } else {
                        processDisplayData(data.data, decodedText);
                    }
                } else {
                    Swal.fire({icon: 'error', title: 'Gagal', text: 'Resi tidak ditemukan', timer: 1500});
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }

    function processDisplayData(items, resi) {
        if (items.length === 1) {
            var item = items[0];
            selectReturnItem(item, resi);
            Swal.fire({icon: 'success', title: 'Resi Ditemukan', text: 'Barang: '+item.nama_barang, timer: 1500})
            .then(() => {
                 if(html5QrcodeScanner) html5QrcodeScanner.resume();
            });
        } else {
            showItemTable(items, resi);
             Swal.fire({
                icon: 'info', 
                title: 'Ditemukan ' + items.length + ' Barang', 
                text: 'Silakan pilih barang di tabel bawah form',
                timer: 1500
            });
        }
    }

    function selectReturnItem(item, resi) {
        $('#single-item-container').removeClass('d-none'); // Show single input
        document.getElementById('message').value = item.nama_barang;
        document.getElementById('id_barang').value = item.id_barang_master;
        document.getElementById('qty').value = item.qty;
        document.getElementById('resi').value = resi;
    }

    function showItemTable(items, resi) {
        $('#single-item-container').addClass('d-none'); // HIDE Single Input Block

        let rows = '';
        window.tempItems = items;
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
        
        document.getElementById('multiple-results-area').scrollIntoView({ behavior: 'smooth' });

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
            let item = window.tempItems[idx];
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
                        if(html5QrcodeScanner) html5QrcodeScanner.resume();
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

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
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