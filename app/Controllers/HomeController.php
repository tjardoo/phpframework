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

        $tasks = [
            ['Task 11', null],
            ['Task 12', new DateTime()],
            ['Task 13', null],
        ];

        $user = (new User())
            ->setEmail('demo10@example.org')
            ->setFirstName('Demo')
            ->setLastName('Ten')
            ->setisActive(true);

        foreach ($tasks as [$description, $completedAt]) {
            $task = (new Task())
                ->setDescription($description)
                ->setCompletedAt($completedAt);

            $user->addTask($task);
            $entityManager->persist($task);
        }

        $entityManager->persist($user);

        $entityManager->flush();

        // $user = $entityManager->find(User::class, 1);

        dd($user);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
