<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\DB;
use App\Models\User;
use App\View;
use Throwable;

class HomeController
{
    public function index(): View
    {
        $user = new User();
        $user = $user->find(1);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
