<?php

use App\Controllers\Api\AlternatifController;
use App\Controllers\Api\DashboardController;
use App\Controllers\Api\HasilController;
use App\Controllers\Api\KriteriaController;
use App\Controllers\Api\PenilaianController;
use App\Controllers\Api\SubKriteriaController;
use App\Controllers\Api\UserController;
use App\Controllers\Frontend\Manage;
use App\Controllers\Migrate;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->addPlaceholder('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

service('auth')->routes($routes);

$routes->environment('development', static function ($routes) {
    $routes->get('migrate', [Migrate::class, 'index']);
    $routes->get('migrate/(:any)', [Migrate::class, 'execute']);
    $routes->get('data-check', 'DataCheck::index');
});

$routes->group('kelola', static function (RouteCollection $routes) {
    $routes->get('', [Manage::class, 'index']);
    $routes->get('alternatif', [Manage::class, 'alternatif']);
    $routes->get('kriteria', [Manage::class, 'kriteria']);
    $routes->get('subkriteria', [Manage::class, 'subkriteria']);
    $routes->get('penilaian', [Manage::class, 'penilaian']);
    $routes->get('implementasi', [Manage::class, 'implementasi']);
    $routes->get('hasil', [Manage::class, 'hasil']);
    $routes->get('user', [Manage::class, 'user']);
});

$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    $routes->group('v2', ['namespace' => 'App\Controllers\Api'], static function ($routes) {});
    $routes->get('dashboard', 'DashboardController::index');
    $routes->resource('alternatif', ['namespace' => '', 'controller' => AlternatifController::class, 'websafe' => 1]);
    $routes->get('kriteria/subkriteria/(:uuid)', 'KriteriaController::subkriteria/$1');
    $routes->resource('kriteria', ['namespace' => '', 'controller' => KriteriaController::class, 'websafe' => 1]);
    $routes->resource('subkriteria', ['namespace' => '', 'controller' => SubKriteriaController::class, 'websafe' => 1]);
    $routes->post('penilaian/save', 'PenilaianController::save');
    $routes->resource('penilaian', ['namespace' => '', 'controller' => PenilaianController::class, 'websafe' => 1]);
    $routes->post('hasil/save', 'HasilController::save');
    $routes->resource('hasil', ['namespace' => '', 'controller' => HasilController::class, 'websafe' => 1]);

    $routes->resource('user', ['namespace' => '', 'controller' => UserController::class, 'websafe' => 1]);
});
