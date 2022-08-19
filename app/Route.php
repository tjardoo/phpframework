<?php

declare(strict_types=1);

namespace App;

use Closure;
use App\Exceptions\RouteMethodNotSupportedException;

class Route
{
    public string $method;
    public string $uri;
    public Closure|array $action;

    public function __construct(string $method, string $uri, Closure|array $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }

    public static function get(string $uri, Closure|array $action)
    {
        Router::addRoute('get', $uri, $action);
    }

    public static function post(string $uri, Closure|array $action)
    {
        Router::addRoute('post', $uri, $action);
    }

    public static function match(array $methods, string $uri, Closure|array $action)
    {
        foreach ($methods as $method) {
            if (in_array($method, ['get', 'post']) == false) {
                throw new RouteMethodNotSupportedException("Method {$method} not supported. Only get, post are supported.");
            }

            Router::addRoute($method, $uri, $action);
        }
    }
}
