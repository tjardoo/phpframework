<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Concerns\PaymentGatewayServiceInterface;
use App\Models\User;
use App\View;

class HomeController
{
    public function index(): View
    {
        $user = (new User())->find(1);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
