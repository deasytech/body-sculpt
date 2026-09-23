<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Models\Booking;
use App\Models\Order;
use Carbon\CarbonInterface;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make("Today's Revenue", $this->formatNaira($this->revenueSince(today()))),
            Stat::make('This Week', $this->formatNaira($this->revenueSince(today()->startOfWeek()))),
            Stat::make('This Month', $this->formatNaira($this->revenueSince(today()->startOfMonth()))),
        ];
    }

    private function revenueSince(CarbonInterface $date): int
    {
        $bookingRevenue = Booking::query()
            ->where('booking_date', '>=', $date->toDateString())
            ->whereIn('status', ['confirmed', 'completed'])
            ->sum('price');

        $orderRevenue = Order::query()
            ->where('created_at', '>=', $date->toDateTimeString())
            ->whereIn('status', [OrderStatus::Paid, OrderStatus::Fulfilled])
            ->sum('total');

        return (int) $bookingRevenue + (int) $orderRevenue;
    }

    private function formatNaira(int $kobo): string
    {
        return '₦'.number_format($kobo / 100, 2);
    }
}
