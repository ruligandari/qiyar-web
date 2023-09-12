<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('/') ?>css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url('/') ?>css/date-range-filter.css" rel="stylesheet">
    <link href="<?= base_url('/') ?>css/select2.min.css" rel="stylesheet">
    <link href="<?= base_url('/') ?>css/select2-bootstrap4.min.css" rel="stylesheet">
    <!-- daterange picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <?= $this->renderSection('header'); ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon bg-light">
                    <img src="<?= base_url('/logo/logo.png') ?>" alt="" srcset="" style="width: 30px; height:30px;">
                </div>
                <div class="sidebar-brand-text mx-3">Qiyar Media</div>
            </a>


            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= $title == 'Dashboard' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <?php if (session()->get('role') == '1' || session()->get('role') == '6' || session()->get('role') == '7' || session()->get('role') == '3' || session()->get('role') == '2') : ?>
                <div class="sidebar-heading text-white">
                    Warehouse
                </div>

                <li class="nav-item <?= $title == 'Warehouse' ? 'active' : '' ?>">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-warehouse"></i>
                        <span>Warehouse</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Daftar Gudang :</h6>
                            <a class="collapse-item" href="<?= base_url('dashboard/warehouse-kuningan') ?>" <?= session()->get('role') == '7' ? 'hidden' : '' ?>>Kuningan</a>
                            <a class="collapse-item" href="<?= base_url('dashboard/warehouse-jakarta') ?>" <?= session()->get('role') == '6' ? 'hidden' : '' ?>>Jakarta</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (session()->get('role') == '1' || session()->get('role') == '3') : ?>
                <!-- Divider -->
                <hr class="sidebar-divider">
                <div class="sidebar-heading text-white">
                    Advertiser
                </div>
                <li class="nav-item <?= $title == 'Karyawan Advertiser' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('dashboard/advertiser/karyawan-advertiser') ?>">
                        <i class="fas fa-fw fa-file"></i>
                        <span>Karyawan Advertiser</span></a>
                </li>
            <?php endif; ?>
            <?php if (session()->get('role') == '1' || session()->get('role') == '5' || session()->get('role') == '4' || session()->get('role') == '3') : ?>
                <li class="nav-item <?= $title == 'Pengeluaran Advertiser' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('dashboard/advertiser/pengeluaran-advertiser') ?>">
                        <i class="fas fa-fw fa-file"></i>
                        <span>Pengeluaran Advertiser</span></a>
                </li>
            <?php endif; ?>
            <?php if (session()->get('role') == '1' || session()->get('role') == '4' || session()->get('role') == '3') : ?>
                <li class="nav-item <?= $title == 'Pemasukan Advertiser' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('dashboard/advertiser/pemasukan-advertiser') ?>">
                        <i class="fas fa-fw fa-file"></i>
                        <span>Pemasukan Advertiser</span></a>
                </li>
                <li class="nav-item <?= $title == 'Pengeluaran Kantor' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('dashboard/advertiser/pengeluaran-kantor') ?>">
                        <i class="fas fa-fw fa-file"></i>
                        <span>Jenis Pengeluaran</span></a>
                </li>
                <li class="nav-item <?= $title == 'Uang Transfer' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('dashboard/advertiser/uang-transfer-advertiser') ?>">
                        <i class="fas fa-fw fa-file"></i>
                        <span>Uang Transfer</span></a>
                </li>
                <!-- <li class="nav-item <?= $title == 'Pemasukan Advertiser' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('dashboard/data-advertiser') ?>">
                        <i class="fas fa-fw fa-file"></i>
                        <span>Pemasukan Advertiser</span></a>
                </li> -->
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->
            <?php endif; ?>
            <?php if (session()->get('role') == '2' || session()->get('role') == '1') : ?>
                <div class="sidebar-heading text-white">
                    Broadcast
                </div>
                <li class="nav-item <?= $title == 'Pemasukan Broadcast' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('dashboard/broadcast/pemasukan-broadcast') ?>">
                        <i class="fas fa-fw fa-file"></i>
                        <span>Pemasukan Broadcast</span></a>
                </li>
                <li class="nav-item <?= $title == 'Uang Transfer Broadcast' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('dashboard/broadcast/uang-transfer-broadcast') ?>">
                        <i class="fas fa-fw fa-file"></i>
                        <span>Uang Transfer</span></a>
                </li>
                <li class="nav-item <?= $title == 'Pengeluaran Broadcast' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('dashboard/broadcast/pengeluaran-broadcast') ?>">
                        <i class="fas fa-fw fa-file"></i>
                        <span>Jenis Pengeluaran</span></a>
                </li>
                <hr class="sidebar-divider">
            <?php endif; ?>
            <?php if (session()->get('role') == 1) : ?>
                <!-- Heading -->
                <div class="sidebar-heading text-white">
                    Requitment
                </div>
                <li class="nav-item <?= $title == 'Lamaran' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('dashboard/lamaran') ?>">
                        <i class="fas fa-fw fa-plus"></i>
                        <span>Lamaran</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider">
            <?php endif; ?>
            <?php //endif; 
            ?>
            <!-- Heading -->
            <div class="sidebar-heading text-white">
                Logout
            </div>
            <li class="nav-item <?= $title == 'Lamaran' ? 'active' : '' ?>">
                <a class="nav-link active" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Addons
            </div> -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= session('nama'); ?></span>
                                <img class="img-profile rounded-circle" src="<?= base_url() ?>img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('dashboard/profile') ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <?php if (session()->get('role') == '3') : ?>
                                    <a class="dropdown-item" href="<?= base_url('dashboard/setting') ?>">
                                        <i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Pengaturan Akun
                                    </a>
                                <?php endif ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <?= $this->renderSection('content') ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; CV. Qiyar Media <?= date('Y') ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin ingin keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" untuk keluar dan mengakhiri sesi</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?= $this->renderSection('custom-js'); ?>
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url() ?>/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url() ?>/js/demo/chart-area-demo.js"></script>
    <script src="<?= base_url() ?>/js/demo/chart-pie-demo.js"></script>
    <?= $this->renderSection('script') ?>
</body>

</html>