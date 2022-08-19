<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;
use Twig\Environment;
use Illuminate\Events\Dispatcher;
use Twig\Loader\FilesystemLoader;
use Illuminate\Container\Container;
use App\Services\DutchRailwayService;
use App\Services\Payment\MollieGateway;
use App\Exceptions\RouteNotFoundException;
use App\Concerns\PaymentGatewayServiceInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class App
{
    private Config $config;

    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = [],
    ) {
    }

    private function initDatabase(array $config): void
    {
        $capsule = new Capsule();

        $capsule->addConnection($config);
        $capsule->setEventDispatcher(new Dispatcher($this->container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    private function registerRoutes(Router $router): void
    {
        (new RouteFileRegistar($router))->register(ROUTES_PATH . '/web.php');
    }

    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->config = new Config($_ENV);

        $this->initDatabase($this->config->db);

        $this->registerRoutes($this->router);

        $loader = new FilesystemLoader(VIEW_PATH);
        $twig = new Environment($loader, [
            'cache' => STORAGE_PATH . '/cache',
        ]);

        $this->container->singleton(Environment::class, fn () => $twig);

        $this->container->bind(PaymentGatewayServiceInterface::class, MollieGateway::class);

        $this->container->bind(DutchRailwayService::class, fn () => new DutchRailwayService($this->config->api['ns_api_key']));

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
