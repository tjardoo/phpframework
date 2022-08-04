<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;

class TaskController
{
    public function index(): View
    {
        $_SESSION['counter'] = ($_SESSION['counter'] ?? 0) + 1;

        var_dump($_SESSION['counter']);

        return View::make('tasks/index');
    }
}
