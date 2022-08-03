<?php

use App\Controllers\HomeController;
use App\Controllers\TaskController;
use App\Router;

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/task', [TaskController::class, 'index']);

$router->register('get', '/test', function () {
    echo 'Test';
});

echo $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
