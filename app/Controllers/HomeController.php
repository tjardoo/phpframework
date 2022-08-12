<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\View;

class HomeController
{
    public function index(): View
    {
        User::query()
            ->where('id', 1)
            ->update([
                'email' => 'demo30@example.org',
                'last_name' => 'Thirty',
            ]);

        $user = User::query()->findOrFail(1);

        dd($user);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
