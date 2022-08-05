<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Task;
use App\Models\User;
use App\View;

class HomeController
{
    public function index(): View
    {
        // $tasks = (new Task())->all();
        // dd($tasks);

        // $userId = (new Task())->create([
        //     'user_id' => 2,
        //     'description' => 'This is task Five',
        //     'completed_at' => '2022-08-05 00:00:00',
        // ]);

        // dd($userId);

        $user = (new User())->find(4);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
