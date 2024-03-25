<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// $routes->get('/', 'Home::index');
// $routes->get('/peliculas', 'Pelicula::index');

$routes->get('/', 'Home::index');
$routes->presenter("pelicula");
$routes->presenter("categoria");
