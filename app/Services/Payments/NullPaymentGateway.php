<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGateway;

/**
 * Default gateway while no payment provider is configured: bookings/orders
 * are recorded as pending payment and settled manually at the studio.
 */
class NullPaymentGateway implements PaymentGateway
{
    public function initialize(int $amountInMinorUnits, string $email, string $reference, array $meta = []): ?string
    {
        return null;
    }

    public function verify(string $reference): bool
    {
        return false;
    }
}
