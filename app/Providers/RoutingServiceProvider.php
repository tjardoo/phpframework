<?php

declare(strict_types=1);

namespace App\Providers;

use App\Router;
use App\RouteFileRegistar;
use App\Providers\ServiceProvider;
use App\Route;

class RoutingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->router instanceof Router) {
            $this->registerWebRoutes($this->app->router);
        }
    }

    private function registerWebRoutes(Router $router): void
    {
        (new RouteFileRegistar($router))->register(path('routes') . '/web.php');
    }
}
