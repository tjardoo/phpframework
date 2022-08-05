<?php

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;

/**
 * @mixin \Doctrine\DBAL\Connection
 */
class DB
{
    private Connection $connection;

    public function __construct(array $config)
    {
        $this->connection = DriverManager::getConnection($config);
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->connection, $name], $arguments);
    }
}
