<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default
$routes->get('/', 'Home::index');

// 🔐 Auth
$routes->get('/login', 'AuthController::showLogin');
$routes->post('/api/login', 'AuthController::login');

// 📊 Dashboard
$routes->get('/dashboard', 'DashboardController::index');

// 📍 City (Protected by JWT)
$routes->group('api/cities', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'CityController::index');
    $routes->post('/', 'CityController::create');
});

// 🧍 Sensus (Protected by JWT)
$routes->group('api/sensus', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'SensusController::index');
    $routes->post('/', 'SensusController::create');
    $routes->put('(:num)', 'SensusController::update/$1');
    $routes->delete('(:num)', 'SensusController::delete/$1');
});
