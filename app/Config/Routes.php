<?php

use App\Controllers\Pages;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::index');

$routes->get('/anggota', 'AnggotaController::index');
$routes->post('/anggota/save', 'AnggotaController::save');
$routes->delete('/anggota/(:num)', 'AnggotaController::delete/$1');
$routes->put('/anggota/update/(:num)', 'AnggotaController::update/$1');

$routes->get('/koperasi', 'KoperasiController::index');
$routes->post('/koperasi/save', 'KoperasiController::save');
$routes->delete('/koperasi/(:num)', 'KoperasiController::delete/$1');
$routes->put('/koperasi/update/(:num)', 'KoperasiController::update/$1');

$routes->get('/transaksi', 'TransaksiController::index');
$routes->post('/transaksi/save', 'TransaksiController::save');
$routes->delete('/transaksi/(:num)', 'TransaksiController::delete/$1');

