<?php

declare(strict_types=1);

namespace App;

/**
 * @property-read array $config
 */
class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host' => 'localhost',
                'user' => 'root',
                'pass' => '',
                'database' => 'php_framework',
                'driver' => 'mysql',
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
