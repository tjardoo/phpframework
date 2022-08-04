<?php

use App\App;
use App\Container;
use App\Services\QuoteService;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

(new App($container))->boot();

$container->get(QuoteService::class)->randomQuote();
