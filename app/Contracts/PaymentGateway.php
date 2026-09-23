<?php

namespace App\Contracts;

interface PaymentGateway
{
    /**
     * Start a payment for the given amount (minor units) and return a
     * redirect/authorization URL (or null for gateways that don't need one).
     *
     * @param  array<string, mixed>  $meta
     */
    public function initialize(int $amountInMinorUnits, string $email, string $reference, array $meta = []): ?string;

    /**
     * Verify a payment reference with the gateway and report whether it succeeded.
     */
    public function verify(string $reference): bool;
}
