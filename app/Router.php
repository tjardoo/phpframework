<?php

declare(strict_types=1);

namespace App;

use Illuminate\Container\Container;

class Router
{
    private static array $routes = [];

    public function __construct(
        private Container $container
    ) {
    }

    public function routes(): array
    {
        return self::$routes;
    }

    public static function addRouteByRoute(Route $route): Route
    {
        self::register($route);

        return $route;
    }

    public static function addRoute(string $method, string $uri, callable|array|string $action): Route
    {
        $route = new Route($method, $uri, $action);

        self::register($route);

        return $route;
    }

    public function gatherMiddleware(array $customMiddleware): array
    {
        $baseMiddleware = [
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
            self::$routes[$route->method][$route->uri]['action'] = $route->action;
            self::$routes[$route->method][$route->uri]['middleware'] = $route->middleware;

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

        self::$routes[$route->method][$requestUri]['action'] = $route->action;
        self::$routes[$route->method][$requestUri]['middleware'] = $route->middleware;
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
