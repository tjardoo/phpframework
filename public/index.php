<?php

use App\App;
use App\Router;
use App\Controllers\HomeController;
use App\Controllers\TaskController;

require __DIR__ . '/../vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/../views');

$router = new Router();

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/task', [TaskController::class, 'index']);

$router->register('get', '/test', function () {
    echo 'Test';
});

(new App($router, ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]))->run();
