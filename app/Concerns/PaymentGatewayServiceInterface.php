<?php

declare(strict_types=1);

namespace App\Concerns;

interface PaymentGatewayServiceInterface
{
    public function charge(int $amount): bool;
}
