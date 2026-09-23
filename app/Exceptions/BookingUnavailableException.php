<?php

namespace App\Exceptions;

use RuntimeException;

class BookingUnavailableException extends RuntimeException
{
    public static function slotTaken(): self
    {
        return new self('That time slot is no longer available. Please choose another time.');
    }

    public static function classFull(): self
    {
        return new self('This class is fully booked. Please choose another session.');
    }

    public static function outsideOpeningHours(): self
    {
        return new self('That time falls outside our opening hours.');
    }
}
