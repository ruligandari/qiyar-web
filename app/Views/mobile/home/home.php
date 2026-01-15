<?= $this->extend('mobile/layouts'); ?>

<?= $this->section('content'); ?>

<!-- Header Area -->
<div class="header-area" id="headerArea">
    <div class="container">

        <!-- # Header Five Layout -->
        <!-- Header Content -->
        <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
            <!-- Logo Wrapper -->
            <div class="logo-wrapper">
                <a href="<?= base_url('stok-opname') ?>">
                    <img src="<?= base_url('mobile') ?>/img/core-img/logo-2.png" alt="">
                </a>
            </div>

            <!-- Navbar Toggler -->
            <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas" data-bs-target="#affanOffcanvas"
                aria-controls="affanOffcanvas">
                <span class="d-block"></span>
                <span class="d-block"></span>
                <span class="d-block"></span>
            </div>
        </div>
        <!-- # Header Five Layout End -->

    </div>
</div>
<!-- Offcanvas Start -->
<div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1"
    aria-labelledby="affanOffcanvsLabel">

    <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas"
        aria-label="Close"></button>

    <div class="offcanvas-body p-0">
        <div class="sidenav-wrapper">
            <!-- Sidenav Profile -->
            <div class="sidenav-profile bg-gradient">
                <div class="sidenav-style1"></div>

                <!-- User Thumbnail -->

                <!-- User Info -->
                <div class="user-info">
                    <h6 class="user-name mb-0"><?= session()->get('nama') ?></h6>
                    <span><?= session()->get('email') ?></span>
                </div>
            </div>

            <!-- Sidenav Nav -->
            <ul class="sidenav-nav ps-0">
                <li>
                    <a href="<?= base_url('stok-opname/profile') ?>"><i class="bi bi-person"></i> Profile</a>
                </li>
                <li>
                    <div class="night-mode-nav">
                        <i class="bi bi-moon"></i> Night Mode
                        <div class="form-check form-switch">
                            <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
                        </div>
                    </div>
                </li>
                <li>
                    <a onclick="logout()"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </li>
            </ul>

            <!-- Social Info -->

            <!-- Copyright Info -->
            <div class="copyright-info">
                <p>
                    <span id="copyrightYear"></span>
                    &copy; Made by <a href="#">CV Qiyarmedia</a>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="page-content-wrapper py-3">
    <!-- Tiny Slider One Wrapper -->
    <div class="container">
        <div class="card card-bg-img bg-img bg-success mb-3">
            <div class="card-body p-3">
                <p class="text-white mb-0">Selamat Datang, Di Aplikasi Stok Opname Qiyarmedia</p>
            </div>
        </div>
    </div>
    
    <!-- Stats Dashboard & Filter -->
    <div class="container direction-rtl mb-3">
        
        <!-- Date Filter -->
        <!-- Date Filter -->
        <div class="card mb-3">
            <div class="card-body p-2 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark px-2">Data Stok Gudang</h6>
                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 8px;" class="shadow-sm">
                    <i class="bi bi-funnel-fill text-primary" style="font-size: 1.2rem;"></i>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="row g-2">
            <div class="col-6">
                <!-- Card Putih, Teks Hijau -->
                <div class="card bg-white mb-2 shadow-sm border-0" onclick="showDetails('beli')" style="cursor: pointer;">
                    <div class="card-body p-2 d-flex align-items-center">
                        <div class="icon-circle bg-success-subtle text-success me-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                            <i class="bi bi-cart-check fs-5"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-success fw-bold" id="val-masuk-beli"><?= number_format($stats['masuk_beli'] ?? 0) ?></h5>
                            <small class="text-secondary" style="font-size: 0.7rem;">Total Barang Beli</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <!-- Card Putih, Teks Biru -->
                <div class="card bg-white mb-2 shadow-sm border-0" onclick="showDetails('return')" style="cursor: pointer;">
                     <div class="card-body p-2 d-flex align-items-center">
                        <div class="icon-circle bg-info-subtle text-info me-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                            <i class="bi bi-arrow-return-left fs-5"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-info fw-bold" id="val-masuk-return"><?= number_format($stats['masuk_return'] ?? 0) ?></h5>
                            <small class="text-secondary" style="font-size: 0.7rem;">Total Barang Return</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <!-- Card Putih, Teks Merah -->
                <div class="card bg-white mb-2 shadow-sm border-0" onclick="showDetails('keluar')" style="cursor: pointer;">
                     <div class="card-body p-2 d-flex align-items-center">
                         <div class="icon-circle bg-danger-subtle text-danger me-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                        </div>
                        <div>
                             <h5 class="mb-0 text-danger fw-bold" id="val-keluar"><?= number_format($stats['keluar'] ?? 0) ?></h5>
                             <small class="text-secondary" style="font-size: 0.7rem;">Total Barang Keluar</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <!-- Card Putih, Teks Kuning (Warning) -->
                <div class="card bg-white mb-2 shadow-sm border-0" onclick="showDetails('resi')" style="cursor: pointer;">
                     <div class="card-body p-2 d-flex align-items-center">
                        <div class="icon-circle bg-warning-subtle text-warning me-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                            <i class="bi bi-receipt fs-5"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-warning fw-bold" id="val-resi"><?= number_format($stats['resi'] ?? 0) ?></h5>
                            <small class="text-secondary" style="font-size: 0.7rem;">Total Resi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container direction-rtl">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-1">
                    <div class="col-4">
                        <div class="feature-card mx-auto text-center">
                            <div class="card mx-auto bg-gray">
                                <!-- image link -->
                                <a href="<?= base_url('stok-opname/master-barang/') ?>">
                                    <img src="<?= base_url('mobile') ?>/assets/technical-support.png" alt="">
                                </a>
                            </div>
                            <p class="mb-0">Master Barang</p>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="feature-card mx-auto text-center">
                            <div class="card mx-auto bg-gray">
                                <!-- image link -->
                                <a href="<?= base_url('stok-opname/barang-masuk') ?>">
                                    <img src="<?= base_url('mobile') ?>/assets/barangmasuk.png" alt="">
                                </a>
                            </div>
                            <p class="mb-0">Barang Masuk</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="feature-card mx-auto text-center">
                            <div class="card mx-auto bg-gray">
                                <!-- image link -->
                                <a href="<?= base_url('stok-opname/barang-keluar') ?>">
                                    <img src="<?= base_url('mobile') ?>/assets/barangkeluar.png" alt="">
                                </a>
                            </div>
                            <p class="mb-0">Barang Keluar</p>
                        </div>
                    </div>
                </div>
                <div class="row g-1 mt-2">
                    <div class="col-4">
                        <div class="feature-card mx-auto text-center">
                            <div class="card mx-auto bg-gray">
                                <a href="<?= base_url('stok-opname/bulk-barcode') ?>">
                                    <img src="<?= base_url('mobile') ?>/assets/barcode.webp" alt=""> 
                                    <!-- Note: using barcode.png as placeholder, assuming asset might not exist yet, but link works -->
                                </a>
                            </div>
                            <p class="mb-0">Cetak Barcode</p>
                        </div>
                    </div>
                </div>
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

