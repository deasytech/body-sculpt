<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 4;

    protected function getStats(): array
    {
        $returning = Customer::query()->has('bookings', '>=', 2)->count();

        return [
            Stat::make('Total Customers', Customer::query()->count()),
            Stat::make('New This Month', Customer::query()->where('created_at', '>=', today()->startOfMonth())->count()),
            Stat::make('Returning Customers', $returning),
        ];
    }
}
