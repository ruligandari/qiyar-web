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
    <!-- Add New Contact -->


    <div id="loader-container" class="container" style="display: none;">
        <div class="card bg-primary">
            <div class="card-body py-5">
                <!-- Dot Loader -->
                <div class="dot-loader">
                    <div class="dot1"></div>
                    <div class="dot2"></div>
                    <div class="dot3"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card mb-2">
            <div class="card-body p-2">
                <div class="chat-search-box">
                    <!-- Search Form -->
                    <form id="searchForm" onsubmit="event.preventDefault(); loadData(1);">
                        <div class="input-group">
                            <span class="input-group-text" id="searchbox">
                                <i class="bi bi-search"></i>
                            </span>
                            <input class="form-control" type="search" placeholder="Cari barang"
                                aria-describedby="searchbox" id="searchInput" name="q">
                        </div>
                    </form>

                    <div class="d-flex gap-2 mt-3">
                        <a class="btn btn-primary w-50 d-flex align-items-center justify-content-center gap-2" href="<?= base_url('stok-opname/barang-masuk/scan') ?>">
                            <i class="bi bi-camera"></i> Scan Kamera
                        </a>
                        <a class="btn btn-warning w-50 d-flex align-items-center justify-content-center gap-2" href="<?= base_url('stok-opname/barang-masuk/scan-manual') ?>">
                            <i class="bi bi-upc-scan"></i> Scan Barcode
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- Loader -->
        <div id="loader-spinner" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Memuat data...</p>
        </div>

        <!-- Chat User List -->
        <ul class="ps-0 chat-user-list" id="dataList" style="display: none;">
            <!-- Data loaded via JS -->
        </ul>
        
        <div class="card mt-2">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between" id="pagerContainer">
                    <!-- Pager loaded via JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    // Global variables to hold filter state
    let globalStart = null;
    let globalEnd = null;
    let globalType = null;

    $(document).ready(function() {
        // Parse URL Parameters
        const urlParams = new URLSearchParams(window.location.search);
        globalStart = urlParams.get('start_date');
        globalEnd = urlParams.get('end_date');
        globalType = urlParams.get('type');

        // Initial Load
        loadData(1);

        // Live Search with Debounce
        let debounceTimer;
        $('#searchInput').on('keyup', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                loadData(1);
            }, 500); // Delay 500ms
        });
    });

    function loadData(page) {
        var query = $('#searchInput').val();
        
        // Show Loader, Hide List
        $('#loader-spinner').show();
        $('#dataList').hide();
        $('#pagerContainer').hide();

        $.ajax({
            url: '<?= base_url('stok-opname/barang-masuk/get-list') ?>',
            type: 'POST',
            data: {
                q: query,
                page: page,
                start_date: globalStart,
                end_date: globalEnd,
                jenis_barang_masuk: globalType
            },
            success: function(response) {
                // Hide Loader
                $('#loader-spinner').hide();
                $('#dataList').empty().show();
                $('#pagerContainer').empty().show().html(response.pager);

                if (response.data.length === 0) {
                    $('#dataList').html('<div class="text-center p-3 text-muted">Tidak ada data.</div>');
                    return;
                }

                // Helper Escape function
                function escapeHtml(text) {
                    if (text == null) return '';
                    return String(text)
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;");
                }

                // Render List
                $.each(response.data, function(index, item) {
                    // Badge Color logic
                    let jenisBadge = (item.jenis_barang_masuk == 'Barang Beli') ? 'bg-success' : 'bg-warning';
                    
                    var html = `
                        <li class="p-3 chat-unread">
                            <a class="d-flex" href="#">
                                <div class="chat-user-info">
                                    <h6 class="text-truncate mb-0">${escapeHtml(item.nama_barang)}</h6>
                                    <div class="last-chat">
                                        <div class="col d-flex justify-content-between">
                                            <p class="mb-0 text-truncate">
                                                <span class="badge rounded-pill bg-success">${escapeHtml(item.tanggal)}</span>
                                            </p>
                                            <p class="mb-0 text-truncate">qty:
                                                <span class="badge rounded-pill bg-primary">${escapeHtml(item.qty)}</span>
                                            </p>

                                            <p class="mb-0 text-truncate">
                                                <span class="badge rounded-pill ${jenisBadge}">${escapeHtml(item.jenis_barang_masuk)}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <div class="dropstart chat-options-btn">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" onclick="editBarang(${item.id})"><i class="bi bi-pencil"></i>Edit</a></li>
                                    <li><a href="#" onclick="deleteBarang(${item.id}) "><i class="bi bi-trash"></i>Hapus</a></li>
                                </ul>
                            </div>
                        </li>
                    `;
                    $('#dataList').append(html);
                });

                // Re-bind click events for pagination links
                $('#pagerContainer a').on('click', function(e) {
                    e.preventDefault();
                    var href = $(this).attr('href');
                    if(href) {
                        // Extract page number from URL ?page_stok_barang=X
                        var urlParams = new URLSearchParams(href.split('?')[1]);
                        var pageNum = urlParams.get('page_stok_barang'); 
                        if(pageNum) {
                            loadData(pageNum);
                        }
                    }
                });
            },
            error: function() {
                $('#loader-spinner').hide();
                Swal.fire('Gagal', 'Terjadi kesalahan memuat data', 'error');
            }
        });
    }
