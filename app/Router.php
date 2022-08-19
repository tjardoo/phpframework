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

    public function getRoutes(): array
    {
        return self::$routes;
    }

    public static function addRoute(string $method, string $uri, callable|array $action): void
    {
        $route = new Route($method, $uri, $action);

        self::register($route);
    }

    public static function register(Route $route): void
    {
        $params = [];
        $paramKeys = [];

        preg_match_all("/(?<={).+?(?=})/", $route->uri, $paramMatches);

        if (empty($paramMatches[0])) {
            self::$routes[$route->method][$route->uri] = $route->action;

            return;
        }

        foreach ($paramMatches[0] as $key) {
            $paramKeys[] = $key;
        }

        if (str_starts_with($route->uri, '/')) {
            $route->uri = substr($route->uri, 1);
        }

        $uri = explode('/', $route->uri);

        $indexNumber = [];

        foreach ($uri as $index => $param) {
            if (preg_match('/{.*}/', $param)) {
                $indexNumber[] = $index;
            }
        }

        $requestUri = explode('/', $route->uri);

        foreach ($indexNumber as $key => $index) {
            if (empty($requestUri[$index])) {
                return;
            }

            $params[$paramKeys[$key]] = $requestUri[$index];

            $requestUri[$index] = "{.*}";
        }

        $requestUri = implode("/", $requestUri);

        $requestUri = str_replace("/", '\\/', $requestUri);

        self::$routes[$route->method][$requestUri] = $route->action;
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];

        if (str_ends_with($route, '/')) {
            $route = substr_replace($route, '', -1);
        }

        // if (str_starts_with($route, '/')) {
        //     $route = substr($route, 1);
        // }

        $action = self::$routes[$requestMethod][$route] ?? null;

        if ($action == null) {
            foreach (self::$routes[$requestMethod] as $key=>$value) {
                $pattern = '/' . $key . '/';
                $route = $route;

                if (str_contains($pattern, '{') == false && str_contains($pattern, '}') == false) {
                    continue;
                }

                $pattern = str_replace(['{', '}'], '', $pattern);

                if (preg_match($pattern, $route)) {
                    $action = self::$routes[$requestMethod][$key] ?? null;
                }
            }
        }

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
