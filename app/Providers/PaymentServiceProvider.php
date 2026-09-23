<?php

namespace App\Providers;

use App\Contracts\PaymentGateway;
use App\Services\Payments\FlutterwaveGateway;
use App\Services\Payments\NullPaymentGateway;
use App\Services\Payments\PaystackGateway;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentGateway::class, function () {
            return match (config('services.payment.driver')) {
                'paystack' => new PaystackGateway(config('services.paystack.secret_key')),
                'flutterwave' => new FlutterwaveGateway(config('services.flutterwave.secret_key')),
                default => new NullPaymentGateway,
            };
        });
    }
}
