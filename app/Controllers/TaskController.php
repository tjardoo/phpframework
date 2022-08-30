<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Task;
use Twig\Environment as Twig;

class TaskController
{
    public function __construct(
        private Twig $twig,
    ) {
    }

    public function index(): string
    {
        $tasks = Task::query()->get();

        return $this->twig->render('templates/tasks/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}
