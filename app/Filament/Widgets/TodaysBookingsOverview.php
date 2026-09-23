<?php

namespace App\Filament\Widgets;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TodaysBookingsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = Booking::query()->whereDate('booking_date', today());

        return [
            Stat::make('Total Today', (clone $today)->count()),
            Stat::make('Confirmed', (clone $today)->where('status', BookingStatus::Confirmed)->count())
                ->color('success'),
            Stat::make('Pending', (clone $today)->where('status', BookingStatus::Pending)->count())
                ->color('warning'),
            Stat::make('Completed', (clone $today)->where('status', BookingStatus::Completed)->count())
                ->color('info'),
            Stat::make('Cancelled', (clone $today)->where('status', BookingStatus::Cancelled)->count())
                ->color('danger'),
        ];
    }
}
