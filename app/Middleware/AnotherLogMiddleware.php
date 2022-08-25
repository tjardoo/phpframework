<?php

declare(strict_types=1);

namespace App\Middleware;

use Closure;
use Monolog\Logger;

class AnotherLogMiddleware
{
    public function __construct(
        private Logger $logger,
    ) {
    }

    public function handle($request, Closure $next)
    {
        $this->logger->info('Another log middleware');

        return $next($request);
    }
}
