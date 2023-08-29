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

    $routes->get('pengeluaran-advertiser', 'dashboard\AdvertiserController::pengeluaranadv');
    $routes->get('pengeluaran-advertiser/edit/(:any)', 'dashboard\AdvertiserController::editpengeluaran/$1');
    $routes->post('pengeluaran-advertiser/update', 'dashboard\AdvertiserController::updatepengeluaran');
    $routes->post('pengeluaran-advertiser/delete', 'dashboard\AdvertiserController::deletepengeluaran');
    $routes->get('tambah-data-pengeluaran-advertiser', 'dashboard\AdvertiserController::tambahdatapengeluaranadv');
    $routes->post('tambah-data-pengeluaran-advertiser/add', 'dashboard\AdvertiserController::addpengeluaranadv');
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
