<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class NewBookingReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New booking: '.$this->booking->serviceName())
            ->greeting('New booking received')
            ->line('**Customer:** '.$this->booking->customer->name.' ('.$this->booking->customer->email.')')
            ->line('**Service:** '.$this->booking->serviceName())
            ->line('**Date:** '.Carbon::parse($this->booking->booking_date)->format('l, F j, Y'))
            ->line('**Time:** '.Carbon::parse($this->booking->start_time)->format('g:ia'))
            ->action('View in Admin', route('filament.admin.resources.bookings.edit', $this->booking));
    }
}
