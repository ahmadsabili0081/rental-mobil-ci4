<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', ['filter' => 'cifilter:auth'], static function ($routes) {

});

$routes->group('auth', ['filter' => 'cifilter:guest'], static function ($routes) {
  $routes->get('login', 'Auth::index', ['as' => 'auth.index']);
  $routes->post('proses_submit_login', 'Auth::proses_submit_login', ['as' => 'auth.proses_submit_login']);
  $routes->get('register', 'Auth::register', ['as' => 'auth.register']);
  $routes->post('proses_submit', 'Auth::proses_submit', ['as' => 'auth.proses_submit']);
});
