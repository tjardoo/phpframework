<?php

use App\App;
use App\Container;
use App\Router;
use App\Controllers\HomeController;
use App\Controllers\TaskController;

require __DIR__ . '/../vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/../views');

session_start();

$container = new Container();
$router = new Router($container);

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/task', [TaskController::class, 'index']);

$router->register('get', '/test', function () {
    echo 'Test';
});

(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
))->boot()->run();
