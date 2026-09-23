<?php

namespace App\Livewire\Site;

use App\Models\NewsletterSubscriber;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Component;

class NewsletterForm extends Component
{
    use WithRateLimiting;

    public string $email = '';

    public bool $subscribed = false;

    public ?string $rateLimitMessage = null;

    public function subscribe(): void
    {
        $this->rateLimitMessage = null;

        try {
            $this->rateLimit(5, decaySeconds: 60);
        } catch (TooManyRequestsException $exception) {
            $this->rateLimitMessage = "Too many attempts. Please try again in {$exception->secondsUntilAvailable} seconds.";

            return;
        }

        $this->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        NewsletterSubscriber::query()->firstOrCreate(
            ['email' => $this->email],
            ['is_active' => true, 'subscribed_at' => now()],
        );

        $this->reset('email');
        $this->subscribed = true;
    }
}
