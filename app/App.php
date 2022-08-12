<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;
use App\Services\Payment\MollieGateway;
use App\Exceptions\RouteNotFoundException;
use App\Concerns\PaymentGatewayServiceInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

class App
{
    private Config $config;

    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = [],
    ) {
    }

    public function initDatabase(array $config)
    {
        $capsule = new Capsule();

        $capsule->addConnection($config);
        $capsule->setEventDispatcher(new Dispatcher());
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->config = new Config($_ENV);

        $this->initDatabase($this->config->db);

        $this->container->set(PaymentGatewayServiceInterface::class, MollieGateway::class);

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