</script>

<!-- modal -->
<div class="add-new-contact-modal modal fade px-0" id="addBarang" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="addnewcontactlabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="modal-title" id="addnewcontactlabel">Tambah Barang Masuk</h6>
                    <button class="btn btn-close p-1 ms-auto me-0" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form action="<?= base_url('stok-opname/barang-masuk/add') ?>" method="POST">
                    <!-- <div class="input-group mb-3">
                        <span class="input-group-text" id="to">To</span>
                        <input class="form-control" type="text" placeholder="" aria-label="Username" aria-describedby="to">
                    </div> -->
                    <div id="reader" width="600px"></div>
                    <div class="form-group">
                        <label class="form-label" for="message">Nama Barang</label>
                        <input class="form-control" id="message" name="nama_barang" placeholder="Scan Kode QR" value="" readonly>
                        <input class="form-control" id="message" name="id_barang" placeholder="Masukan Qty" value="" hidden>
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
                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- edit Modal -->
<div class="add-new-contact-modal modal fade px-0" id="editBarang" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="addnewcontactlabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="modal-title" id="addnewcontactlabel">Tambah Barang Baru</h6>
                    <button class="btn btn-close p-1 ms-auto me-0" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form action="<?= base_url('stok-opname/barang-masuk/update') ?>" method="POST">
                    <!-- <div class="input-group mb-3">
                        <span class="input-group-text" id="to">To</span>
                        <input class="form-control" type="text" placeholder="" aria-label="Username" aria-describedby="to">
                    </div> -->
                    <div class="form-group">
                        <label class="form-label" for="message">Tanggal</label>
                        <input type="date" class="form-control" id="message" name="tanggal" placeholder="Tanggal" value="<?= date('Y-m-d') ?>" readonly>
                        <input type="text" name="id" hidden>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="message">Nama Barang</label>
                        <input class="form-control" id="message" name="nama_barang" placeholder="Masukan Nama Barang" required readonly>
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
                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function deleteBarang(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Menghapus Data Barang Masuk, Akan Mengurangi Stok Barang",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('stok-opname/barang-masuk/delete') ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'success') {

                            Swal.fire(
                                'Berhasil!',
                                'Data berhasil dihapus.',
                                'success'
                            ).then(() => {
                                location.reload();
                            })
                        } else {
                            Swal.fire(
                                'Gagal!',
                                response.message,
                                'warning'
                            ).then(() => {
                                location.reload();
                            })
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Data gagal dihapus.',
                            'error'
                        )
                    }
                })
            }
        })

    }

    function editBarang(id) {
        // fecth data dengan id menggunakan ajax
        $.ajax({
            url: '<?= base_url('stok-opname/barang-masuk/edit') ?>',
            type: 'POST',
            data: {
                id: id
            },
            success: function(response) {
                // tampilkan modal dan masukan data ke dalam form
                $('#editBarang').modal('show');
                $('#editBarang input[name="nama_barang"]').val(response.nama_barang);
                $('#editBarang input[name="qty"]').val(response.qty);
                // tanggal
                $('#editBarang input[name="tanggal"]').val(response.tanggal);
                $('#editBarang input[name="id"]').val(response.id);
                // jenis barang masuk
                $('#editBarang select[name="jenis_barang_masuk"]').val(response.jenis_barang_masuk);


            },
            error: function() {
                Swal.fire(
                    'Gagal!',
                    'gagal mengambil data',
                    'error'
                )
            }
        })
    }
</script>
<?= $this->endsection(); ?>

<?= $this->section('script'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        console.log(`Code matched = ${decodedText}`, decodedResult);
        // request ke server
        fetch('<?= base_url('stok-opname/barang-masuk/scan/') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    kode_barang: decodedText
                })
            }).then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.querySelector('input[name=nama_barang]').value = data.data.nama_barang;
                    document.querySelector('input[name=id_barang]').value = data.data.id;

                    // reload halaman ini
                    //window.location.reload();
                } else {
                    alert('Data tidak ditemukan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = null;

    $('#addBarang').on('shown.bs.modal', function () {
        if (html5QrcodeScanner === null) {
            html5QrcodeScanner = new Html5QrcodeScanner(
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
        }
    });

    $('#addBarang').on('hidden.bs.modal', function () {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().then(_ => {
                // scanning stopped.
                html5QrcodeScanner = null;
            }).catch(error => {
                // could not stop.
                console.error("Failed to clear html5QrcodeScanner. ", error);
            });
        }
    });
</script>

<?= $this->endsection(); ?>