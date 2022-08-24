<?php

declare(strict_types=1);

namespace App\Providers;

use App\Config;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $capsule = new Capsule();

        $config = new Config($_ENV);

        $capsule->addConnection($config->db);
        $capsule->setEventDispatcher(new Dispatcher($this->app->container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
