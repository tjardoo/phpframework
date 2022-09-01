<?php

namespace App\Middleware;

use App\App;
use Closure;
use App\View;

class CheckMaintenanceModeMiddleware
{
    public function __construct(
        private App $app,
    ) {
    }

    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance()) {
            http_response_code(200);

            echo View::make('errors/maintenance')->render();

            exit;
        }

        return $next($request);
    }
}
