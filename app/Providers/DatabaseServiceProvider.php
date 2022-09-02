<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $capsule = new Capsule();

        $capsule->addConnection($this->app->config->get('database'));
        // $capsule->setEventDispatcher(new Dispatcher($this->app->container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
