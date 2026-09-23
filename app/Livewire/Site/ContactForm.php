<?php

namespace App\Livewire\Site;

use App\Models\ContactMessage;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Component;

class ContactForm extends Component
{
    use WithRateLimiting;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $subject = '';

    public string $message = '';

    public bool $sent = false;

    public ?string $rateLimitMessage = null;

    public function mount(): void
    {
        $this->subject = (string) request()->query('subject', '');
    }

    public function send(): void
    {
        $this->rateLimitMessage = null;

        try {
            $this->rateLimit(5, decaySeconds: 60);
        } catch (TooManyRequestsException $exception) {
            $this->rateLimitMessage = "Too many attempts. Please try again in {$exception->secondsUntilAvailable} seconds.";

            return;
        }

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create($validated);

        $this->reset(['name', 'email', 'phone', 'subject', 'message']);
        $this->sent = true;
    }
}
