<?php

use App\App;
use App\Controllers\CurlController;
use App\Router;
use App\Controllers\HomeController;
use App\Controllers\TaskController;
use Illuminate\Container\Container;

require __DIR__ . '/../vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/../views');
define('STORAGE_PATH', __DIR__ . '/../storage');

session_start();

$container = new Container();
$router = new Router($container);

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/task', [TaskController::class, 'index'])
    ->get('/curl', [CurlController::class, 'index']);

$router->register('get', '/test', function () {
    echo 'Test';
});

(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
))->boot()->run();
