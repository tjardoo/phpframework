<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\DB;
use App\View;

class HomeController
{
    public function index(): View
    {
        $db = App::db();

        $users = $db->query('SELECT * FROM users')->fetchAll();

        var_dump($users);

        return View::make('welcome', ['foo' => 'bar']);
    }
}
