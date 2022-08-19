<?php

declare(strict_types=1);

namespace App;

class RouteFileRegistar
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function register($routes)
    {
        require $routes;
    }
}
