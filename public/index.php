<?php

use App\App;
use App\Router;
use Illuminate\Container\Container;

require __DIR__ . '/../vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/../views');
define('STORAGE_PATH', __DIR__ . '/../storage');
define('ROUTES_PATH', __DIR__ . '/../routes');

session_start();

$container = new Container();
$router = new Router($container);

(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
))->boot()->run();
