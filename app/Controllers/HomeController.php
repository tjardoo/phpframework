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

            $query = 'INSERT INTO USERS (email, first_name, last_name, is_active)
                VALUES (:email, :firstName, :lastName, :isActive)';

            $statement = $db->prepare($query);

            $statement->execute([
                'email' => 'demo5@example.org',
                'firstName' => 'Demo',
                'lastName' => 'Five',
                'isActive' => true,
            ]);

            $id = $db->lastInsertId();

            var_dump($id);

            // $query = 'SELECT * FROM users';

            // foreach ($db->query($query)->fetchAll() as $user) {
            //     echo '<pre>';
            //     var_dump($user);
            //     echo '</pre>';
            // }
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage(), $exception->getCode());
        }

        return View::make('welcome', ['foo' => 'bar']);
    }
}
