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
    $routes->get('/', 'dashboard\DashboardController::index', ['filter' => 'advFilter']);
    $routes->get('data-advertiser', 'dashboard\AdvertiserController::index', ['filter' => 'roleFilter']);
    $routes->post('data-advertiser/delete', 'dashboard\AdvertiserController::delete', ['filter' => 'advFilter']);
    $routes->get('data-advertiser/edit/(:any)', 'dashboard\AdvertiserController::edit/$1', ['filter' => 'advFilter']);
    $routes->post('data-advertiser/update', 'dashboard\AdvertiserController::update', ['filter' => 'advFilter']);
    $routes->get('tambah-data-advertiser', 'dashboard\AdvertiserController::tambahdata', ['filter' => 'advFilter']);
    $routes->post('tambah-data-advertiser/add', 'dashboard\AdvertiserController::add', ['filter' => 'advFilter']);

    $routes->get('pengeluaran-advertiser', 'dashboard\AdvertiserController::pengeluaranadv', ['filter' => 'roleFilter']);
    $routes->get('pengeluaran-advertiser/edit/(:any)', 'dashboard\AdvertiserController::editpengeluaran/$1', ['filter' => 'advFilter']);
    $routes->post('pengeluaran-advertiser/update', 'dashboard\AdvertiserController::updatepengeluaran', ['filter' => 'advFilter']);
    $routes->post('pengeluaran-advertiser/delete', 'dashboard\AdvertiserController::deletepengeluaran', ['filter' => 'advFilter']);
    $routes->get('tambah-data-pengeluaran-advertiser', 'dashboard\AdvertiserController::tambahdatapengeluaranadv', ['filter' => 'advFilter']);
    $routes->post('tambah-data-pengeluaran-advertiser/add', 'dashboard\AdvertiserController::addpengeluaranadv', ['filter' => 'advFilter']);
    $routes->post('data-advertiser', 'dashboard\AdvertiserController::filterTanggal');

    $routes->get('data-produk', 'dashboard\ProdukController::index');
    $routes->get('tambah-data-produk', 'dashboard\ProdukController::tambahdata');
    $routes->post('tambah-data-produk/add', 'dashboard\ProdukController::add');
    $routes->get('edit-data-produk/(:any)', 'dashboard\ProdukController::edit/$1');
    $routes->post('edit-data-produk/update', 'dashboard\ProdukController::update');
    $routes->post('data-produk/delete', 'dashboard\ProdukController::delete');

    $routes->get('lamaran', 'dashboard\LamaranController::index');
    $routes->post('lamaran/delete', 'dashboard\LamaranController::delete');
    $routes->post('tambah-lamaran', 'dashboard\LamaranController::tambahdata');

    $routes->get('pemasukan-advertiser', 'dashboard\PemasukanAdvertiserController::index');
    $routes->get('tambah-data-pemasukan-advertiser', 'dashboard\PemasukanAdvertiserController::tambahdatapemasukanadv');
    $routes->post('tambah-data-pemasukan-advertiser/add', 'dashboard\PemasukanAdvertiserController::add');
    $routes->post('pemasukan-advertiser/delete', 'dashboard\PemasukanAdvertiserController::delete');
    $routes->get('pemasukan-advertiser/edit/(:any)', 'dashboard\PemasukanAdvertiserController::edit/$1');
    $routes->post('pemasukan-advertiser/update', 'dashboard\PemasukanAdvertiserController::update');

    $routes->get('pengeluaran-kantor', 'dashboard\PengeluaranKantorController::index');
    $routes->get('tambah-data-pengeluaran-kantor', 'dashboard\PengeluaranKantorController::tambahdatapengeluarankantor');
    $routes->post('pengeluaran-kantor/add', 'dashboard\PengeluaranKantorController::add');
    $routes->post('pengeluaran-kantor/delete', 'dashboard\PengeluaranKantorController::delete');
    $routes->get('pengeluaran-kantor/edit/(:any)', 'dashboard\PengeluaranKantorController::edit/$1');
    $routes->post('pengeluaran-kantor/update', 'dashboard\PengeluaranKantorController::update');

    $routes->get('karyawan-advertiser', 'dashboard\KaryawanAdvertiserController::index');
    $routes->get('karyawan-advertiser/tambah', 'dashboard\KaryawanAdvertiserController::tambah');
    $routes->post('karyawan-advertiser/add', 'dashboard\KaryawanAdvertiserController::add');
    $routes->post('karyawan-advertiser/update', 'dashboard\KaryawanAdvertiserController::update');
    $routes->post('karyawan-advertiser/delete', 'dashboard\KaryawanAdvertiserController::delete');
    $routes->get('karyawan-advertiser/edit/(:any)', 'dashboard\KaryawanAdvertiserController::edit/$1');

    $routes->get('tutup-buku', 'dashboard\TutupBukuController::index');
    $routes->get('tutup-buku/tambah', 'dashboard\TutupBukuController::tambah');
    $routes->post('tutup-buku/add', 'dashboard\TutupBukuController::add');
    $routes->get('tutup-buku/edit/(:any)', 'dashboard\TutupBukuController::edit/$1');
    $routes->post('tutup-buku/update', 'dashboard\TutupBukuController::update');
    $routes->post('tutup-buku/delete', 'dashboard\TutupBukuController::delete');


    $routes->get('warehouse-kuningan', 'dashboard\WarehouseKuninganController::index');
    $routes->get('warehouse-kuningan/edit/(:any)', 'dashboard\WarehouseKuninganController::editBarangMasuk/$1');
    $routes->post('warehouse-kuningan/delete', 'dashboard\WarehouseKuninganController::deleteBarangMasuk');
    $routes->get('warehouse-kuningan/tambah', 'dashboard\WarehouseKuninganController::tambahBarangMasuk');
    $routes->post('warehouse-kuningan/update', 'dashboard\WarehouseKuninganController::updateBarangMasuk');
    $routes->post('warehouse-kuningan/stok', 'dashboard\WarehouseKuninganController::tambahQtyBarangMasuk');
    $routes->post('warehouse-kuningan/add', 'dashboard\WarehouseKuninganController::addBarangMasuk');

    $routes->get('warehouse-kuningan-keluar/tambah', 'dashboard\WarehouseKuninganController::tambahBarangKeluar');


    $routes->get('warehouse-jakarta', 'dashboard\WarehouseController::index');

    $routes->get('pemasukan-broadcast', 'dashboard\PemasukanBroadcastController::index');
    $routes->get('pemasukan-broadcast/tambah', 'dashboard\PemasukanBroadcastController::tambahdatapemasukanbc');
    $routes->post('pemasukan-broadcast/add', 'dashboard\PemasukanBroadcastController::add');
    $routes->get('pemasukan-broadcast/edit/(:any)', 'dashboard\PemasukanBroadcastController::edit/$1');
    $routes->post('pemasukan-broadcast/update', 'dashboard\PemasukanBroadcastController::update');
    $routes->post('pemasukan-broadcast/delete', 'dashboard\PemasukanBroadcastController::delete');
});

// restricted page
$routes->get('restrictedpage', 'Admin\LoginController::restrictedpage');


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
