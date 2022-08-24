<?php

declare(strict_types=1);

namespace App\Providers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Providers\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $loader = new FilesystemLoader(VIEW_PATH);
        $twig = new Environment($loader, [
            'cache' => STORAGE_PATH . '/cache',
        ]);

        $this->app->container->singleton(Environment::class, fn () => $twig);
    }
}
