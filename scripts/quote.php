<?php

use App\App;
use App\Concerns\PaymentGatewayServiceInterface;
use App\Services\QuoteService;
use Illuminate\Container\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

(new App($container))->boot();

$container->get(QuoteService::class)->randomQuote();

$container->get(PaymentGatewayServiceInterface::class)->charge(500);
