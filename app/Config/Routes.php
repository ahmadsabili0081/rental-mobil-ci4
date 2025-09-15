<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', ['filter' => 'cifilter:auth'], static function ($routes) {

});

$routes->group('auth', ['filter' => 'cifilter:guest'], static function ($routes) {
  $routes->get('login', 'Auth::index', ['as' => 'admin.index']);
  $routes->get('register', 'Auth::register', ['as' => 'admin.register']);
  $routes->post('proses_submit', 'Auth::proses_submit', ['as' => 'admin.proses_submit']);
});
