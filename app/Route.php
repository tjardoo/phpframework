<?php

declare(strict_types=1);

namespace App;

use Closure;

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
        Router::get($uri, $action);
    }
}
