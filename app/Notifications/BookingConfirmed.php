<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class BookingConfirmed extends Notification implements ShouldQueue
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
            ->subject('Your Body Sculpt Wellness booking is confirmed')
            ->greeting("Hi {$notifiable->name},")
            ->line('Your booking has been received.')
            ->line('**Service:** '.$this->booking->serviceName())
            ->line('**Date:** '.Carbon::parse($this->booking->booking_date)->format('l, F j, Y'))
            ->line('**Time:** '.Carbon::parse($this->booking->start_time)->format('g:ia'))
            ->line('We look forward to seeing you at the studio.')
            ->line('25 Wumego Crescent, Lekki Phase 1, Lagos');
    }
}
