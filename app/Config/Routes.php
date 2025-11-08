<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==========================
// 🏠 DEFAULT ROUTE
// ==========================
$routes->get('/', 'Home::index');

// ==========================
// 📊 DASHBOARD ROUTE
// ==========================
$routes->get('dashboard', 'DashboardController::index');

// ==========================
// 🔐 AUTHENTICATION ROUTES
// ==========================
$routes->group('api', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->post('login', 'AuthController::login'); // Login JWT
});

// ==========================
// 📍 MASTER DATA: CITY (Protected by JWT)
// ==========================
$routes->group('api/cities', [
    'namespace' => 'App\Controllers',
    'filter'    => 'auth' // 🔒 Proteksi pakai JWT AuthFilter
], function ($routes) {
    $routes->get('/', 'CityController::index');
    $routes->post('/', 'CityController::create');
});

// ==========================
// 🧍 TRANSAKSI: SENSUS (Protected by JWT)
// ==========================
$routes->group('api/sensus', [
    'namespace' => 'App\Controllers',
    'filter'    => 'auth' // 🔒 Proteksi juga
], function ($routes) {
    $routes->get('/', 'SensusController::index');
    $routes->post('/', 'SensusController::create');
    $routes->put('(:num)', 'SensusController::update/$1');
    $routes->delete('(:num)', 'SensusController::delete/$1');
});
