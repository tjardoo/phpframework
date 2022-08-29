<?php

declare(strict_types=1);

namespace App\Providers;

use App\Router;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;
use App\Providers\ServiceProvider;
use Twig\TwigFilter;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $loader = new FilesystemLoader(VIEW_PATH);
        $twig = new Environment($loader, [
            'cache' => STORAGE_PATH . '/cache',
            'auto_reload' => true,
        ]);

        $routeNameFunction = new TwigFunction('route', function ($name) {
            return Router::getRouteByName($name);
        });

        $twig->addFunction($routeNameFunction);

        $this->app->container->singleton(Environment::class, fn () => $twig);
    }
}
