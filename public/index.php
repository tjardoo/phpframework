<?php

use App\App;
use App\Config;
use App\Router;
use Dotenv\Dotenv;
use App\Controllers\HomeController;
use App\Controllers\TaskController;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('VIEW_PATH', __DIR__ . '/../views');

$router = new Router();

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/task', [TaskController::class, 'index']);

$router->register('get', '/test', function () {
    echo 'Test';
});

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config([])
))->run();
