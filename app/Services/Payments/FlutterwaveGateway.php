<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGateway;

/**
 * Stub Flutterwave driver — see PaystackGateway for the swap-in pattern.
 */
class FlutterwaveGateway implements PaymentGateway
{
    public function __construct(private readonly ?string $secretKey = null) {}

    public function initialize(int $amountInMinorUnits, string $email, string $reference, array $meta = []): ?string
    {
        throw new \RuntimeException('Flutterwave is not configured yet. Set FLUTTERWAVE_SECRET_KEY and implement FlutterwaveGateway::initialize().');
    }

    public function verify(string $reference): bool
    {
        throw new \RuntimeException('Flutterwave is not configured yet. Set FLUTTERWAVE_SECRET_KEY and implement FlutterwaveGateway::verify().');
    }
}
