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
    public ?string $name = null;

    public function __construct(string $method, string $uri, Closure|array|string $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }

    public function middleware(string $name): Route
    {
        array_push($this->middleware, $name);

        return Router::addRoute($this);
    }

    public function name(string $name): Route
    {
        $this->name = $name;

        return Router::addRoute($this);
    }

    public static function get(string $uri, Closure|array|string $action): Route
    {
        return Router::addRoute(new Route('get', $uri, $action));
    }

    public static function post(string $uri, Closure|array|string $action): Route
    {
        return Router::addRoute(new Route('post', $uri, $action));
    }

    public static function match(array $methods, string $uri, Closure|array|string $action): array
    {
        $routes = [];

        foreach ($methods as $method) {
            if (in_array($method, ['get', 'post']) == false) {
                throw new RouteMethodNotSupportedException("Method {$method} not supported. Only get, post are supported.");
            }

            $route = Router::addRoute(new Route('post', $uri, $action));

            array_push($routes, $route);
        }

        return $routes;
    }
}
