<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Concerns\PaymentGateway;

class MollieGateway implements PaymentGateway
{
    public function charge(int $amount): bool
    {
        var_dump("Charging {$amount} from Mollie.");

        return true;
    }
}
