<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// homepage
$routes->get('/', 'Home::index');
$routes->get('lamaran', 'Home::lamaran');


// login
$routes->get('login', 'Admin\LoginController::index');
$routes->post('auth', 'Admin\LoginController::login');
$routes->get('logout', 'Admin\LoginController::logout');


// dashboard group dengan filter auth

$routes->group('dashboard', ['filter' => 'authFilter'], function ($routes) {
    // dashboard
    $routes->get('/', 'dashboard\DashboardController::index', ['filter' => 'advFilter']);

    // profile
    $routes->group('profile', function ($routes) {
        $routes->get('/', 'dashboard\ProfileController::index');
        $routes->post('update', 'dashboard\ProfileController::update');
    });


    $routes->group('advertiser', function ($routes) {
        // pengeluaran adv
        $routes->get('pengeluaran-advertiser', 'dashboard\AdvertiserController::pengeluaranadv', ['filter' => 'roleFilter']);
        $routes->get('pengeluaran-advertiser/edit/(:any)', 'dashboard\AdvertiserController::editpengeluaran/$1', ['filter' => 'advFilter']);
        $routes->post('pengeluaran-advertiser/update', 'dashboard\AdvertiserController::updatepengeluaran', ['filter' => 'advFilter']);
        $routes->post('pengeluaran-advertiser/delete', 'dashboard\AdvertiserController::deletepengeluaran', ['filter' => 'advFilter']);
        $routes->get('tambah-data-pengeluaran-advertiser', 'dashboard\AdvertiserController::tambahdatapengeluaranadv', ['filter' => 'advFilter']);
        $routes->post('tambah-data-pengeluaran-advertiser/add', 'dashboard\AdvertiserController::addpengeluaranadv', ['filter' => 'advFilter']);

        // pemasukan adv
        $routes->get('pemasukan-advertiser', 'dashboard\PemasukanAdvertiserController::index');
        $routes->get('tambah-data-pemasukan-advertiser', 'dashboard\PemasukanAdvertiserController::tambahdatapemasukanadv');
        $routes->post('tambah-data-pemasukan-advertiser/add', 'dashboard\PemasukanAdvertiserController::add');
        $routes->post('pemasukan-advertiser/delete', 'dashboard\PemasukanAdvertiserController::delete');
        $routes->get('pemasukan-advertiser/edit/(:any)', 'dashboard\PemasukanAdvertiserController::edit/$1');
        $routes->post('pemasukan-advertiser/update', 'dashboard\PemasukanAdvertiserController::update');

        // jenis pengeluaran
        $routes->get('pengeluaran-kantor', 'dashboard\PengeluaranKantorController::index');
        $routes->get('tambah-data-pengeluaran-kantor', 'dashboard\PengeluaranKantorController::tambahdatapengeluarankantor');
        $routes->post('pengeluaran-kantor/add', 'dashboard\PengeluaranKantorController::add');
        $routes->post('pengeluaran-kantor/delete', 'dashboard\PengeluaranKantorController::delete');
        $routes->get('pengeluaran-kantor/edit/(:any)', 'dashboard\PengeluaranKantorController::edit/$1');
        $routes->post('pengeluaran-kantor/update', 'dashboard\PengeluaranKantorController::update');

        // karyawan adv
        $routes->get('karyawan-advertiser', 'dashboard\KaryawanAdvertiserController::index');
        $routes->get('karyawan-advertiser/tambah', 'dashboard\KaryawanAdvertiserController::tambah');
        $routes->post('karyawan-advertiser/add', 'dashboard\KaryawanAdvertiserController::add');
        $routes->post('karyawan-advertiser/update', 'dashboard\KaryawanAdvertiserController::update');
        $routes->post('karyawan-advertiser/delete', 'dashboard\KaryawanAdvertiserController::delete');
        $routes->get('karyawan-advertiser/edit/(:any)', 'dashboard\KaryawanAdvertiserController::edit/$1');

        // uang transfer adv
        $routes->get('uang-transfer-advertiser', 'dashboard\UangTransferBroadcastController::uangtransferadvertiser');
    });

    $routes->group('warehouse-kuningan', function ($routes) {
        // warehouse kuningan
        $routes->get('/', 'dashboard\WarehouseKuninganController::index');
        $routes->get('edit/(:any)', 'dashboard\WarehouseKuninganController::editBarangMasuk/$1');
        $routes->post('delete', 'dashboard\WarehouseKuninganController::deleteBarangMasuk');
        $routes->get('tambah', 'dashboard\WarehouseKuninganController::tambahBarangMasuk');
        $routes->post('update', 'dashboard\WarehouseKuninganController::updateBarangMasuk');
        $routes->post('add', 'dashboard\WarehouseKuninganController::addBarangMasuk');

        $routes->get('stok', 'dashboard\WarehouseKuninganController::stokBarang');
        $routes->get('stok/tambah', 'dashboard\WarehouseKuninganController::tambahStokBarang');
        $routes->post('stok/add', 'dashboard\WarehouseKuninganController::addStokBarang');
        $routes->post('stok/delete', 'dashboard\WarehouseKuninganController::deleteStokBarang');
        $routes->post('stok/update', 'dashboard\WarehouseKuninganController::updateStokBarang');
        $routes->get('stok/edit/(:any)', 'dashboard\WarehouseKuninganController::editStokBarang/$1');

        $routes->get('keluar/tambah', 'dashboard\WarehouseKuninganController::tambahBarangKeluar');
        $routes->post('keluar/add', 'dashboard\WarehouseKuninganController::addBarangKeluar');
        $routes->get('keluar/edit/(:any)', 'dashboard\WarehouseKuninganController::editBarangKeluar/$1');
        $routes->post('keluar/update', 'dashboard\WarehouseKuninganController::updateBarangKeluar');
        $routes->post('keluar/delete', 'dashboard\WarehouseKuninganController::deleteBarangKeluar');
    });

    $routes->group('warehouse-jakarta', function ($routes) {
        // warehouse jakarta
        $routes->get('/', 'dashboard\WarehouseJakartaController::index');
        $routes->get('edit/(:any)', 'dashboard\WarehouseJakartaController::editBarangMasuk/$1');
        $routes->post('delete', 'dashboard\WarehouseJakartaController::deleteBarangMasuk');
        $routes->get('tambah', 'dashboard\WarehouseJakartaController::tambahBarangMasuk');
        $routes->post('update', 'dashboard\WarehouseJakartaController::updateBarangMasuk');
        $routes->post('add', 'dashboard\WarehouseJakartaController::addBarangMasuk');

        $routes->get('keluar/tambah', 'dashboard\WarehouseJakartaController::tambahBarangKeluar');
        $routes->post('keluar/add', 'dashboard\WarehouseJakartaController::addBarangKeluar');
        $routes->get('keluar/edit/(:any)', 'dashboard\WarehouseJakartaController::editBarangKeluar/$1');
        $routes->post('keluar/update', 'dashboard\WarehouseJakartaController::updateBarangKeluar');
        $routes->post('keluar/delete', 'dashboard\WarehouseJakartaController::deleteBarangKeluar');

        $routes->get('stok', 'dashboard\WarehouseJakartaController::stokBarang');
        $routes->get('stok/tambah', 'dashboard\WarehouseJakartaController::tambahStokBarang');
        $routes->post('stok/add', 'dashboard\WarehouseJakartaController::addStokBarang');
        $routes->post('stok/delete', 'dashboard\WarehouseJakartaController::deleteStokBarang');
        $routes->post('stok/update', 'dashboard\WarehouseJakartaController::updateStokBarang');
        $routes->get('stok/edit/(:any)', 'dashboard\WarehouseJakartaController::editStokBarang/$1');
    });

    $routes->group('broadcast', function ($routes) {
        // uang transfer bc
        $routes->get('uang-transfer-broadcast', 'dashboard\UangTransferBroadcastController::index');
        $routes->get('uang-transfer-broadcast/tambah', 'dashboard\UangTransferBroadcastController::tambahdatauangtransferbc');
        $routes->post('uang-transfer-broadcast/add', 'dashboard\UangTransferBroadcastController::add');
        $routes->get('uang-transfer-broadcast/edit/(:any)', 'dashboard\UangTransferBroadcastController::edit/$1');
        $routes->post('uang-transfer-broadcast/update', 'dashboard\UangTransferBroadcastController::update');
        $routes->post('uang-transfer-broadcast/delete', 'dashboard\UangTransferBroadcastController::delete');

        // pengeluaran bc
        $routes->get('pengeluaran-broadcast', 'dashboard\PengeluaranBroadcastController::index');
        $routes->get('pengeluaran-broadcast/tambah', 'dashboard\PengeluaranBroadcastController::tambahdatapengeluaranbroadcast');
        $routes->post('pengeluaran-broadcast/add', 'dashboard\PengeluaranBroadcastController::add');
        $routes->get('pengeluaran-broadcast/edit/(:any)', 'dashboard\PengeluaranBroadcastController::edit/$1');
        $routes->post('pengeluaran-broadcast/update', 'dashboard\PengeluaranBroadcastController::update');
        $routes->post('pengeluaran-broadcast/delete', 'dashboard\PengeluaranBroadcastController::delete');

        // pemasukan bc
        $routes->get('pemasukan-broadcast', 'dashboard\PemasukanBroadcastController::index');
        $routes->get('pemasukan-broadcast/tambah', 'dashboard\PemasukanBroadcastController::tambahdatapemasukanbroadcast');
        $routes->get('pemasukan-broadcast/edit/(:any)', 'dashboard\PemasukanBroadcastController::edit/$1');
        $routes->post('pemasukan-broadcast/update', 'dashboard\PemasukanBroadcastController::update');
        $routes->post('pemasukan-broadcast/add', 'dashboard\PemasukanBroadcastController::add');
        $routes->post('pemasukan-broadcast/delete', 'dashboard\PemasukanBroadcastController::delete');
    });

    $routes->group('lamaran', function ($routes) {
        // lamaran
        $routes->get('/', 'dashboard\LamaranController::index');
        $routes->post('delete', 'dashboard\LamaranController::delete');
        $routes->post('tambah-lamaran', 'dashboard\LamaranController::tambahdata');
    });
});

