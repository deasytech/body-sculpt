<?php

namespace App\Filament\Widgets;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingAppointments extends TableWidget
{
    protected static ?int $sort = 5;

    protected static ?string $heading = 'Upcoming Appointments';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Booking::query()
                ->with(['customer', 'staff', 'bookable'])
                ->upcoming()
                ->orderBy('booking_date')
                ->orderBy('start_time'))
            ->paginated([5])
            ->columns([
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('bookable.name')
                    ->label('Service')
                    ->getStateUsing(fn (Booking $record) => $record->bookable_type === 'treatment'
                        ? $record->bookable?->name
                        : $record->bookable?->pilatesClass?->name),
                TextColumn::make('booking_date')->date()->label('Date'),
                TextColumn::make('start_time')->time('H:i')->label('Time'),
                TextColumn::make('status')->badge()->color(fn (BookingStatus $state) => $state->color()),
            ]);
    }
}
