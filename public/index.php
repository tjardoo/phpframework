<?php

use App\Controllers\HomeController;
use App\Router;

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router->register('/', [HomeController::class, 'index']);

$router->register('/test', function () {
    echo 'Test';
});

echo $router->resolve($_SERVER['REQUEST_URI']);
