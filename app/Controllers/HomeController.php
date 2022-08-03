<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\View;

class HomeController
{
    public function index(): View
    {
        $user = new User();

        $lastInsertedUserId = $user->create('demo7@example.org', 'Demo', 'Seven', false);
        $user = $user->find($lastInsertedUserId);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
