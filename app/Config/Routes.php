<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Home::index');

// Dashboard route
$routes->get('dashboard', 'DashboardController::index');

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
    $routes->get('/', 'CityController::index');
    $routes->post('/', 'CityController::create');
});

// ==========================
// 🧍 TRANSAKSI: SENSUS
// ==========================
$routes->group('api/sensus', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'SensusController::index');
    $routes->post('/', 'SensusController::create');
    $routes->put('(:num)', 'SensusController::update/$1');
    $routes->delete('(:num)', 'SensusController::delete/$1');
});
