<?php

declare(strict_types=1);

return [
    'providers' => [
        \App\Providers\LogServiceProvider::class,
        \App\Providers\DatabaseServiceProvider::class,
        \App\Providers\RoutingServiceProvider::class,
        \App\Providers\ViewServiceProvider::class,
    ],
];
