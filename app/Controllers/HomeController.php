<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Task;
use App\Models\User;
use App\View;
use DateTime;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class HomeController
{
    public function index(): View
    {
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setEventDispatcher(new Dispatcher(new Container()));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $user = new User();
        $user->email = 'demo20@example.org';
        $user->first_name = 'Demo';
        $user->last_name = 'Twenty';
        $user->is_active = true;
        $user->created_at = new DateTime();
        $user->save();

        $task = new Task();
        $task->description = 'This is a new task';
        $task->completed_at = new DateTime();

        $task->user()->associate($user);

        $task->save();

        dd($user);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
