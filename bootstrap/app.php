<?php

use App\App;
use App\Router;
use Illuminate\Container\Container;

$container = new Container();
$router = new Router($container);

$request = [
    'uri' => $_SERVER['REQUEST_URI'] ?? '',
    'method' => $_SERVER['REQUEST_METHOD'] ?? '',
];

$app = (new App(
    $container,
    $router,
    ['uri' => $request['uri'], 'method' => $request['method']],
));

return $app;
