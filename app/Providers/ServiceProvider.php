<?php

declare(strict_types=1);

namespace App\Providers;

use App\App;

abstract class ServiceProvider
{
    public function __construct(
        protected App $app
    ) {
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
