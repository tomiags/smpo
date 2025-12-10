<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', function () {
    return redirect()->to('/login');
});

$routes->get('/login', 'Auth::login', ['as' => 'login']);
$routes->post('/login', 'Auth::attemptLogin');

$routes->get('/home', 'Home::index', ['filter' => 'login']);

/*
|--------------------------------------------------------------------------
| MASTER DATA ROUTES
|--------------------------------------------------------------------------
*/

// MANAJEMEN USER
$routes->group('users', ['filter' => ['login', 'role:admin']], function($routes) {
    $routes->get('/',                     'Users::index');
    $routes->get('getUsers',              'Users::getUsers');
    $routes->post('store',                'Users::store');
    $routes->get('show/(:num)',           'Users::show/$1');
    $routes->post('update/(:num)',        'Users::update/$1');
    $routes->get('delete/(:num)',         'Users::delete/$1');
    $routes->post('toggle/(:num)',        'Users::toggle/$1');
});

// MANAJEMEN POOL
$routes->group('pool', ['filter' => ['login', 'role:admin']], function($routes) {
    $routes->get('/',                 'Pool::index');
    $routes->get('getPool',           'Pool::getPool');
    $routes->post('store',            'Pool::store');
    $routes->get('show/(:any)',       'Pool::show/$1');
    $routes->post('update/(:any)',    'Pool::update/$1');
    $routes->get('delete/(:any)',     'Pool::delete/$1');
});

// MANAJEMEN SUPPLIER
$routes->group('supplier', ['filter' => ['login', 'role:admin']], function($routes) {
    $routes->get('/',                     'Supplier::index');
    $routes->get('getSupplier',           'Supplier::getSupplier');
    $routes->post('store',                'Supplier::store');
    $routes->get('show/(:num)',           'Supplier::show/$1');
    $routes->post('update/(:num)',        'Supplier::update/$1');
    $routes->get('delete/(:num)',         'Supplier::delete/$1');
});

// MANAJEMEN DEPARTEMEN
$routes->group('departemen', ['filter' => ['login', 'role:admin']], function($routes) {
    $routes->get('/',                     'Departemen::index');
    $routes->get('getDepartemen',         'Departemen::getDepartemen');
    $routes->post('store',                'Departemen::store');
    $routes->get('show/(:num)',           'Departemen::show/$1');
    $routes->post('update/(:num)',        'Departemen::update/$1');
    $routes->get('delete/(:num)',         'Departemen::delete/$1');
});



/*
|--------------------------------------------------------------------------
| BARANG ROUTES
|--------------------------------------------------------------------------
*/
$routes->group('barang', ['filter' => ['login', 'role:admin,purchasing']], function($routes) {
    $routes->get('/',                 'Barang::index');
    $routes->get('getBarang',         'Barang::getBarang');
    $routes->post('store',            'Barang::store');
    $routes->get('show/(:any)',       'Barang::show/$1');
    $routes->post('update/(:any)',    'Barang::update/$1');
    $routes->get('delete/(:any)',     'Barang::delete/$1');
});


/*
|--------------------------------------------------------------------------
| PURCHASING ROUTES
|--------------------------------------------------------------------------
*/
$routes->group('purchasing', ['filter' => ['login', 'role:admin,purchasing']], function($routes) {
    $routes->get('request_po', 'Purchasing::request_po');
    $routes->post('save_po', 'Purchasing::save_po');
    $routes->get('po_list', 'Purchasing::po_list');
    $routes->get('po_detail/(:num)', 'Purchasing::po_detail/$1');
    $routes->get('po_edit/(:num)', 'Purchasing::po_edit/$1');
    $routes->post('update_po/(:num)', 'Purchasing::update_po/$1');
    $routes->get('delete_po/(:num)', 'Purchasing::delete_po/$1');
    $routes->get('send_po/(:num)', 'Purchasing::send_po/$1');
    $routes->get('po_print/(:num)', 'Purchasing::po_print/$1');
});


/*
|--------------------------------------------------------------------------
| APPROVAL ROUTES
|--------------------------------------------------------------------------
*/
$routes->group('approval', ['filter' => ['login', 'role:admin,finance']], function($routes){
    $routes->get('request', 'Approval::request');
    $routes->get('detail/(:num)', 'Approval::detail/$1');
    $routes->post('approve', 'Approval::approve');
    $routes->post('reject', 'Approval::reject');
});


/*
|--------------------------------------------------------------------------
| TRANSAKSI ROUTES
|--------------------------------------------------------------------------
*/
$routes->group('transaksi', ['filter' => ['login', 'role:admin,purchasing']], function($routes) {
    $routes->get('create', 'Transaksi::create');
    $routes->post('store', 'Transaksi::store');
    $routes->get('list', 'Transaksi::list');
    $routes->get('detail/(:num)', 'Transaksi::detail/$1');
    $routes->get('edit/(:num)', 'Transaksi::edit/$1');
    $routes->post('update/(:num)', 'Transaksi::update/$1');
    $routes->get('delete/(:num)', 'Transaksi::delete/$1');
    $routes->get('search-po', 'Transaksi::searchPO');
    $routes->get('get-po/(:num)', 'Transaksi::getPO/$1');

    $routes->get('form-bayar/(:num)', 'Transaksi::formBayar/$1');
    $routes->post('simpan-bayar', 'Transaksi::simpanBayar');
    $routes->get('list_bayar', 'Transaksi::listBayar');
    $routes->get('detail-bayar/(:num)', 'Transaksi::detailBayar/$1');
    $routes->get('edit-bayar/(:num)', 'Transaksi::editBayar/$1');
    $routes->post('update-bayar/(:num)', 'Transaksi::updateBayar/$1');
    $routes->get('delete-bayar/(:num)', 'Transaksi::deleteBayar/$1');
});
