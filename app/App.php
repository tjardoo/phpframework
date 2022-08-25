<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;
use Illuminate\Pipeline\Pipeline;
use App\Providers\ServiceProvider;
use Illuminate\Container\Container;
use App\Providers\LogServiceProvider;
use App\Services\DutchRailwayService;
use App\Providers\ViewServiceProvider;
use App\Services\Payment\MollieGateway;
use App\Providers\RoutingServiceProvider;
use App\Exceptions\RouteNotFoundException;
use App\Providers\DatabaseServiceProvider;
use App\Concerns\PaymentGatewayServiceInterface;

class App
{
    public function __construct(
        public Container $container,
        public ?Router $router = null,
        public array $request = [],
    ) {
    }

    public function registerServiceProviders(): void
    {
        $this->register(new LogServiceProvider($this));
        $this->register(new DatabaseServiceProvider($this));
        $this->register(new RoutingServiceProvider($this));
        $this->register(new ViewServiceProvider($this));
    }

    public function registerDirectories(): void
    {
        if (defined('VIEW_PATH') == false) {
            define('VIEW_PATH', __DIR__ . '/../views');
        };

        if (defined('STORAGE_PATH') == false) {
            define('STORAGE_PATH', __DIR__ . '/../storage');
        };

        if (defined('ROUTES_PATH') == false) {
            define('ROUTES_PATH', __DIR__ . '/../routes');
        };

        if (defined('LOG_PATH') == false) {
            define('LOG_PATH', __DIR__ . '/../storage/logs');
        };
    }

    public function register(ServiceProvider $provider): void
    {
        $provider->register();
    }

    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->registerDirectories();

        $this->registerServiceProviders();

        $this->container->singleton(Config::class, fn () => (new Config($_ENV)));

        $this->container->bind(PaymentGatewayServiceInterface::class, MollieGateway::class);
        $this->container->singleton(DutchRailwayService::class, fn () => new DutchRailwayService((new Config($_ENV))->api['ns_api_key']));

        return $this;
    }

    public function run()
    {
        $route = $this->router->resolve($this->request['uri'], strtolower($this->request['method']));

        (new Pipeline($this->container))
            ->send($this->request)
            ->through($this->router->gatherMiddleware($route['middleware'] ?? []))
            ->then(function () use ($route) {
                echo $this->dispatch($route['action'] ?? null, $route['args'] ?? []);
            });
    }

    public function dispatch(callable|array|string|null $action, array $args = [])
    {
        try {
            if ($action == null) {
                throw new RouteNotFoundException();
            }

            if (is_callable($action)) {
                return call_user_func($action, ...$args);
            }

            if (is_array($action)) {
                [$class, $method] = $action;

                if (class_exists($class)) {
                    $class = $this->container->get($class);

                    if (method_exists($class, $method)) {
                        return call_user_func_array([$class, $method], $args);
                    }
                }
            }

            if (is_string($action)) {
                if (class_exists($action)) {
                    $class = $this->container->get($action);

                    return call_user_func($class, ...$args);
                }
            }

            throw new RouteNotFoundException();
        } catch (RouteNotFoundException) {
            http_response_code(404);

            return View::make('errors/404');
        }
    }
}
