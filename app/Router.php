<?php

declare(strict_types=1);

namespace App;

use Illuminate\Container\Container;
use App\Exceptions\RouteNotFoundException;

class Router
{
    private static array $routes;

    public function __construct(
        private Container $container
    ) {
    }

    public static function addRoute(string $method, string $uri, callable|array $action): void
    {
        $route = new Route($method, $uri, $action);

        self::register($route);
    }

    public static function register(Route $route): void
    {
        self::$routes[$route->method][$route->uri] = $route->action;
    }

    public static function get(string $route, callable|array $action): void
    {
        self::addRoute('get', $route, $action);
    }

    public static function post(string $route, callable|array $action): void
    {
        self::addRoute('post', $route, $action);
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];

        $action = self::$routes[$requestMethod][$route] ?? null;

        if ($action == null) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
                $class = $this->container->get($class);

                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }

        throw new RouteNotFoundException();
    }
}
