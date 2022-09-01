<?php

declare(strict_types=1);

namespace App\Providers;

use Monolog\Logger;
use App\Providers\ServiceProvider;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class LogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->container->singleton(Logger::class, function () {
            $logger = new Logger('main');

            $formatter = new LineFormatter(null, null, false, true);
            $handler = new StreamHandler(path('log') . '/application.log');
            $handler->setFormatter($formatter);

            $logger->pushHandler($handler);

            return $logger;
        });
    }

    public function boot(): void
    {
        $logger = $this->app->container->get(Logger::class);

        $logger->debug('Application started');
    }
}
