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
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);

            $query = 'SELECT * FROM users';

            foreach ($db->query($query)->fetchAll() as $user) {
                echo '<pre>';
                var_dump($user);
                echo '</pre>';
            }
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage(), $exception->getCode());
        }

        return View::make('welcome', ['foo' => 'bar']);
    }
}
