<?php

namespace App\Filament\Widgets;

use App\Models\Treatment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class PopularServicesTable extends TableWidget
{
    protected static ?int $sort = 6;

    protected static ?string $heading = 'Popular Services';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Treatment::query()
                ->withCount(['bookings' => fn ($query) => $query->whereNot('status', 'cancelled')])
                ->orderByDesc('bookings_count'))
            ->paginated([5])
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('category.name')->label('Category')->badge(),
                TextColumn::make('bookings_count')->label('Bookings'),
            ]);
    }
}
