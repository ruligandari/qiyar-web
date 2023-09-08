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


// Dashboard group dengan filter auth

$routes->group('dashboard', ['filter' => 'authFilter'], function ($routes) {
    // Dashboard
    $routes->get('/', 'Dashboard\DashboardController::index', ['filter' => 'advFilter']);

    // profile
    $routes->group('profile', function ($routes) {
        $routes->get('/', 'Dashboard\ProfileController::index');
        $routes->post('update', 'Dashboard\ProfileController::update');
    });


    $routes->group('advertiser', function ($routes) {
        // pengeluaran adv
        $routes->get('pengeluaran-advertiser', 'Dashboard\AdvertiserController::pengeluaranadv', ['filter' => 'roleFilter']);
        $routes->get('pengeluaran-advertiser/edit/(:any)', 'Dashboard\AdvertiserController::editpengeluaran/$1', ['filter' => 'advFilter']);
        $routes->post('pengeluaran-advertiser/update', 'Dashboard\AdvertiserController::updatepengeluaran', ['filter' => 'advFilter']);
        $routes->post('pengeluaran-advertiser/delete', 'Dashboard\AdvertiserController::deletepengeluaran', ['filter' => 'advFilter']);
        $routes->get('tambah-data-pengeluaran-advertiser', 'Dashboard\AdvertiserController::tambahdatapengeluaranadv', ['filter' => 'advFilter']);
        $routes->post('tambah-data-pengeluaran-advertiser/add', 'Dashboard\AdvertiserController::addpengeluaranadv', ['filter' => 'advFilter']);

        // pemasukan adv
        $routes->get('pemasukan-advertiser', 'Dashboard\PemasukanAdvertiserController::index');
        $routes->get('tambah-data-pemasukan-advertiser', 'Dashboard\PemasukanAdvertiserController::tambahdatapemasukanadv');
        $routes->post('tambah-data-pemasukan-advertiser/add', 'Dashboard\PemasukanAdvertiserController::add');
        $routes->post('pemasukan-advertiser/delete', 'Dashboard\PemasukanAdvertiserController::delete');
        $routes->get('pemasukan-advertiser/edit/(:any)', 'Dashboard\PemasukanAdvertiserController::edit/$1');
        $routes->post('pemasukan-advertiser/update', 'Dashboard\PemasukanAdvertiserController::update');

        // jenis pengeluaran
        $routes->get('pengeluaran-kantor', 'Dashboard\PengeluaranKantorController::index');
        $routes->get('tambah-data-pengeluaran-kantor', 'Dashboard\PengeluaranKantorController::tambahdatapengeluarankantor');
        $routes->post('pengeluaran-kantor/add', 'Dashboard\PengeluaranKantorController::add');
        $routes->post('pengeluaran-kantor/delete', 'Dashboard\PengeluaranKantorController::delete');
        $routes->get('pengeluaran-kantor/edit/(:any)', 'Dashboard\PengeluaranKantorController::edit/$1');
        $routes->post('pengeluaran-kantor/update', 'Dashboard\PengeluaranKantorController::update');

        // karyawan adv
        $routes->get('karyawan-advertiser', 'Dashboard\KaryawanAdvertiserController::index');
        $routes->get('karyawan-advertiser/tambah', 'Dashboard\KaryawanAdvertiserController::tambah');
        $routes->post('karyawan-advertiser/add', 'Dashboard\KaryawanAdvertiserController::add');
        $routes->post('karyawan-advertiser/update', 'Dashboard\KaryawanAdvertiserController::update');
        $routes->post('karyawan-advertiser/delete', 'Dashboard\KaryawanAdvertiserController::delete');
        $routes->get('karyawan-advertiser/edit/(:any)', 'Dashboard\KaryawanAdvertiserController::edit/$1');

        // uang transfer adv
        $routes->get('uang-transfer-advertiser', 'Dashboard\UangTransferBroadcastController::uangtransferadvertiser');
    });

    $routes->group('warehouse-kuningan', function ($routes) {
        // warehouse kuningan
        $routes->get('/', 'Dashboard\WarehouseKuninganController::index');
        $routes->get('edit/(:any)', 'Dashboard\WarehouseKuninganController::editBarangMasuk/$1');
        $routes->post('delete', 'Dashboard\WarehouseKuninganController::deleteBarangMasuk');
        $routes->get('tambah', 'Dashboard\WarehouseKuninganController::tambahBarangMasuk');
        $routes->post('update', 'Dashboard\WarehouseKuninganController::updateBarangMasuk');
        $routes->post('add', 'Dashboard\WarehouseKuninganController::addBarangMasuk');

        $routes->get('stok', 'Dashboard\WarehouseKuninganController::stokBarang');
        $routes->get('stok/tambah', 'Dashboard\WarehouseKuninganController::tambahStokBarang');
        $routes->post('stok/add', 'Dashboard\WarehouseKuninganController::addStokBarang');
        $routes->post('stok/delete', 'Dashboard\WarehouseKuninganController::deleteStokBarang');
        $routes->post('stok/update', 'Dashboard\WarehouseKuninganController::updateStokBarang');
        $routes->get('stok/edit/(:any)', 'Dashboard\WarehouseKuninganController::editStokBarang/$1');

        $routes->get('keluar/tambah', 'Dashboard\WarehouseKuninganController::tambahBarangKeluar');
        $routes->post('keluar/add', 'Dashboard\WarehouseKuninganController::addBarangKeluar');
        $routes->get('keluar/edit/(:any)', 'Dashboard\WarehouseKuninganController::editBarangKeluar/$1');
        $routes->post('keluar/update', 'Dashboard\WarehouseKuninganController::updateBarangKeluar');
        $routes->post('keluar/delete', 'Dashboard\WarehouseKuninganController::deleteBarangKeluar');
    });

    $routes->group('warehouse-jakarta', function ($routes) {
        // warehouse jakarta
        $routes->get('/', 'Dashboard\WarehouseJakartaController::index');
        $routes->get('edit/(:any)', 'Dashboard\WarehouseJakartaController::editBarangMasuk/$1');
        $routes->post('delete', 'Dashboard\WarehouseJakartaController::deleteBarangMasuk');
        $routes->get('tambah', 'Dashboard\WarehouseJakartaController::tambahBarangMasuk');
        $routes->post('update', 'Dashboard\WarehouseJakartaController::updateBarangMasuk');
        $routes->post('add', 'Dashboard\WarehouseJakartaController::addBarangMasuk');

        $routes->get('keluar/tambah', 'Dashboard\WarehouseJakartaController::tambahBarangKeluar');
        $routes->post('keluar/add', 'Dashboard\WarehouseJakartaController::addBarangKeluar');
        $routes->get('keluar/edit/(:any)', 'Dashboard\WarehouseJakartaController::editBarangKeluar/$1');
        $routes->post('keluar/update', 'Dashboard\WarehouseJakartaController::updateBarangKeluar');
        $routes->post('keluar/delete', 'Dashboard\WarehouseJakartaController::deleteBarangKeluar');

        $routes->get('stok', 'Dashboard\WarehouseJakartaController::stokBarang');
        $routes->get('stok/tambah', 'Dashboard\WarehouseJakartaController::tambahStokBarang');
        $routes->post('stok/add', 'Dashboard\WarehouseJakartaController::addStokBarang');
        $routes->post('stok/delete', 'Dashboard\WarehouseJakartaController::deleteStokBarang');
        $routes->post('stok/update', 'Dashboard\WarehouseJakartaController::updateStokBarang');
        $routes->get('stok/edit/(:any)', 'Dashboard\WarehouseJakartaController::editStokBarang/$1');
    });

    $routes->group('broadcast', function ($routes) {
        // uang transfer bc
        $routes->get('uang-transfer-broadcast', 'Dashboard\UangTransferBroadcastController::index');
        $routes->get('uang-transfer-broadcast/tambah', 'Dashboard\UangTransferBroadcastController::tambahdatauangtransferbc');
        $routes->post('uang-transfer-broadcast/add', 'Dashboard\UangTransferBroadcastController::add');
        $routes->get('uang-transfer-broadcast/edit/(:any)', 'Dashboard\UangTransferBroadcastController::edit/$1');
        $routes->post('uang-transfer-broadcast/update', 'Dashboard\UangTransferBroadcastController::update');
        $routes->post('uang-transfer-broadcast/delete', 'Dashboard\UangTransferBroadcastController::delete');

        // pengeluaran bc
        $routes->get('pengeluaran-broadcast', 'Dashboard\PengeluaranBroadcastController::index');
        $routes->get('pengeluaran-broadcast/tambah', 'Dashboard\PengeluaranBroadcastController::tambahdatapengeluaranbroadcast');
        $routes->post('pengeluaran-broadcast/add', 'Dashboard\PengeluaranBroadcastController::add');
        $routes->get('pengeluaran-broadcast/edit/(:any)', 'Dashboard\PengeluaranBroadcastController::edit/$1');
        $routes->post('pengeluaran-broadcast/update', 'Dashboard\PengeluaranBroadcastController::update');
        $routes->post('pengeluaran-broadcast/delete', 'Dashboard\PengeluaranBroadcastController::delete');

        // pemasukan bc
        $routes->get('pemasukan-broadcast', 'Dashboard\PemasukanBroadcastController::index');
        $routes->get('pemasukan-broadcast/tambah', 'Dashboard\PemasukanBroadcastController::tambahdatapemasukanbroadcast');
        $routes->get('pemasukan-broadcast/edit/(:any)', 'Dashboard\PemasukanBroadcastController::edit/$1');
        $routes->post('pemasukan-broadcast/update', 'Dashboard\PemasukanBroadcastController::update');
        $routes->post('pemasukan-broadcast/add', 'Dashboard\PemasukanBroadcastController::add');
        $routes->post('pemasukan-broadcast/delete', 'Dashboard\PemasukanBroadcastController::delete');
    });

    $routes->group('lamaran', function ($routes) {
        // lamaran
        $routes->get('/', 'Dashboard\LamaranController::index');
        $routes->post('delete', 'Dashboard\LamaranController::delete');
        $routes->post('tambah-lamaran', 'Dashboard\LamaranController::tambahdata');
    });
});

