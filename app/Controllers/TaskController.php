<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Task;
use App\View;

class TaskController
{
    public function index(): View
    {
        $tasks = Task::query()->get();

        dd($tasks);

        return View::make('tasks/index');
    }
}
