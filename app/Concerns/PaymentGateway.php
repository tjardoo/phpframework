<?php

declare(strict_types=1);

namespace App\Concerns;

interface PaymentGateway
{
    public function charge(int $amount): bool;
}
