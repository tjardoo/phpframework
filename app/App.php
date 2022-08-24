<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;
use App\Providers\ServiceProvider;
use Illuminate\Container\Container;
use App\Providers\LogServiceProvider;
use App\Services\DutchRailwayService;
use App\Providers\ViewServiceProvider;
use App\Services\Payment\MollieGateway;
use App\Providers\RoutingServiceProvider;
use App\Exceptions\RouteNotFoundException;
use App\Concerns\PaymentGatewayServiceInterface;
use App\Providers\DatabaseServiceProvider;

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

    public function register(ServiceProvider $provider): void
    {
        $provider->register();
    }

    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->registerServiceProviders();

        $this->container->singleton(Config::class, fn () => (new Config($_ENV)));

        $this->container->bind(PaymentGatewayServiceInterface::class, MollieGateway::class);
        $this->container->singleton(DutchRailwayService::class, fn () => new DutchRailwayService((new Config($_ENV))->api['ns_api_key']));

        return $this;
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('errors/404');
        }
    }
}
