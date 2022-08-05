<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\View;

class HomeController
{
    public function index(): View
    {
        // $users = (new User())->all();
        // dd($users);

        // $user = (new User())->create([
        //     'email' => 'demo9@example.org',
        //     'first_name' => 'Demo',
        //     'last_name' => 'Nine',
        //     'is_active' => 0,
        // ]);

        // dd($user);

        $user = (new User())->find(4);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
