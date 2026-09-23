<?php

namespace App\Services\Payments;

use App\Contracts\PaymentGateway;

/**
 * Stub Paystack driver. Wire up real HTTP calls once PAYSTACK_SECRET_KEY is
 * issued — the booking/order code only depends on the PaymentGateway contract,
 * so swapping this in is a one-line config change (config('services.payment.driver')).
 */
class PaystackGateway implements PaymentGateway
{
    public function __construct(private readonly ?string $secretKey = null) {}

    public function initialize(int $amountInMinorUnits, string $email, string $reference, array $meta = []): ?string
    {
        throw new \RuntimeException('Paystack is not configured yet. Set PAYSTACK_SECRET_KEY and implement PaystackGateway::initialize().');
    }

    public function verify(string $reference): bool
    {
        throw new \RuntimeException('Paystack is not configured yet. Set PAYSTACK_SECRET_KEY and implement PaystackGateway::verify().');
    }
}
