<?php

declare(strict_types=1);

namespace App;

use App\Concerns\PaymentGateway;
use App\Exceptions\RouteNotFoundException;
use App\Services\Payment\StripeGateway;

class App
{
    private static $db;
    public static Container $container;

    public function __construct(
        protected Router $router,
        protected array $request,
        protected Config $config,
    ) {
        static::$db = new DB($config->db ?? []);
        static::$container = new Container();

        // static::$container->set(PaymentGateway::class, fn () => new StripeGateway());
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
