<?php

declare(strict_types=1);

namespace App;

use Closure;
use App\Exceptions\RouteMethodNotSupportedException;

class Route
{
    public string $method;
    public string $uri;
    public Closure|array|string $action;
    public array $middleware = [];

    public function __construct(string $method, string $uri, Closure|array|string $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }

    public function middleware(string $name): Route
    {
        array_push($this->middleware, $name);

        $route = Router::addRouteByRoute($this);

        return $route;
    }

    public static function get(string $uri, Closure|array|string $action): Route
    {
        $route = Router::addRoute('get', $uri, $action);

        return $route;
    }

    public static function post(string $uri, Closure|array|string $action): Route
    {
        $route = Router::addRoute('post', $uri, $action);

        return $route;
    }

    public static function match(array $methods, string $uri, Closure|array|string $action): array
    {
        $routes = [];

        foreach ($methods as $method) {
            if (in_array($method, ['get', 'post']) == false) {
                throw new RouteMethodNotSupportedException("Method {$method} not supported. Only get, post are supported.");
            }

            $route = Router::addRoute($method, $uri, $action);

            array_push($routes, $route);
        }

        return $routes;
    }
}
