<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/user', 'User::index');

// $routes->get('/', 'Admin::index', ['as' => 'admin.index']);
$routes->group('admin', ['filter' => 'cifilter:auth'], static function ($routes) {
  $routes->get('/', 'Admin::index');

  // user Listing
  $routes->group('user', static function ($routes) {
    $routes->get('', 'Admin::user', ['as' => 'admin.user.index']);
    $routes->post('action_user/(:any)', 'Admin::action_user/$1', ['as' => 'admin.user.action_user']);
  });

  // car Listing
  $routes->group('car', static function ($routes) {
    $routes->get('', 'Admin::car', ['as' => 'admin.car.index']);
    $routes->post('action_car/(:any)', 'Admin::action_car/$1', ['as' => 'admin.car.action_car']);
  });

  $routes->group('role', static function ($routes) {
    $routes->get('', 'Admin::role', ['as' => 'admin.role.index']);
  });

});

$routes->group('auth', ['filter' => 'cifilter:guest'], static function ($routes) {
  $routes->get('login', 'Auth::index', ['as' => 'auth.index']);
  $routes->post('proses_submit_login', 'Auth::proses_submit_login', ['as' => 'auth.proses_submit_login']);
  $routes->get('register', 'Auth::register', ['as' => 'auth.register']);
  $routes->post('proses_submit', 'Auth::proses_submit', ['as' => 'auth.proses_submit']);
});
$routes->get('logout', 'Auth::logout', ['as' => 'auth.logout']);


