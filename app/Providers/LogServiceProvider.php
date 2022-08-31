<?php

declare(strict_types=1);

namespace App\Providers;

use Monolog\Logger;
use App\Providers\ServiceProvider;
use Monolog\Handler\StreamHandler;

class LogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->container->singleton(Logger::class, function () {
            $logger = new Logger('main');
            $logger->pushHandler(new StreamHandler(path('log') . '/demo.log'));

            return $logger;
        });
    }
}
