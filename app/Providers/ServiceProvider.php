<?php

declare(strict_types=1);

namespace App\Providers;

use App\App;

abstract class ServiceProvider
{
    protected App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
