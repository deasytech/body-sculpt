<?php

namespace App\Filament\Widgets;

use App\Enums\MembershipStatus;
use App\Models\Membership;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MembershipOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        return [
            Stat::make('Active Memberships', Membership::query()->where('status', MembershipStatus::Active)->count())
                ->color('success'),
            Stat::make('New This Month', Membership::query()->where('starts_at', '>=', today()->startOfMonth())->count()),
            Stat::make('Expiring Soon', Membership::query()
                ->where('status', MembershipStatus::Active)
                ->whereBetween('ends_at', [today(), today()->addDays(30)])
                ->count())
                ->color('warning'),
        ];
    }
}
