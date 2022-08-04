<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Concerns\PaymentGatewayServiceInterface;

class MollieGateway implements PaymentGatewayServiceInterface
{
    public function charge(int $amount): bool
    {
        var_dump("Charging {$amount} from Mollie.");

        return true;
    }
}
