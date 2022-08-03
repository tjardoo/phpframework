<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use PDO;
use PDOException;

class HomeController
{
    public function index(): View
    {
        try {
            $db = new PDO('mysql:host=localhost;dbname=php_framework', 'root', '', [

            ]);

            $query = 'SELECT * FROM users';

            $statement = $db->query($query);

            var_dump($statement->fetchAll());
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage(), $exception->getCode());
        }

        return View::make('welcome', ['foo' => 'bar']);
    }
}
