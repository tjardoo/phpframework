<?php

declare(strict_types=1);

return [
    'url' => $_ENV['URL'] ?? 'localhost:8888',

    'database' => [
        'driver' => $_ENV['DB_DRIVER'],
        'host' => $_ENV['DB_HOST'],
        'database' => $_ENV['DB_DATABASE'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ],

    'providers' => [
        \App\Providers\LogServiceProvider::class,
        \App\Providers\DatabaseServiceProvider::class,
        \App\Providers\RoutingServiceProvider::class,
        \App\Providers\ViewServiceProvider::class,
    ],

    'services' => [
        'api' => [
            'ns_api_key' => $_ENV['NS_API_KEY'],
        ],
    ]
];
