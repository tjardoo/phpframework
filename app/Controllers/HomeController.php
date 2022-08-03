<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Concerns\PaymentGateway;
use App\Models\User;
use App\Services\Payment\StripeGateway;
use App\View;

class HomeController
{
    public function __construct(
        protected StripeGateway $stripeGateway
    ) {
    }

    public function index(): View
    {
        $user = (new User())->find(1);

        return View::make('welcome', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
