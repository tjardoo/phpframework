<?php

declare(strict_types=1);

return [
    'url' => envx('URL', 'localhost:8888'),

    'database' => [
        'driver' => envx('DB_DRIVER'),
        'host' => envx('DB_HOST'),
        'database' => envx('DB_DATABASE'),
        'username' => envx('DB_USER'),
        'password' => envx('DB_PASS'),
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
            'ns_api_key' => envx('NS_API_KEY'),
        ],
    ]
];