// restricted page
$routes->get('restrictedpage', 'Admin\LoginController::restrictedpage');

// $routes->get('tutup-buku', 'Dashboard\TutupBukuController::index');
// $routes->get('tutup-buku/tambah', 'Dashboard\TutupBukuController::tambah');
// $routes->post('tutup-buku/add', 'Dashboard\TutupBukuController::add');
// $routes->get('tutup-buku/edit/(:any)', 'Dashboard\TutupBukuController::edit/$1');
// $routes->post('tutup-buku/update', 'Dashboard\TutupBukuController::update');
// $routes->post('tutup-buku/delete', 'Dashboard\TutupBukuController::delete');

// $routes->get('data-advertiser', 'Dashboard\AdvertiserController::index', ['filter' => 'roleFilter']);
// $routes->post('data-advertiser/delete', 'Dashboard\AdvertiserController::delete', ['filter' => 'advFilter']);
// $routes->get('data-advertiser/edit/(:any)', 'Dashboard\AdvertiserController::edit/$1', ['filter' => 'advFilter']);
// $routes->post('data-advertiser/update', 'Dashboard\AdvertiserController::update', ['filter' => 'advFilter']);
// $routes->get('tambah-data-advertiser', 'Dashboard\AdvertiserController::tambahdata', ['filter' => 'advFilter']);
// $routes->post('tambah-data-advertiser/add', 'Dashboard\AdvertiserController::add', ['filter' => 'advFilter']);

// $routes->get('data-produk', 'Dashboard\ProdukController::index');
// $routes->get('tambah-data-produk', 'Dashboard\ProdukController::tambahdata');
// $routes->post('tambah-data-produk/add', 'Dashboard\ProdukController::add');
// $routes->get('edit-data-produk/(:any)', 'Dashboard\ProdukController::edit/$1');
// $routes->post('edit-data-produk/update', 'Dashboard\ProdukController::update');
// $routes->post('data-produk/delete', 'Dashboard\ProdukController::delete');




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
