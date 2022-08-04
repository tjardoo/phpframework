<?php

declare(strict_types=1);

namespace App;

use App\Concerns\PaymentGatewayServiceInterface;
use App\Exceptions\RouteNotFoundException;
use App\Services\Payment\MollieGateway;

class App
{
    private static $db;

    public function __construct(
        protected Container $container,
        protected Router $router,
        protected array $request,
        protected Config $config,
    ) {
        static::$db = new DB($config->db ?? []);

        $this->container->set(PaymentGatewayServiceInterface::class, MollieGateway::class);
    }

    public static function db(): DB
    {
        return static::$db;
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
