<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Home::index');

// ==========================
// 🔐 AUTHENTICATION ROUTES
// ==========================
$routes->group('api', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->post('login', 'AuthController::login'); // Login JWT
});

// ==========================
// 📍 MASTER DATA: CITY
// ==========================
$routes->group('api/cities', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'CityController::index');   // GET List kota (pagination & search)
    $routes->post('/', 'CityController::create'); // POST tambah kota baru
});

// ==========================
// 🧍 TRANSAKSI: SENSUS
// ==========================
$routes->group('api/sensus', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'SensusController::index');     // GET List sensus (join city)
    $routes->post('/', 'SensusController::create');   // POST tambah sensus
    $routes->put('(:num)', 'SensusController::update/$1'); // PUT update sensus
    $routes->delete('(:num)', 'SensusController::delete/$1'); // DELETE sensus
});
