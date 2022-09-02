<?php

use App\Router;
use App\Routing\Redirect;

if (!function_exists('dd')) {
    function dd()
    {
        $args = func_get_args();
        call_user_func_array('dump', $args);
        die();
    }
}

if (!function_exists('redirect')) {
    function redirect()
    {
        $args = func_get_args();

        Redirect::to(...$args);
    }
}

if (!function_exists('route')) {
    function route()
    {
        $args = func_get_args();

        return Router::getRouteByName(...$args);
    }
}

if (!function_exists('path')) {
    function path()
    {
        $arg = func_get_arg(0);

        return constant(strtoupper($arg) . '_PATH');
    }
}

if (!function_exists('envx')) {
    function envx()
    {
        $key = func_get_arg(0);

        if (array_key_exists($key, $_ENV)) {
            return $_ENV[$key];
        }

        if (func_num_args() > 1) {
            return func_get_arg(1);
        }

        throw new Exception("ENV key {$key} not found");
    }
}
