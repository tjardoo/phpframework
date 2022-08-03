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

            $isActive = false;

            $statement->bindValue('email', 'demo5@example.org');
            $statement->bindValue('firstName', 'Demo');
            $statement->bindValue('lastName', 'Five');
            $statement->bindParam('isActive', $isActive, PDO::PARAM_BOOL);

            $isActive = true;

            $statement->execute();

            $id = $db->lastInsertId();

            $user = $db->query('SELECT * FROM users where id = ' . $id)->fetch();

            var_dump($user);
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage(), $exception->getCode());
        }

        return View::make('welcome', ['foo' => 'bar']);
    }
}
