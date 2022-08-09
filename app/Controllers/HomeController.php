<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use DateTime;
use App\Config;
use App\Entities\Task;
use App\Entities\User;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;

class HomeController
{
    public function index(): View
    {
        $databaseConfig = (new Config($_ENV))->db;

        $entityManager = EntityManager::create(
            $databaseConfig,
            ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/Entities'])
        );

        $queryBuilder = $entityManager->createQueryBuilder();

        $query = $queryBuilder->select('users.id', 'users.email', 'users.createdAt')
            ->from(User::class, 'users')
            ->where('users.id > :id')
            ->setParameter('id', 2)
            ->orderBy('users.createdAt', 'desc')
            ->getQuery();

        $users = $query->getResult();

        var_dump($query->getDQL());

        dd($users);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