// restricted page
$routes->get('restrictedpage', 'Admin\LoginController::restrictedpage');

// $routes->get('tutup-buku', 'dashboard\TutupBukuController::index');
// $routes->get('tutup-buku/tambah', 'dashboard\TutupBukuController::tambah');
// $routes->post('tutup-buku/add', 'dashboard\TutupBukuController::add');
// $routes->get('tutup-buku/edit/(:any)', 'dashboard\TutupBukuController::edit/$1');
// $routes->post('tutup-buku/update', 'dashboard\TutupBukuController::update');
// $routes->post('tutup-buku/delete', 'dashboard\TutupBukuController::delete');

// $routes->get('data-advertiser', 'dashboard\AdvertiserController::index', ['filter' => 'roleFilter']);
// $routes->post('data-advertiser/delete', 'dashboard\AdvertiserController::delete', ['filter' => 'advFilter']);
// $routes->get('data-advertiser/edit/(:any)', 'dashboard\AdvertiserController::edit/$1', ['filter' => 'advFilter']);
// $routes->post('data-advertiser/update', 'dashboard\AdvertiserController::update', ['filter' => 'advFilter']);
// $routes->get('tambah-data-advertiser', 'dashboard\AdvertiserController::tambahdata', ['filter' => 'advFilter']);
// $routes->post('tambah-data-advertiser/add', 'dashboard\AdvertiserController::add', ['filter' => 'advFilter']);

// $routes->get('data-produk', 'dashboard\ProdukController::index');
// $routes->get('tambah-data-produk', 'dashboard\ProdukController::tambahdata');
// $routes->post('tambah-data-produk/add', 'dashboard\ProdukController::add');
// $routes->get('edit-data-produk/(:any)', 'dashboard\ProdukController::edit/$1');
// $routes->post('edit-data-produk/update', 'dashboard\ProdukController::update');
// $routes->post('data-produk/delete', 'dashboard\ProdukController::delete');




/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
