<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Models\User;
use App\View;
use Throwable;

class HomeController
{
    public function index(): View
    {
        $db = App::db();

        $user = new User();

        try {
            $db->beginTransaction();

            $lastInsertedUserId = $user->create('demo7@example.org', 'Demo', 'Seven', false);

            $db->commit();
        } catch (Throwable $exception) {
            if ($db->inTransaction) {
                $db->rollback();
            }

            throw $exception;
        }

        $user = $user->find($lastInsertedUserId);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
