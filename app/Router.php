<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNameNotFoundException;
use Closure;
use Illuminate\Container\Container;

class Router
{
    private static array $routes = [];

    public static array $routeNames = [];

    public function __construct(
        public Container $container
    ) {
    }

    public function routes(): array
    {
        return self::$routes;
    }

    public static function routeNames(): array
    {
        return self::$routeNames;
    }

    public static function getRouteByName(string $name): string
    {
        $route = self::$routeNames[$name];

        if ($route == null) {
            throw new RouteNameNotFoundException("Route name '{$name}' not found.");
        }

        return $route;
    }

    public static function addRoute(Route $route): Route
    {
        self::register($route);

        return $route;
    }

    public function gatherMiddleware(array $customMiddleware): array
    {
        $baseMiddleware = [
            \App\Middleware\CheckMaintenanceModeMiddleware::class,
            \App\Middleware\LogMiddleware::class,
        ];

        return array_merge($baseMiddleware, $customMiddleware);
    }

    public static function register(Route $route): void
    {
        $params = [];
        $paramKeys = [];

        preg_match_all("/(?<={).+?(?=})/", $route->uri, $paramMatches);

        if (empty($paramMatches[0])) {
            self::setRoute($route->method, $route->uri, $route);

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

        self::setRoute($route->method, $requestUri, $route);
    }

    private static function setRoute(string $method, string $uri, Route $route)
    {
        self::$routes[$method][$uri]['action'] = $route->action;
        self::$routes[$method][$uri]['middleware'] = $route->middleware;

        if ($route->name != null) {
            self::$routeNames[$route->name] = $uri;
        }
    }

    public function resolve(string $requestUri, string $requestMethod): ?array
    {
        $route = explode('?', $requestUri)[0];


        if (str_ends_with($route, '/') && strlen($route) > 1) {
            $route = substr_replace($route, '', -1);
        }

        if (isset(self::$routes[$requestMethod]) == false) {
            return null;
        }

        $route = self::$routes[$requestMethod][$route] ?? null;

        if (isset($route['action']) == false) {
            foreach (self::$routes[$requestMethod] as $key=>$value) {
                $pattern = '/' . $key . '/';

                if (str_contains($pattern, '{') == false && str_contains($pattern, '}') == false) {
                    continue;
                }

                $pattern = str_replace(['{', '}'], '', $pattern);

                if (preg_match($pattern, $requestUri)) {
                    $route['args'] = $this->getParametersFromUri($key, $requestUri);
                    $route['action'] = self::$routes[$requestMethod][$key]['action'] ?? null;
                    $route['middleware'] = self::$routes[$requestMethod][$key]['middleware'] ?? null;
                }
            }
        }

        return $route;
    }

    private function getParametersFromUri(string $uriDefinition, string $requestUri): array
    {
        $args = [];

        preg_match_all("/(?<={).+?(?=})/", $uriDefinition, $paramMatches);

        if (str_starts_with($uriDefinition, '/')) {
            $uriDefinition = substr($uriDefinition, 1);
        }

        $uri = explode('/', $uriDefinition);

        $indexNumber = [];

        foreach ($uri as $index => $param) {
            if (preg_match('/{.*}/', $param)) {
                $indexNumber[] = $index;
            }
        }

        if (str_starts_with($requestUri, '/')) {
            $requestUri = substr($requestUri, 1);
        }

        $requestUri = explode('/', $requestUri);

        foreach ($indexNumber as $key => $index) {
            array_push($args, $requestUri[$index]);
        }

        return $args;
    }
}
