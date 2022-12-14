<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Concerns\PaymentGatewayServiceInterface;

class StripeGateway implements PaymentGatewayServiceInterface
{
    public function charge(int $amount): bool
    {
        var_dump("Charging {$amount} from Stripe.");

        return true;
    }
}
