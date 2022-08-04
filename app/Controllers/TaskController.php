<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;

class TaskController
{
    public function index(): View
    {
        setcookie('demo_cookie', 'love', time() + 86400);

        var_dump($_COOKIE);

        return View::make('tasks/index');
    }
}
