<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\View;
use Carbon\Carbon;

class HomeController
{
    public function index(): View
    {
        $user = User::query()
            ->create([
                'email' => 'demo40@example.org',
                'first_name' => 'Demo',
                'last_name' => 'Fourty',
                'is_active' => false,
                // 'created_at' => Carbon::today()->startOfYear(),
            ]);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
