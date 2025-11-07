<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::register');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/dashboard', 'DashboardController::index');
$routes->post('api/login', 'AuthController::login');
$routes->group('api', function ($routes) {
    $routes->post('login', 'AuthController::login');
    // City (Master)
    $routes->get('cities', 'CityController::index');
    $routes->post('cities', 'CityController::create');
    // Sensus (Transaksi)
    $routes->get('sensus', 'SensusController::index');
    $routes->post('sensus', 'SensusController::create');
    $routes->put('sensus/(:num)', 'SensusController::update/$1');
    $routes->delete('sensus/(:num)', 'SensusController::delete/$1');
});