<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    // Track current dates
    var currentStart = moment().format('YYYY-MM-DD');
    var currentEnd = moment().format('YYYY-MM-DD');

    $(document).ready(function() {
        // Initialize DateRangePicker
        var start = moment();
        var end = moment();

        function cb(start, end) {
            // $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            
            // Update tracking variables
            currentStart = start.format('YYYY-MM-DD');
            currentEnd = end.format('YYYY-MM-DD');
            
            updateStats(currentStart, currentEnd);
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end); // Initial call
    });

    function showDetails(type) {
        let url = '';
        const params = `?start_date=${currentStart}&end_date=${currentEnd}`;

        if(type === 'beli') {
            url = `<?= base_url('stok-opname/barang-masuk') ?>${params}&type=Barang Beli`;
        } else if (type === 'return') {
            url = `<?= base_url('stok-opname/barang-masuk') ?>${params}&type=Barang Return`;
        } else if (type === 'keluar') {
            url = `<?= base_url('stok-opname/barang-keluar') ?>${params}`;
        } else if (type === 'resi') {
            // Resi info usually comes from Barang Keluar data
            url = `<?= base_url('stok-opname/barang-keluar') ?>${params}`;
        }

        if(url) {
            window.location.href = url;
        }
    }

    function updateStats(start, end) {
        // Show loading state
        Swal.showLoading();

        $.ajax({
            url: '<?= base_url('stok-opname/home/get-stats') ?>',
            type: 'POST',
            data: {
                start_date: start,
                end_date: end
            },
            success: function(response) {
                Swal.close();
                if(response.status === 'success') {
                    // Update DOM
                    let fmt = new Intl.NumberFormat('en-US'); 
                    
                    $('#val-masuk-beli').text(fmt.format(response.stats.masuk_beli));
                    $('#val-masuk-return').text(fmt.format(response.stats.masuk_return));
                    $('#val-keluar').text(fmt.format(response.stats.keluar));
                    $('#val-resi').text(fmt.format(response.stats.resi));

                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function() {
                Swal.close();
                // Swal.fire('Error', 'Gagal mengambil data', 'error');
            }
        });
    }

    function logout() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda Akan Keluar Dari Aplikasi Ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('m/logout') ?>',
                    type: 'POST',
                    success: function() {
                        location.href = '<?= base_url('m/login') ?>';
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
</script>

<?= $this->endsection(); ?>