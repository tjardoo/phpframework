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

        $user = $entityManager->find(User::class, 5);

        $user->setLastName('Five Five');
        $user->getTasks()->get(0)->setDescription('New task description');

        $entityManager->flush();

        dd($user);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
